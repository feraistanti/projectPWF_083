<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


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
        // Aturan: Hanya yang rolenya 'admin' yang bisa export-product
        Gate::define('export-product', function ($user) {
            return $user->role === 'admin';
        });
    }
}
