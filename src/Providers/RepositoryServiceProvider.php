<?php

namespace Dpb\Package\TaskMS\Providers;

use Dpb\Package\Activities\Repositories\ActivityRepositoryInterface;
use Dpb\Package\Activities\Repositories\ActivityTemplateGroupRepositoryInterface;
use Dpb\Package\Activities\Repositories\ActivityTemplateRepositoryInterface;
use Dpb\Package\Fleet\Repositories\MaintenanceGroupRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Activities\ActivityTemplateGroupRepositoryEloquent;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Activities\ActivityTemplateRepositoryEloquent;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\ActivityRepositoryEloquent;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Fleet\MaintenanceGroupRepositoryEloquent;
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
        // activities
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepositoryEloquent::class);    
        $this->app->bind(ActivityTemplateRepositoryInterface::class, ActivityTemplateRepositoryEloquent::class);    
        $this->app->bind(ActivityTemplateGroupRepositoryInterface::class, ActivityTemplateGroupRepositoryEloquent::class);    
        // tasks
        $this->app->bind(TaskGroupRepositoryInterface::class, TaskGroupRepositoryEloquent::class);    
        $this->app->bind(TaskRepositoryInterface::class, TaskRepositoryEloquent::class);    
        // fleet
        $this->app->bind(MaintenanceGroupRepositoryInterface::class, MaintenanceGroupRepositoryEloquent::class);    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
