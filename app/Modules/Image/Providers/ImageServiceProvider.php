<?php

namespace App\Modules\Image\Providers;

use App\Modules\Image\Contracts\CUDImageContract;
use App\Modules\Image\Contracts\ReadImageContract;
use App\Modules\Image\Contracts\RepositoryImageContract;
use App\Modules\Image\Services\CUDImage;
use App\Modules\Image\Services\ReadImage;
use App\Modules\Image\Repositories\RepositoryImage;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CUDImageContract::class, CUDImage::class);
        $this->app->bind(ReadImageContract::class, ReadImage::class);
        $this->app->bind(RepositoryImageContract::class, RepositoryImage::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            CUDImageContract::class,
            ReadImage::class,
            RepositoryImageContract::class
        ];
    }
}
