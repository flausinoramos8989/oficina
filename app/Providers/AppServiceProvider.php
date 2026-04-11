<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        Blade::directive('phone', function ($number) {
            return "<?php echo preg_replace('/^55(\\d{2})(\\d{4,5})(\\d{4})$/', '+55 ($1) $2-$3', preg_replace('/\\D/', '', $number)); ?>"; 
        });
    }
}
