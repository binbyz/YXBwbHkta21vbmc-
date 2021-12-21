<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\MemberServiceContract;
use App\Http\Services\MemberService;

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
