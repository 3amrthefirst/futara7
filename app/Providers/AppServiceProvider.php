<?php

namespace App\Providers;

use App\Observers\CategoryObserver;
use App\Observers\Company;
use App\Observers\CompanyObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Company::observe(CompanyObserver::class);
        \App\Models\Category::observe(CategoryObserver::class);

    }
}
