<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        // Inject $profilePhoto ke semua view
        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Cek apakah user punya foto atau fallback ke default
                $photo = Auth::user()->photo ?? 'profile.jpg';
                $view->with('profilePhoto', asset($photo));
            } else {
                // Kalau belum login, tetap kasih default
                $view->with('profilePhoto', asset('profile.jpg'));
            }
        });
    }
}
