<?php

namespace App\Modules\FileSystem\Providers;

use App\Modules\FileSystem\Contracts\FileSystemResourceContract;
use App\Modules\FileSystem\Services\FileSystemResourceLocal;
use Illuminate\Support\ServiceProvider;

class FileSystemServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FileSystemResourceContract::class, FileSystemResourceLocal::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [FileSystemResourceContract::class];
    }
}
