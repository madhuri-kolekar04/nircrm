<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Use custom pagination template
        \Illuminate\Pagination\Paginator::defaultView('vendor.pagination.custom');
        \Illuminate\Pagination\Paginator::defaultSimpleView('vendor.pagination.custom');
        
        // Blade directive for checking if element is visible
        Blade::directive('isVisible', function ($expression) {
            return "<?php if (!in_array($expression, \$hiddenElements ?? [])) : ?>";
        });
        
        Blade::directive('endIsVisible', function () {
            return "<?php endif; ?>";
        });
        
        // Blade directive for checking if element is hidden
        Blade::directive('isHidden', function ($expression) {
            return "<?php if (in_array($expression, \$hiddenElements ?? [])) : ?>";
        });
        
        Blade::directive('endIsHidden', function () {
            return "<?php endif; ?>";
        });
    }
}
