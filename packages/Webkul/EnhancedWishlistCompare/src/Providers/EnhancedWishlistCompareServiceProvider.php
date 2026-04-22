<?php
namespace Webkul\EnhancedWishlistCompare\Providers;
use Illuminate\Support\ServiceProvider;
use Webkul\EnhancedWishlistCompare\Providers\EventServiceProvider;
class EnhancedWishlistCompareServiceProvider extends ServiceProvider{
    public function boot(){
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->publishes([
            __DIR__ . '/../Resources/assets' => public_path('vendor/enhanced-wishlist'),
        ], 'public');
        
    }
    public function register(){
      $this->app->register(EventServiceProvider::class);
    }

}
