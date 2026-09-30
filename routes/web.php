<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TrafficController;

// Home and general pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');
Route::post('/traffic/heartbeat', [TrafficController::class, 'heartbeat'])->middleware('throttle:60,1')->name('traffic.heartbeat');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Sitemap
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');

// Policy pages
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-of-service', [HomeController::class, 'termsOfService'])->name('terms-of-service');
Route::get('/shipping-info', [HomeController::class, 'shippingInfo'])->name('shipping-info');
Route::get('/returns-policy', [HomeController::class, 'returnsPolicy'])->name('returns-policy');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/trending', [ProductController::class, 'trending'])->name('products.trending');
Route::get('/products/featured', [ProductController::class, 'featured'])->name('products.featured');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Brands
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');

// Bundles
Route::get('/bundles', [BundleController::class, 'index'])->name('bundles.index');
Route::get('/bundles/featured', [BundleController::class, 'featured'])->name('bundles.featured');
Route::get('/bundles/trending', [BundleController::class, 'trending'])->name('bundles.trending');
Route::get('/bundles/{bundle}', [BundleController::class, 'show'])->name('bundles.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/add-bundle', [CartController::class, 'addBundle'])->name('cart.add-bundle');
Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::get('/cart/dropdown', [CartController::class, 'dropdown'])->name('cart.dropdown');

// Checkout
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

// Appointment booking belonged to the previous service business. Direct users to shoe support.
Route::redirect('/appointments/book', '/contact')->name('appointments.create');
Route::post('/appointments', fn () => redirect()->route('contact'))->name('appointments.store');
Route::redirect('/appointments/success', '/contact')->name('appointments.success');
Route::redirect('/appointments/calendar', '/contact')->name('appointments.calendar');
Route::post('/appointments/check-availability', fn () => redirect()->route('contact'))->name('appointments.check-availability');
Route::redirect('/appointments/available-slots', '/contact')->name('appointments.available-slots');

// Reviews
Route::get('/reviews/{token}', [ReviewController::class, 'show'])->name('reviews.show');
Route::post('/reviews/{token}', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{token}/complete', [ReviewController::class, 'complete'])->name('reviews.complete');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard/analytics', [AdminController::class, 'dashboardAnalytics'])->name('dashboard.analytics');
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products Management
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.destroy');
    Route::post('/products/bulk-action', [AdminController::class, 'bulkAction'])->name('products.bulk-action');
    Route::patch('/products/{product}/toggle-flag', [AdminController::class, 'toggleProductFlag'])->name('products.toggle-flag');
    
    // Orders Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    
    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::put('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggle-admin');
    
    // Categories Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.destroy');
    
    // Brands Management
    Route::get('/brands', [AdminController::class, 'brands'])->name('brands.index');
    Route::get('/brands/create', [AdminController::class, 'createBrand'])->name('brands.create');
    Route::post('/brands', [AdminController::class, 'storeBrand'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [AdminController::class, 'editBrand'])->name('brands.edit');
    Route::put('/brands/{brand}', [AdminController::class, 'updateBrand'])->name('brands.update');
    Route::delete('/brands/{brand}', [AdminController::class, 'deleteBrand'])->name('brands.destroy');
    
    // Bundles Management
    Route::get('/bundles', [AdminController::class, 'bundles'])->name('bundles.index');
    Route::get('/bundles/create', [AdminController::class, 'createBundle'])->name('bundles.create');
    Route::post('/bundles', [AdminController::class, 'storeBundle'])->name('bundles.store');
    Route::get('/bundles/{bundle}/edit', [AdminController::class, 'editBundle'])->name('bundles.edit');
    Route::put('/bundles/{bundle}', [AdminController::class, 'updateBundle'])->name('bundles.update');
    Route::delete('/bundles/{bundle}', [AdminController::class, 'deleteBundle'])->name('bundles.destroy');
    
    // Product Search API for Bundles
    Route::get('/search-products', [AdminController::class, 'searchProducts'])->name('search-products');
    
    // Services Management
    Route::get('/services', [AdminController::class, 'services'])->name('services.index');
    Route::get('/services/create', [AdminController::class, 'createService'])->name('services.create');
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
    Route::get('/services/{service}/edit', [AdminController::class, 'editService'])->name('services.edit');
    Route::put('/services/{service}', [AdminController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{service}', [AdminController::class, 'deleteService'])->name('services.destroy');
    
    // Appointments Management
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [AdminController::class, 'showAppointment'])->name('appointments.show');
    Route::put('/appointments/{appointment}/status', [AdminController::class, 'updateAppointmentStatus'])->name('appointments.update-status');
    
    // Booking Settings Management
    Route::get('/booking-settings', [AdminController::class, 'bookingSettings'])->name('booking-settings.index');
    Route::put('/booking-settings', [AdminController::class, 'updateBookingSettings'])->name('booking-settings.update');
    
    // Settings Management
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    // Reviews Management
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    Route::put('/reviews/{review}/approve', [AdminController::class, 'approveReview'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('reviews.destroy');
    
    // Contact Messages Management
    Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminController::class, 'showContact'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [AdminController::class, 'deleteContact'])->name('contacts.destroy');

    // Newsletter Subscribers
    Route::get('/newsletter-subscribers', [AdminController::class, 'newsletterSubscribers'])->name('newsletter-subscribers.index');
    Route::delete('/newsletter-subscribers/{newsletterSubscriber}', [AdminController::class, 'deleteNewsletterSubscriber'])->name('newsletter-subscribers.destroy');
});

// Authentication Routes (Laravel UI)
require __DIR__.'/auth.php';
