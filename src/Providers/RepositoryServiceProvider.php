<?php

namespace Dpb\Package\TaskMS\Providers;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\TaskGroupRepositoryEloquent;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\TaskRepositoryEloquent;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Dpb\Package\Tasks\Repositories\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {    
        // Bind interface to implementation
        $this->app->bind(TaskGroupRepositoryInterface::class, TaskGroupRepositoryEloquent::class);    
        $this->app->bind(TaskRepositoryInterface::class, TaskRepositoryEloquent::class);    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
