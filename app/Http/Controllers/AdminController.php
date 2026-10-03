<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Bundle;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\BookingSetting;
use App\Models\Setting;
use App\Models\Review;
use App\Models\Contact;
use App\Models\NewsletterSubscriber;
use App\Models\TrafficVisit;
use App\Mail\AppointmentConfirmed;
use App\Mail\ReviewLinkEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    private function productImageDisk(): string
    {
        return config('filesystems.default') === 's3' ? 's3' : 'public';
    }

    public function dashboard()
    {
        $analytics = $this->dashboardAnalyticsData();
        $stats = [
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_revenue' => Order::whereIn('status', ['delivered', 'completed'])->sum('total'),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
            'top_products' => Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(5)->get(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
            'total_bundles' => Bundle::count(),
            'monthly_revenue' => Order::whereIn('status', ['delivered', 'completed'])
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total'),
        ];

        return view('admin.dashboard', compact('stats', 'analytics'));
    }

    public function dashboardAnalytics()
    {
        return response()->json($this->dashboardAnalyticsData());
    }

    private function dashboardAnalyticsData(): array
    {
        $now = now();
        $start = $now->copy()->startOfDay()->subDays(6);
        $end = $now->copy()->endOfDay();

        $ordersByDay = Order::whereBetween('created_at', [$start, $end])
            ->selectRaw("DATE(created_at) as day, COUNT(*) as orders_count, COALESCE(SUM(CASE WHEN status IN ('delivered', 'completed') THEN total ELSE 0 END), 0) as revenue")
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $trafficByDay = TrafficVisit::whereBetween('visited_at', [$start, $end])
            ->selectRaw('DATE(visited_at) as day, COUNT(*) as page_views, COUNT(DISTINCT visitor_key) as visitors')
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $daily = [];
        for ($offset = 0; $offset < 7; $offset++) {
            $date = $start->copy()->addDays($offset);
            $key = $date->toDateString();
            $orderRow = $ordersByDay->get($key);
            $trafficRow = $trafficByDay->get($key);
            $daily[] = [
                'date' => $key,
                'label' => $date->format('D'),
                'orders' => (int) ($orderRow->orders_count ?? 0),
                'revenue' => (float) ($orderRow->revenue ?? 0),
                'visitors' => (int) ($trafficRow->visitors ?? 0),
                'page_views' => (int) ($trafficRow->page_views ?? 0),
            ];
        }

        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();
        $trafficToday = TrafficVisit::whereBetween('visited_at', [$todayStart, $todayEnd]);
        $ordersToday = Order::whereBetween('created_at', [$todayStart, $todayEnd]);
        $confirmedStatuses = ['delivered', 'completed'];

        return [
            'updated_at' => $now->toIso8601String(),
            'metrics' => [
                'orders_today' => (clone $ordersToday)->count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'revenue_today' => (clone $ordersToday)->whereIn('status', $confirmedStatuses)->sum('total'),
                'revenue_total' => Order::whereIn('status', $confirmedStatuses)->sum('total'),
                'visitors_today' => (clone $trafficToday)->distinct('visitor_key')->count('visitor_key'),
                'page_views_today' => (clone $trafficToday)->count(),
                'active_visitors' => TrafficVisit::where('visited_at', '>=', $now->copy()->subMinutes(5))
                    ->distinct('visitor_key')->count('visitor_key'),
                'total_users' => User::count(),
                'products' => Product::where('is_active', true)->count(),
            ],
            'daily' => $daily,
            'order_status' => Order::selectRaw('status, COUNT(*) as total')->groupBy('status')->get()
                ->map(fn ($row) => ['status' => ucfirst($row->status), 'count' => (int) $row->total])->values(),
            'top_pages' => TrafficVisit::whereBetween('visited_at', [$start, $end])
                ->selectRaw('path, COUNT(*) as views')->groupBy('path')->orderByDesc('views')->limit(5)->get()
                ->map(fn ($row) => ['path' => $row->path, 'views' => (int) $row->views])->values(),
        ];
    }

    public function products(Request $request)
    {
        $query = Product::with(['category', 'brand']);
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('brand', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by brand
        if ($request->has('brand') && $request->brand) {
            $query->where('brand_id', $request->brand);
        }
        
        $products = $query->latest()->paginate(50)->withQueryString();
        $categories = Category::all();
        $brands = Brand::all();
        
        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'meta_description' => 'nullable|string|max:320',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category_id'    => 'required|exists:categories,id',
            'brand_id'       => 'required|exists:brands,id',
            'stock_quantity' => 'required|integer|min:0',
            'sku'            => 'nullable|string|max:100|unique:products,sku',
            'badge'          => 'nullable|string|max:50',
            'badge_color'    => 'nullable|string|max:50',
            'is_active'      => 'boolean',
            'is_featured'    => 'boolean',
            'is_trending'    => 'boolean',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'colors'         => 'nullable|string',
            'extra_images'   => 'nullable|array|max:8',
            'extra_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_trending'] = $request->boolean('is_trending');
        unset($validated['image']); // Never trust validated image. Only set from actual file upload.
        unset($validated['extra_images']); // handle separately below

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', $this->productImageDisk());
        }

        if ($request->filled('colors')) {
            $validated['colors'] = array_map('trim', explode(',', $request->colors));
        }

        // Handle extra images upload
        if ($request->hasFile('extra_images')) {
            $extraPaths = [];
            foreach ($request->file('extra_images') as $file) {
                $extraPaths[] = $file->store('products', $this->productImageDisk());
            }
            $validated['extra_images'] = $extraPaths;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'meta_description' => 'nullable|string|max:320',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category_id'    => 'required|exists:categories,id',
            'brand_id'       => 'required|exists:brands,id',
            'stock_quantity' => 'required|integer|min:0',
            'sku'            => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'badge'          => 'nullable|string|max:50',
            'badge_color'    => 'nullable|string|max:50',
            'is_active'      => 'boolean',
            'is_featured'    => 'boolean',
            'is_trending'    => 'boolean',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'colors'         => 'nullable|string',
            'extra_images'   => 'nullable|array|max:8',
            'extra_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_extra_images' => 'nullable|array',
            'delete_extra_images.*' => 'string',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_trending'] = $request->boolean('is_trending');

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image from S3 if it exists and is a path (not external URL)
            if ($product->image && !str_starts_with($product->image, 'http') && !str_starts_with($product->image, '/')) {
                \Storage::disk($this->productImageDisk())->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', $this->productImageDisk());
            $validated['image'] = $imagePath;
        } elseif ($request->input('clear_image') === '1') {
            // User explicitly removed the main image
            if ($product->image && !str_starts_with($product->image, 'http') && !str_starts_with($product->image, '/')) {
                \Storage::disk($this->productImageDisk())->delete($product->image);
            }
            $validated['image'] = null;
        }

        if ($request->filled('colors')) {
            $validated['colors'] = array_map('trim', explode(',', $request->colors));
        } else {
            $validated['colors'] = null;
        }

        // Extra images: keep only the ones the form sent back, plus any new uploads
        $keepPaths = $request->input('keep_extra_images', []);

        // Delete any existing extras that were NOT in keep list
        foreach ($product->extra_images ?? [] as $existing) {
            if (!in_array($existing, $keepPaths)) {
                if (!str_starts_with($existing, 'http') && !str_starts_with($existing, '/')) {
                    \Storage::disk($this->productImageDisk())->delete($existing);
                }
            }
        }

        // Upload new extra images and append to kept ones
        $newExtras = [];
        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $file) {
                $newExtras[] = $file->store('products', $this->productImageDisk());
            }
        }

        $allExtras = array_values(array_merge($keepPaths, $newExtras));
        $validated['extra_images'] = !empty($allExtras) ? $allExtras : null;
        unset($validated['delete_extra_images']);
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function toggleProductFlag(Request $request, $productId)
    {
        $request->validate([
            'field' => 'required|in:is_active,is_featured,is_trending',
            'value' => 'required|boolean',
        ]);

        $product = Product::findOrFail($productId);
        $product->update([$request->field => $request->value]);

        return response()->json(['success' => true, 'value' => (bool) $product->{$request->field}]);
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $validated['product_ids'])->get();
        $count = $products->count();

        switch ($validated['action']) {
            case 'activate':
                $products->each(function($product) {
                    $product->update(['is_active' => true]);
                });
                $message = "{$count} product(s) activated successfully!";
                break;
                
            case 'deactivate':
                $products->each(function($product) {
                    $product->update(['is_active' => false]);
                });
                $message = "{$count} product(s) deactivated successfully!";
                break;
                
            case 'delete':
                $products->each(function($product) {
                    $product->delete();
                });
                $message = "{$count} product(s) deleted successfully!";
                break;
        }

        return redirect()->route('admin.products.index')->with('success', $message);
    }

    public function orders()
    {
        $orders = Order::with(['user', 'orderItems.product', 'orderItems.bundle'])->latest()->paginate(50);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'orderItems.bundle.products']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        // Generate review link when order is marked as delivered
        if ($validated['status'] === 'delivered' && $oldStatus !== 'delivered') {
            $this->generateReviewLink($order);
        }

        // Notify customer on shipped or cancelled status
        if ($order->status !== $oldStatus && in_array($order->status, ['shipped', 'cancelled'])) {
            try {
                \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderStatusUpdated($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send order status updated email: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully!');
    }

    private function generateReviewLink(Order $order)
    {
        try {
            // Check if review link already exists
            if ($order->reviewLink) {
                return;
            }

            $reviewLink = \App\Models\ReviewLink::create([
                'order_id' => $order->id,
                'unique_token' => \App\Models\ReviewLink::generateToken(),
                'email' => $order->customer_email,
                'expires_at' => now()->addDays(30) // Expires in 30 days
            ]);

            // Send email with review link
            $this->sendReviewLinkEmail($order, $reviewLink);

            \Log::info('Review link generated', [
                'order_id' => $order->id,
                'review_link_id' => $reviewLink->id,
                'token' => $reviewLink->unique_token
            ]);

        } catch (\Exception $e) {
            \Log::error('Error generating review link', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function sendReviewLinkEmail(Order $order, \App\Models\ReviewLink $reviewLink)
    {
        try {
            // Send the review link email to the customer
            Mail::to($order->customer_email)->send(new ReviewLinkEmail($order, $reviewLink));
            
            \Log::info('Review link email sent successfully', [
                'to' => $order->customer_email,
                'order_number' => $order->order_number,
                'review_link_id' => $reviewLink->id
            ]);

        } catch (\Exception $e) {
            \Log::error('Error sending review link email', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function users()
    {
        $users = User::latest()->paginate(50);
        return view('admin.users.index', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->isAdmin()) {
            $user->removeAdmin();
            $message = 'Admin privileges removed successfully!';
        } else {
            $user->makeAdmin();
            $message = 'Admin privileges granted successfully!';
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    public function categories(Request $request)
    {
        $status = in_array($request->query('status'), ['active', 'inactive'], true) ? $request->query('status') : 'active';
        $categories = Category::query()
            ->withCount(['products as products_count' => fn ($query) => $query->where('is_active', true)])
            ->when($status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('sort_order')->orderBy('name')
            ->paginate(50);
        $catalogCounts = [
            'active' => Category::where('is_active', true)->count(),
            'inactive' => Category::where('is_active', false)->count(),
            'products' => Product::where('is_active', true)->count(),
        ];
        return view('admin.categories.index', compact('categories', 'catalogCounts', 'status'));
    }

    public function brands(Request $request)
    {
        $status = in_array($request->query('status'), ['active', 'inactive'], true) ? $request->query('status') : 'active';
        $brands = Brand::query()
            ->withCount(['products as products_count' => fn ($query) => $query->where('is_active', true)])
            ->when($status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('name')
            ->paginate(50);
        $catalogCounts = [
            'active' => Brand::where('is_active', true)->count(),
            'inactive' => Brand::where('is_active', false)->count(),
            'products' => Product::where('is_active', true)->count(),
        ];
        return view('admin.brands.index', compact('brands', 'catalogCounts', 'status'));
    }

    public function bundles(Request $request)
    {
        $status = $request->query('status') === 'inactive' ? 'inactive' : 'active';
        $bundles = Bundle::query()
            ->withCount('bundleItems')
            ->where('is_active', $status === 'active')
            ->latest()
            ->paginate(50);
        $pairingCounts = [
            'active' => Bundle::where('is_active', true)->count(),
            'inactive' => Bundle::where('is_active', false)->count(),
        ];
        return view('admin.bundles.index', compact('bundles', 'pairingCounts', 'status'));
    }

    // Categories CRUD
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', $this->productImageDisk());
        }
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? ((int) Category::max('sort_order') + 1);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);
        if ($request->hasFile('image')) {
            if ($category->image && !str_starts_with($category->image, 'http') && !str_starts_with($category->image, '/')) {
                \Storage::disk($this->productImageDisk())->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', $this->productImageDisk());
        }
        $validated['sort_order'] = $validated['sort_order'] ?? $category->sort_order;
        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function deleteCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category with associated products.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }

    // Brands CRUD
    public function createBrand()
    {
        return view('admin.brands.create');
    }

    public function storeBrand(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', $this->productImageDisk());
        }

        Brand::create($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
    }

    public function editBrand(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function updateBrand(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $disk = $this->productImageDisk();
            if ($brand->logo && !str_starts_with($brand->logo, 'http') && !str_starts_with($brand->logo, '/')) {
                \Storage::disk($disk)->delete($brand->logo);
            }
            $validated['logo'] = $request->file('logo')->store('brands', $disk);
        }

        $brand->update($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully!');
    }

    public function deleteBrand(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')->with('error', 'Cannot delete brand with associated products.');
        }

        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully!');
    }

    // Product Search API for Bundles
    public function searchProducts(Request $request)
    {
        $query = $request->get('q', '');
        $page = $request->get('page', 1);
        $perPage = 20;
        
        $products = Product::where('is_active', true)
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', "%{$query}%")
                        ->orWhereHas('brand', function ($brandQuery) use ($query) {
                            $brandQuery->where('name', 'like', "%{$query}%");
                        })
                        ->orWhereHas('category', function ($categoryQuery) use ($query) {
                            $categoryQuery->where('name', 'like', "%{$query}%");
                        });
            })
            ->with(['brand', 'category'])
            ->orderBy('name')
            ->paginate($perPage, ['*'], 'page', $page);
        
        return response()->json([
            'products' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'has_more' => $products->hasMorePages()
            ]
        ]);
    }

    // Bundles CRUD
    public function createBundle()
    {
        return view('admin.bundles.create');
    }

    public function storeBundle(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ]);

        $bundle = Bundle::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        foreach ($validated['products'] as $productId) {
            $bundle->bundleItems()->create([
                'product_id' => $productId,
            ]);
        }

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle created successfully!');
    }

    public function editBundle(Bundle $bundle)
    {
        $bundle->load('bundleItems.product');
        return view('admin.bundles.edit', compact('bundle'));
    }

    public function updateBundle(Request $request, Bundle $bundle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ]);

        $bundle->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        // Update bundle items
        $bundle->bundleItems()->delete();
        foreach ($validated['products'] as $productId) {
            $bundle->bundleItems()->create([
                'product_id' => $productId,
            ]);
        }

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle updated successfully!');
    }

    public function deleteBundle(Bundle $bundle)
    {
        $bundle->bundleItems()->delete();
        $bundle->delete();
        return redirect()->route('admin.bundles.index')->with('success', 'Bundle deleted successfully!');
    }

    // Services Management
    public function services(Request $request)
    {
        $query = Service::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status === 'active');
        }
        
        $services = $query->ordered()->paginate(50)->withQueryString();
        
        return view('admin.services.index', compact('services'));
    }

    public function createService()
    {
        return view('admin.services.create');
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        Service::create($validated);
        
        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function editService(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function updateService(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $service->update($validated);
        
        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function deleteService(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }

    // Appointments Management
    public function appointments(Request $request)
    {
        $query = Appointment::with('service');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('appointment_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->where('appointment_date', '<=', $request->date_to);
        }
        
        $appointments = $query->latest()->paginate(50)->withQueryString();
        
        return view('admin.appointments.index', compact('appointments'));
    }

    public function showAppointment(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $appointment->status;
        $appointment->update($validated);
        
        // Send confirmation email when status changes to confirmed
        if ($validated['status'] === 'confirmed' && $oldStatus !== 'confirmed') {
            try {
                // Send confirmation email to client
                Mail::to($appointment->customer_email)->send(new AppointmentConfirmed($appointment));
                
                // Send notification to admin
                Mail::to(\App\Models\Setting::get('email_admin', 'admin@marscollection.co.ke'))->send(new AppointmentConfirmed($appointment));
                
            } catch (\Exception $e) {
                // Log error but don't fail the status update
                \Illuminate\Support\Facades\Log::error('Failed to send confirmation emails: ' . $e->getMessage());
            }
        }
        
        // Send cancellation email when status changes to cancelled
        if ($validated['status'] === 'cancelled' && $oldStatus !== 'cancelled') {
            try {
                // Send cancellation email to client
                Mail::to($appointment->customer_email)->send(new \App\Mail\AppointmentCancelled($appointment));
            } catch (\Exception $e) {
                // Log error but don't fail the status update
                \Illuminate\Support\Facades\Log::error('Failed to send cancellation emails: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('admin.appointments.show', $appointment)->with('success', 'Appointment status updated successfully.');
    }

    // Settings Management
        public function settings()
    {
        $contactSettings = Setting::getByGroup('contact');
        $businessSettings = Setting::getByGroup('business');
        $emailSettings = Setting::getByGroup('email');
        $socialSettings = Setting::getByGroup('social');
        $heroSettings = Setting::getByGroup('hero');
        $videoSettings = Setting::getByGroup('video');
        $bannerSettings = Setting::getByGroup('banner');

        return view('admin.settings.index', compact('contactSettings', 'businessSettings', 'emailSettings', 'socialSettings', 'heroSettings', 'videoSettings', 'bannerSettings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'brand_logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'brand_favicon' => 'nullable|image|mimes:png|max:2048|dimensions:min_width=64,min_height=64,max_width=1024,max_height=1024,ratio=1/1',
        ]);

        $settings = $request->except('_token', '_method', 'hero_image', 'video_thumbnail', 'brand_logo', 'brand_favicon');
        
        // Handle image uploads
        if ($request->hasFile('hero_image')) {
            $heroImagePath = $request->file('hero_image')->store('settings', 's3');
            $settings['hero_image'] = \Storage::disk('s3')->url($heroImagePath);
        }

        if ($request->hasFile('video_thumbnail')) {
            $videoThumbnailPath = $request->file('video_thumbnail')->store('settings', 's3');
            $settings['video_thumbnail'] = \Storage::disk('s3')->url($videoThumbnailPath);
        }

        $disk = $this->productImageDisk();
        foreach (['brand_logo', 'brand_favicon'] as $brandingKey) {
            if (!$request->hasFile($brandingKey)) {
                continue;
            }

            $previousPath = Setting::get($brandingKey);
            $newPath = $request->file($brandingKey)->store('branding', $disk);
            Setting::set($brandingKey, $newPath, $brandingKey === 'brand_logo' ? 'Brand logo' : 'Brand favicon', 'branding', 'image');

            if ($previousPath && !str_starts_with($previousPath, 'http') && !str_starts_with($previousPath, '/') && $previousPath !== $newPath) {
                \Storage::disk($disk)->delete($previousPath);
            }
        }
        
        foreach ($settings as $key => $value) {
            // Handle boolean settings (checkboxes)
            if (in_array($key, ['hero_enabled', 'video_enabled'])) {
                $value = $value ? '1' : '0';
            }
            
            // Always update the setting, even if value is null or empty
            Setting::updateValue($key, $value ?? '');
        }
        
        // Handle unchecked checkboxes by setting them to '0'
        $checkboxSettings = ['hero_enabled', 'video_enabled', 'banner_enabled'];
        foreach ($checkboxSettings as $checkboxKey) {
            if (!array_key_exists($checkboxKey, $settings)) {
                Setting::updateValue($checkboxKey, '0');
            }
        }
        
        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }

    // Booking Settings Management
    public function bookingSettings()
    {
        $bookingSettings = BookingSetting::orderBy('day_of_week')->get();
        $days = [
            1 => 'Monday',
            2 => 'Tuesday', 
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];
        
        return view('admin.booking-settings.index', compact('bookingSettings', 'days'));
    }

    public function updateBookingSettings(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.day_of_week' => 'required|integer|between:1,7',
            'settings.*.is_disabled' => 'boolean',
            'settings.*.business_hours_start' => 'nullable|date_format:H:i',
            'settings.*.business_hours_end' => 'nullable|date_format:H:i',
            'settings.*.slot_duration' => 'required|integer|min:15|max:240',
            'settings.*.break_start' => 'nullable|date_format:H:i',
            'settings.*.break_end' => 'nullable|date_format:H:i',
            'settings.*.disabled_hours' => 'nullable|array',
            'settings.*.disabled_hours.*' => 'date_format:H:i',
        ]);

        foreach ($validated['settings'] as $setting) {
            BookingSetting::updateOrCreate(
                ['day_of_week' => $setting['day_of_week']],
                [
                    'is_disabled' => $setting['is_disabled'] ?? false,
                    'business_hours_start' => $setting['business_hours_start'],
                    'business_hours_end' => $setting['business_hours_end'],
                    'slot_duration' => $setting['slot_duration'],
                    'break_start' => $setting['break_start'],
                    'break_end' => $setting['break_end'],
                    'disabled_hours' => $setting['disabled_hours'] ?? [],
                ]
            );
        }

        return redirect()->route('admin.booking-settings.index')->with('success', 'Booking settings updated successfully.');
    }

    // Reviews Management
    public function reviews(Request $request)
    {
        $query = Review::with(['order', 'product', 'bundle']);
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('order', function($orderQuery) use ($search) {
                    $orderQuery->where('customer_name', 'like', "%{$search}%")
                              ->orWhere('customer_email', 'like', "%{$search}%");
                })
                ->orWhereHas('product', function($productQuery) use ($search) {
                    $productQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('bundle', function($bundleQuery) use ($search) {
                    $bundleQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }
        
        $reviews = $query->latest()->paginate(50);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approveReview(Request $request, Review $review)
    {
        $review->update(['is_approved' => true]);
        
        // Update review statistics for the reviewed item
        if ($review->product) {
            $review->product->updateReviewStatistics();
        } elseif ($review->bundle) {
            $review->bundle->updateReviewStatistics();
        }
        
        return redirect()->route('admin.reviews.index')->with('success', 'Review approved successfully!');
    }

    public function deleteReview(Review $review)
    {
        $review->delete();
        
        // Update review statistics for the reviewed item
        if ($review->product) {
            $review->product->updateReviewStatistics();
        } elseif ($review->bundle) {
            $review->bundle->updateReviewStatistics();
        }
        
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully!');
    }

    // Contact Messages Management
    public function contacts(Request $request)
    {
        $query = Contact::query();
        
        // Filter by type (legitimate vs bots)
        if ($request->has('type') && $request->type !== '') {
            if ($request->type === 'legitimate') {
                $query->legitimate();
            } elseif ($request->type === 'bots') {
                $query->bots();
            }
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        $contacts = $query->latest()->paginate(50)->withQueryString();
        
        return view('admin.contacts.index', compact('contacts'));
    }

    public function showContact(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function deleteContact(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Contact message deleted successfully.');
    }

    public function newsletterSubscribers(Request $request)
    {
        $query = NewsletterSubscriber::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('email', 'like', "%{$search}%");
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status === 'active');
        }

        $subscribers = $query->latest()->paginate(50)->withQueryString();

        return view('admin.newsletter-subscribers.index', compact('subscribers'));
    }

    public function deleteNewsletterSubscriber(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();

        return redirect()->route('admin.newsletter-subscribers.index')->with('success', 'Newsletter subscriber deleted successfully.');
    }
}
