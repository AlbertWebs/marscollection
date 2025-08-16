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
        // Register settings helper globally
        if (!function_exists('setting')) {
            function setting($key, $default = null) {
                return \App\Helpers\SettingsHelper::get($key, $default);
            }
        }

        // Share contact information with all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with('contact', \App\Helpers\SettingsHelper::getContactInfo());
        });

        // Register blade directive for contact info
        \Illuminate\Support\Facades\Blade::directive('contact', function ($expression) {
            return "<?php echo \App\Helpers\SettingsHelper::getContactInfo(){$expression}; ?>";
        });
    }
}
