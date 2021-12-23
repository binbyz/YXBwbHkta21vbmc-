<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\MemberServiceContract;
use App\Contracts\OnlineShopContract;
use App\Http\Services\MemberService;
use App\Http\Services\KmongService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MemberServiceContract::class, function ($app) {
            return new MemberService();
        });

        $this->app->singleton(OnlineShopContract::class, function ($app) {
            return new KmongService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
