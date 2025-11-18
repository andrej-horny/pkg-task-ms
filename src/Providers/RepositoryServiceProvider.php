<?php

namespace Dpb\Package\TaskMS\Providers;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\TaskGroupRepositoryEloquent;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
