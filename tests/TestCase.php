<?php

declare(strict_types=1);

namespace BBSLab\NovaFileManager\Tests;

use BBSLab\NovaFileManager\ToolServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Inertia\ServiceProvider;
use Laravel\Nova\Http\Middleware\BootTools;
use Laravel\Nova\Http\Middleware\DispatchServingNovaEvent;
use Laravel\Nova\Http\Middleware\HandleInertiaRequests;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\NovaCoreServiceProvider;
use Laravel\Nova\NovaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Pion\Laravel\ChunkUpload\Providers\ChunkUploadServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ChunkUploadServiceProvider::class,
            ServiceProvider::class,
            NovaCoreServiceProvider::class,
            NovaApplicationServiceProvider::class,
            NovaServiceProvider::class,
            ToolServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('nova:publish');

        File::ensureDirectoryExists(static::applicationBasePath().'/app/Nova');

        Route::middlewareGroup('nova', []);
        Route::middlewareGroup('nova:api', []);
    }
}
