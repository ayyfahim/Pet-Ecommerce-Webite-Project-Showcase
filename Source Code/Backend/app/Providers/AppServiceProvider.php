<?php

namespace App\Providers;

use Blade;
use App\Acme\Core;
use Spatie\Flash\Flash;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(Core $core)
    {
        $this->extra();
        $this->modelObservers();
        $this->paginationView();

        $core->caching();
        $core->macros();
        $core->viewShares();
        $core->viewComposers();
    }

    protected function modelObservers()
    {
        \App\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Feed::observe(\App\Observers\FeedObserver::class);
        \App\Models\OrderNote::observe(\App\Observers\OrderNoteObserver::class);
        \App\Models\Coupon::observe(\App\Observers\CouponObserver::class);
        \App\Models\RewardPoint::observe(\App\Observers\RewardPointObserver::class);
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
//        \App\Models\Brand::observe(\App\Observers\BrandObserver::class);
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        \App\Models\ProductInfo::observe(\App\Observers\ProductInfoObserver::class);
        \App\Models\Cart::observe(\App\Observers\CartObserver::class);
        \App\Models\CartBasket::observe(\App\Observers\CartBasketObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
        \App\Models\Article::observe(\App\Observers\ArticleObserver::class);
//        \App\Models\Review::observe(\App\Observers\ReviewObserver::class);
    }

    protected function extra()
    {
        Blade::withDoubleEncoding();

        // auto set the translation keys array for "nikaia/translation-sheet"
        config(['translation_sheet.locales' => LaravelLocalization::getSupportedLanguagesKeys()]);

        // set custom alert types for "spatie/laravel-flash"
        Flash::levels([
            'success' => 'alert-success',
            'warning' => 'alert-warning',
            'error' => 'alert-danger',
            'info' => 'alert-info',
        ]);
    }

    /**
     * https://laravel.com/docs/5.7/pagination#customizing-the-pagination-view.
     */
    protected function paginationView()
    {
//        Paginator::defaultView('layouts.pagination.main');
//        Paginator::defaultSimpleView('layouts.pagination.simple');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
