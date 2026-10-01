<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private function currentCartQuery()
    {
        return Cart::where(function ($query) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id())
                    ->orWhere('session_id', session()->getId());
            } else {
                $query->where('session_id', session()->getId());
            }
        });
    }

    private function optionStockError(Product $product, ?string $color, ?string $size, int $quantity): ?string
    {
        if (empty($product->variant_stock)) return null;

        $hasColors = !empty($product->colors);
        $hasSizes = !empty($product->variants);
        if ($hasColors && !$color) return 'Please select a color first.';
        if ($hasSizes && !$size) return 'Please select a size first.';

        if ($hasColors) {
            $validColors = collect($product->colors)->map(fn ($item) => mb_strtolower(trim(explode(':', (string) $item, 2)[0])));
            if (!$validColors->contains(mb_strtolower(trim((string) $color)))) return 'Please select a valid color.';
        }
        if ($hasSizes) {
            $validSizes = collect($product->variants)->pluck('label')->map(fn ($item) => mb_strtolower(trim((string) $item)));
            if (!$validSizes->contains(mb_strtolower(trim((string) $size)))) return 'Please select a valid size.';
        }

        $available = $product->stockForOptions($color, $size) ?? 0;
        return $quantity > $available ? "Only {$available} available for this option." : null;
    }

    public function index()
    {
        $cartItems = $this->currentCartQuery()
            ->with(['product', 'bundle'])
            ->get();

        $total = $cartItems->sum(function ($item) {
            if ($item->bundle_id) {
                return $item->bundle->price * $item->quantity;
            } else {
                return $item->product->price * $item->quantity;
            }
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        try {
            Log::info('Add to cart request', $request->all());

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'selected_color' => 'nullable|string|max:255',
                'selected_size' => 'nullable|string|max:50'
            ]);

            $product = Product::findOrFail($request->product_id);
            $optionStockError = $this->optionStockError($product, $request->selected_color, $request->selected_size, (int) $request->quantity);
            if ($optionStockError) {
                return response()->json(['success' => false, 'message' => $optionStockError], 422);
            }
            $availableSizes = collect($product->variants ?? [])->pluck('label')->map(fn ($size) => (string) $size)->all();
            // Product cards on the landing page support quick-add without choosing a size.
            // When a size is supplied (e.g. on the product page), still validate it.
            if ($request->filled('selected_size') && $availableSizes && !in_array((string) $request->input('selected_size'), $availableSizes, true)) {
                return response()->json(['success' => false, 'message' => 'Please select a valid shoe size.'], 422);
            }
            Log::info('Product found', ['product_id' => $product->id, 'name' => $product->name]);

            // Keep separate cart lines for each selected size and color.
            $cartItem = Cart::where('product_id', $request->product_id)
                ->where('selected_color', $request->selected_color)
                ->where('selected_size', $request->selected_size)
                ->where(function ($query) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        $query->where('session_id', session()->getId());
                    }
                })
                ->first();

            if ($cartItem) {
                $optionStockError = $this->optionStockError($product, $request->selected_color, $request->selected_size, $cartItem->quantity + (int) $request->quantity);
                if ($optionStockError) {
                    return response()->json(['success' => false, 'message' => $optionStockError], 422);
                }
            }

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $cartItem->quantity + $request->quantity
                ]);
                Log::info('Cart item updated', ['cart_id' => $cartItem->id, 'new_quantity' => $cartItem->quantity]);
            } else {
                $cartItem = Cart::create([
                    'user_id' => Auth::id(),
                    'session_id' => session()->getId(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'selected_color' => $request->selected_color,
                    'selected_size' => $request->selected_size
                ]);
                Log::info('New cart item created', ['cart_id' => $cartItem->id]);
            }

            $cartCount = $this->currentCartQuery()->sum('quantity');

            Log::info('Cart operation successful', ['cart_count' => $cartCount]);

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cart_count' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding to cart', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error adding to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Cart $cart)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            $cart->loadMissing('product');
            if ($cart->product) {
                $optionStockError = $this->optionStockError($cart->product, $cart->selected_color, $cart->selected_size, (int) $request->quantity);
                if ($optionStockError) {
                    return response()->json(['success' => false, 'message' => $optionStockError], 422);
                }
            }

            $cart->update(['quantity' => $request->quantity]);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $this->currentCartQuery()->sum('quantity')
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating cart', [
                'error' => $e->getMessage(),
                'cart_id' => $cart->id,
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function remove(Cart $cart)
    {
        try {
            $cart->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $this->currentCartQuery()->sum('quantity')
            ]);
        } catch (\Exception $e) {
            Log::error('Error removing from cart', [
                'error' => $e->getMessage(),
                'cart_id' => $cart->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error removing from cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function count()
    {
        try {
            $count = $this->currentCartQuery()->sum('quantity');

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error('Error getting cart count', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['count' => 0]);
        }
    }

    public function dropdown()
    {
        try {
            $cartItems = $this->currentCartQuery()
                ->with(['product', 'bundle'])
                ->get();

            $items = [];
            $total = 0;

            foreach ($cartItems as $item) {
                if ($item->bundle_id) {
                    $items[] = [
                        'bundle_id' => $item->bundle_id,
                        'bundle_name' => $item->bundle->name,
                        'bundle_image' => \App\Helpers\ImageHelper::getProductImageUrl($item->bundle->image),
                        'quantity' => $item->quantity,
                        'price' => $item->bundle->price * $item->quantity
                    ];
                    $total += $item->bundle->price * $item->quantity;
                } else {
                    $items[] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'product_image' => \App\Helpers\ImageHelper::getProductImageUrl($item->product->image),
                        'quantity' => $item->quantity,
                        'selected_color' => $item->selected_color,
                        'selected_size' => $item->selected_size,
                        'price' => $item->product->price * $item->quantity
                    ];
                    $total += $item->product->price * $item->quantity;
                }
            }

            return response()->json([
                'items' => $items,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting cart dropdown data', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'items' => [],
                'total' => 0
            ]);
        }
    }

    public function addBundle(Request $request)
    {
        try {
            Log::info('Add bundle to cart request', $request->all());

            $request->validate([
                'bundle_id' => 'required|exists:bundles,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $bundle = Bundle::findOrFail($request->bundle_id);
            Log::info('Bundle found', ['bundle_id' => $bundle->id, 'name' => $bundle->name]);

            // Check if bundle already exists in cart
            $cartItem = Cart::where('bundle_id', $request->bundle_id)
                ->where(function ($query) {
                    if (Auth::check()) {
                        $query->where('user_id', Auth::id());
                    } else {
                        $query->where('session_id', session()->getId());
                    }
                })
                ->first();

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $cartItem->quantity + $request->quantity
                ]);
                Log::info('Bundle cart item updated', ['cart_id' => $cartItem->id, 'bundle_id' => $bundle->id, 'new_quantity' => $cartItem->quantity]);
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'session_id' => session()->getId(),
                    'bundle_id' => $request->bundle_id,
                    'quantity' => $request->quantity
                ]);
                Log::info('New bundle cart item created', ['bundle_id' => $bundle->id, 'quantity' => $request->quantity]);
            }

            $cartCount = $this->currentCartQuery()->sum('quantity');

            Log::info('Bundle cart operation successful', ['cart_count' => $cartCount]);

            return response()->json([
                'success' => true,
                'message' => 'Bundle added to cart successfully',
                'cart_count' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding bundle to cart', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error adding bundle to cart: ' . $e->getMessage()
            ], 500);
        }
    }
}
