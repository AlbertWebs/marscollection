<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Settings helper removed to avoid function redeclaration conflicts

        // Share contact information and categories with all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with([
                'contact' => \App\Helpers\SettingsHelper::getContactInfo(),
                'activeCategories' => \App\Models\Category::where('is_active', true)->get()
            ]);
        });

        // Register blade directive for contact info
        \Illuminate\Support\Facades\Blade::directive('contact', function ($expression) {
            return "<?php echo \App\Helpers\SettingsHelper::getContactInfo(){$expression}; ?>";
        });
    }
}
