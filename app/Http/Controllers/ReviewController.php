<?php

namespace App\Http\Controllers;

use App\Models\ReviewLink;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function show($token)
    {
        $reviewLink = ReviewLink::where('unique_token', $token)->first();
        
        if (!$reviewLink) {
            abort(404, 'Review link not found');
        }

        if (!$reviewLink->isValid()) {
            abort(410, 'This review link has expired or has already been used');
        }

        $order = $reviewLink->order;
        
        // Get items that can be reviewed (products and bundles)
        $reviewableItems = [];
        
        foreach ($order->items as $item) {
            if ($item->product) {
                $reviewableItems[] = [
                    'type' => 'product',
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'image' => $item->product->image,
                    'quantity' => $item->quantity,
                    'already_reviewed' => $order->reviews()->where('product_id', $item->product->id)->exists()
                ];
            }
            
            if ($item->bundle) {
                $reviewableItems[] = [
                    'type' => 'bundle',
                    'id' => $item->bundle->id,
                    'name' => $item->bundle->name,
                    'image' => $item->bundle->image,
                    'quantity' => $item->quantity,
                    'already_reviewed' => $order->reviews()->where('bundle_id', $item->bundle->id)->exists()
                ];
            }
        }

        return view('reviews.create', compact('reviewLink', 'order', 'reviewableItems'));
    }

    public function store(Request $request, $token)
    {
        $reviewLink = ReviewLink::where('unique_token', $token)->first();
        
        if (!$reviewLink || !$reviewLink->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired review link'
            ], 400);
        }

        $request->validate([
            'reviewable_type' => 'required|in:product,bundle',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $order = $reviewLink->order;
        
        // Check if already reviewed (using order_id instead of user_id)
        $existingReview = Review::where('order_id', $order->id)
            ->where($request->reviewable_type . '_id', $request->reviewable_id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this item'
            ], 400);
        }

        try {
            $review = Review::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id, // This can be null
                'product_id' => $request->reviewable_type === 'product' ? $request->reviewable_id : null,
                'bundle_id' => $request->reviewable_type === 'bundle' ? $request->reviewable_id : null,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_approved' => false
            ]);

            // Update review statistics for the reviewed item
            if ($request->reviewable_type === 'product') {
                $product = \App\Models\Product::find($request->reviewable_id);
                if ($product) {
                    $product->updateReviewStatistics();
                }
            } elseif ($request->reviewable_type === 'bundle') {
                $bundle = \App\Models\Bundle::find($request->reviewable_id);
                if ($bundle) {
                    $bundle->updateReviewStatistics();
                }
            }

            Log::info('Review submitted', [
                'review_id' => $review->id,
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'reviewable_type' => $request->reviewable_type,
                'reviewable_id' => $request->reviewable_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error submitting review', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'order_id' => $order->id,
                'user_id' => $order->user_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error submitting review. Please try again.'
            ], 500);
        }
    }

    public function complete($token)
    {
        $reviewLink = ReviewLink::where('unique_token', $token)->first();
        
        if (!$reviewLink) {
            abort(404, 'Review link not found');
        }

        // Mark the review link as used
        $reviewLink->update(['is_used' => true]);

        return view('reviews.complete', compact('reviewLink'));
    }
}
