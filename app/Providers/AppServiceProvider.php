<?php

namespace App\Providers;

use App\Modules\FileSystem\Contracts\FileSystemResourceContract;
use App\Modules\FileSystem\Services\FileSystemResourceLocal;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       //
    }
}
