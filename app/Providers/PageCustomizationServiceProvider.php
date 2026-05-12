<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use App\Models\PageCustomization;
use Illuminate\Support\Facades\Auth;

class PageCustomizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Share page customizations with all views
        view()->composer('*', function ($view) {
            $user = Auth::user();
            if ($user) {
                $hiddenElements = [];
                
                // Get hidden elements for this user's role
                $roleCustomizations = PageCustomization::where('role_id', $user->role)
                    ->where('is_visible', 0)
                    ->pluck('element_identifier')
                    ->toArray();
                
                // Get hidden elements for this specific employee
                $employeeCustomizations = PageCustomization::where('employee_id', $user->id)
                    ->where('is_visible', 0)
                    ->pluck('element_identifier')
                    ->toArray();
                
                $hiddenElements = array_merge($roleCustomizations, $employeeCustomizations);
                
                $view->with('hiddenElements', $hiddenElements);
            }
        });
    }
}
