<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\RouteInfo;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Scramble::configure()
            ->withDocumentTransformers(function (OpenApi $openApi) {
                $openApi->secure(
                    SecurityScheme::http('bearer', 'JWT')
                );
            })
            ->withOperationTransformers(function (Operation $operation, RouteInfo $routeInfo) {
                $middlewares = $routeInfo->route->middleware();

                if (!in_array('auth:sanctum', $middlewares)) {
                    $operation->security = [];
                }
            });
    }
}
