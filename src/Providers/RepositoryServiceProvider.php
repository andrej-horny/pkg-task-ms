<?php

namespace Dpb\Package\TaskMS\Providers;

use Dpb\Package\Activities\Repositories\ActivityRepositoryInterface;
use Dpb\Package\Activities\Repositories\ActivityTemplateGroupRepositoryInterface;
use Dpb\Package\Activities\Repositories\ActivityTemplateRepositoryInterface;
use Dpb\Package\Fleet\Repositories\MaintenanceGroupRepositoryInterface;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Dpb\Package\Tasks\Repositories\TaskRepositoryInterface;
use Dpb\Package\Tickets\Repositories\TicketTypeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories as TmsRepo;
use Dpb\Package\Tickets\Repositories\TicketRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {    
        // Bind interface to implementation
        // activities
        $this->app->bind(ActivityRepositoryInterface::class, TmsRepo\Activities\ActivityRepositoryEloquent::class);    
        $this->app->bind(ActivityTemplateRepositoryInterface::class, TmsRepo\Activities\ActivityTemplateRepositoryEloquent::class);    
        $this->app->bind(ActivityTemplateGroupRepositoryInterface::class, TmsRepo\Activities\ActivityTemplateGroupRepositoryEloquent::class);    
        // tasks
        $this->app->bind(TaskGroupRepositoryInterface::class, TmsRepo\TaskGroupRepositoryEloquent::class);    
        $this->app->bind(TaskRepositoryInterface::class, TmsRepo\TaskRepositoryEloquent::class);    
        // tickets
        $this->app->bind(TicketTypeRepositoryInterface::class, TmsRepo\Tickets\TicketTypeRepositoryEloquent::class);    
        $this->app->bind(TicketRepositoryInterface::class, TmsRepo\Tickets\TicketRepositoryEloquent::class);    
        // fleet
        $this->app->bind(MaintenanceGroupRepositoryInterface::class, TmsRepo\Fleet\MaintenanceGroupRepositoryEloquent::class);    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
