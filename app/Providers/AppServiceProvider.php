<?php

namespace App\Providers;

use App\Models\Product;
use App\Observers\ProductObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        // Register product observer for auto-embedding
        Product::observe(ProductObserver::class);

        // Share contact information and categories with all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with([
                'contact' => \App\Helpers\SettingsHelper::getContactInfo(),
                'activeCategories' => \App\Models\Category::where('is_active', true)
                    ->orderBy('sort_order')->orderBy('name')->get()
            ]);
        });

        \Illuminate\Support\Facades\Blade::directive('contact', function ($expression) {
            return "<?php echo \App\Helpers\SettingsHelper::getContactInfo(){$expression}; ?>";
        });
    }
}
