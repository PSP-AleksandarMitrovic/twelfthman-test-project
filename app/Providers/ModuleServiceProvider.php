<?php

namespace App\Providers;

use Route;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Boot our web and api routes
        $this->bootRoutes();
    }

    /**
     * Boot web and api routes
     */
    private function bootRoutes()
    {
        // Get all modules routes files
        $routes = glob(app_path('Modules/*/routes/*.php'));

        if(count($routes) == 0){
            return;
        }

        foreach($routes as $route){
            // Include routes file
            require $route;
            // ... and if our route file is web, register it's routes as web
            if(strpos($route, "web.php") !== false){
                $this->bootWebRoute($route);
            }
            // ... else, register our api routes
            elseif(strpos($route, "api.php") !== false){
                $this->bootApiRoute($route);
            }
        }
    }

    /**
     * Boot given web route file
     *
     * @param string $route
     */
    private function bootWebRoute(string $route)
    {
        Route::middleware('web')
            ->group($route);
    }

    /**
     * Boot given api route file
     *
     * @param string $route
     */
    private function bootApiRoute(string $route)
    {
        Route::prefix('api')
            ->middleware('api')
            ->group($route);
    }
}
