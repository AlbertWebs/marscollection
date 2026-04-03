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

    public function dashboard()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
            'top_products' => Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(5)->get(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
            'total_bundles' => Bundle::count(),
            'monthly_revenue' => Order::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('total'),
        ];

        return view('admin.dashboard', compact('stats'));
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
        
        $products = $query->latest()->paginate(15)->withQueryString();
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
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_trending'] = $request->boolean('is_trending');
        unset($validated['image']); // never trust validated image — only set from actual file upload

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 's3');
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
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_trending'] = $request->boolean('is_trending');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image from S3 if it exists and is a path (not external URL)
            if ($product->image && !str_starts_with($product->image, 'http')) {
                \Storage::disk('s3')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 's3');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function toggleProductFlag(Request $request, Product $product)
    {
        $request->validate([
            'field' => 'required|in:is_active,is_featured,is_trending',
            'value' => 'required|boolean',
        ]);

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
        $orders = Order::with(['user', 'orderItems.product', 'orderItems.bundle'])->latest()->paginate(15);
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
        $users = User::latest()->paginate(15);
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

    public function categories()
    {
        $categories = Category::query()
            ->withCount('products')
            ->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function brands()
    {
        $brands = Brand::withCount('products')->paginate(15);
        return view('admin.brands.index', compact('brands'));
    }

    public function bundles()
    {
        $bundles = Bundle::withCount('bundleItems')->paginate(15);
        return view('admin.bundles.index', compact('bundles'));
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
        ]);

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
        ]);

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

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('brands', 's3');
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

        if ($request->hasFile('logo')) {
            if ($brand->logo && !str_starts_with($brand->logo, 'http')) {
                \Storage::disk('s3')->delete($brand->logo);
            }
            $validated['logo'] = $request->file('logo')->store('brands', 's3');
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
        
        $services = $query->ordered()->paginate(15)->withQueryString();
        
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
        
        $appointments = $query->latest()->paginate(15)->withQueryString();
        
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
                Mail::to(\App\Models\Setting::get('email_admin', 'admin@zaynsbeauty.com'))->send(new AppointmentConfirmed($appointment));
                
            } catch (\Exception $e) {
                // Log error but don't fail the status update
                \Log::error('Failed to send confirmation emails: ' . $e->getMessage());
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
        ]);

        $settings = $request->except('_token', '_method', 'hero_image', 'video_thumbnail');
        
        // Handle image uploads
        if ($request->hasFile('hero_image')) {
            $heroImagePath = $request->file('hero_image')->store('settings', 's3');
            $settings['hero_image'] = \Storage::disk('s3')->url($heroImagePath);
        }

        if ($request->hasFile('video_thumbnail')) {
            $videoThumbnailPath = $request->file('video_thumbnail')->store('settings', 's3');
            $settings['video_thumbnail'] = \Storage::disk('s3')->url($videoThumbnailPath);
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
        
        $reviews = $query->latest()->paginate(20);
        
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
        
        $contacts = $query->latest()->paginate(15)->withQueryString();
        
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

        $subscribers = $query->latest()->paginate(20)->withQueryString();

        return view('admin.newsletter-subscribers.index', compact('subscribers'));
    }

    public function deleteNewsletterSubscriber(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();

        return redirect()->route('admin.newsletter-subscribers.index')->with('success', 'Newsletter subscriber deleted successfully.');
    }
}
