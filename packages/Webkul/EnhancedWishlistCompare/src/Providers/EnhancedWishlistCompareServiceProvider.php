<?php
namespace Webkul\EnhancedWishlistCompare\Providers;
use Illuminate\Support\ServiceProvider;
use Webkul\EnhancedWishlistCompare\Providers\EventServiceProvider;
class EnhancedWishlistCompareServiceProvider extends ServiceProvider{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'enhanced');

        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('enhanced_wishlist.php'),
        ], 'config');

        // Inject scripts into the footer/scripts stack
        $this->app->make('view')->composer('shop::components.layouts.index', function ($view) {
            if (
                config('enhanced_wishlist.wishlist.enabled') 
                || config('enhanced_wishlist.compare.enabled')
            ) {
                $view->getFactory()->startPush('scripts', view('enhanced::scripts')->render());
            }
        });
    }

    public function register()
    {
        $this->registerConfig();

        $this->app->register(EventServiceProvider::class);

        $this->app->bind(
            'Webkul\EnhancedWishlistCompare\Contracts\EnhancedWishlistCompareCount',
            'Webkul\EnhancedWishlistCompare\Models\EnhancedWishlistCompareCount'
        );
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'enhanced_wishlist'
        );
    }
}
