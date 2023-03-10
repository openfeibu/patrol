<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Common\Tree;
use Intervention\Image\ImageManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadViewsFrom(public_path().'/themes/vender/filer', 'filer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tree',function(){
            return new Tree;
        });
        $this->app->bind(
            'App\Repositories\Eloquent\PageRepositoryInterface',
            \App\Repositories\Eloquent\PageRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\PageCategoryRepositoryInterface',
            \App\Repositories\Eloquent\PageCategoryRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\PageRecruitRepositoryInterface',
            \App\Repositories\Eloquent\PageRecruitRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\SettingRepositoryInterface',
            \App\Repositories\Eloquent\SettingRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\BannerRepositoryInterface',
            \App\Repositories\Eloquent\BannerRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\LinkRepositoryInterface',
            \App\Repositories\Eloquent\LinkRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\NavRepositoryInterface',
            \App\Repositories\Eloquent\NavRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\NavCategoryRepositoryInterface',
            \App\Repositories\Eloquent\NavCategoryRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\PaymentCompanyRepositoryInterface',
            \App\Repositories\Eloquent\PaymentCompanyRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\ProviderRepositoryInterface',
            \App\Repositories\Eloquent\ProviderRepository::class
        );

        $this->app->bind(
            'App\Repositories\Eloquent\MerchantRepositoryInterface',
            \App\Repositories\Eloquent\MerchantRepository::class
        );

        $this->app->bind(
            'App\Repositories\Eloquent\OrderRepositoryInterface',
            \App\Repositories\Eloquent\OrderRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\OrderRecordRepositoryInterface',
            \App\Repositories\Eloquent\OrderRecordRepository::class
        );
        $this->app->bind(
            'App\Repositories\Eloquent\UserRepositoryInterface',
            \App\Repositories\Eloquent\UserRepository::class
        );

        $this->app->bind('filer', function ($app) {
            return new \App\Helpers\Filer\Filer();
        });
        $this->app->singleton('image', function ($app) {
            return new ImageManager($app['config']->get('image'));
        });
        $this->app->bind('image_service', function ($app) {
            return new \App\Services\ImageService($app->request);
        });
        $this->app->bind('excel_service', function ($app) {
            return new \App\Services\ExcelService($app->request);
        });
    }

    public function provides()
    {

    }
}
