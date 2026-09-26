<?php

namespace App\Providers;

use App\Http\View\Composer\HeaderComposer;
use App\Models\About;
use App\Models\AddPage;
use App\Models\Cart;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\GoogleFacebookCode;
use App\Models\PaymentPolicy;
use App\Models\PrivacyPolicy;
use App\Models\RefundPolicy;
use App\Models\TermsCondition;
use App\Repository\Brand\BrandRepository;
use App\Repository\Subcategory\SubcategoryRepository;
use App\Repository\Category\CategoryRepository;
use App\Repository\Color\ColorRepository;
use App\Repository\Interface\BrandInterface;
use App\Repository\Interface\CategoryInterface;
use App\Repository\Interface\ColorInterface;
use App\Repository\Interface\ProductInterface;
use App\Repository\Interface\PageProductInterface;
use App\Repository\Interface\SizeInterface;
use App\Repository\Interface\SubcategoryInterface;
use App\Repository\Product\ProductRepository;
use App\Repository\Product\PageProductRepository;
use App\Repository\Size\SizeRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(SubcategoryInterface::class, SubcategoryRepository::class);
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(ColorInterface::class, ColorRepository::class);
        $this->app->bind(SizeInterface::class, SizeRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(PageProductInterface::class, PageProductRepository::class);

        //View Composer
        View::composer(['frontend.includes.header'], HeaderComposer::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        View::composer('*', function ($view){
            $view->with('categories', Category::where('status', 1)->get());
            $view->with('allPages', AddPage::where('status', 1)->get());
            $view->with('privacy', PrivacyPolicy::first());
            $view->with('terms', TermsCondition::first());
            $view->with('refund', RefundPolicy::first());
            $view->with('payment', PaymentPolicy::first());
            $view->with('about', About::first());
            $view->with('code', GoogleFacebookCode::first());
            $view->with('setting', GeneralSetting::first());

            // Clean up orphaned cart items (where product has been deleted)
            Cart::doesntHave('product')->delete();

            $view->with('carts', Cart::where('ip_address', request()->ip())->with('product')->get());
        });
    }
}
