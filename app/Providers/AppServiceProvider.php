<?php

namespace App\Providers;

use App\Models\Doctor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Route::bind('doctor', function (string $value) {
            return Doctor::where('license_number', $value)
                ->orWhere('id', $value)
                ->firstOrFail();
        });
    }
}
