<?php

namespace Dpb\Package\TaskMS\Providers;

use Dpb\Package\Activities\Repositories\ActivityRepositoryInterface;
use Dpb\Package\Activities\Repositories\ActivityTemplateGroupRepositoryInterface;
use Dpb\Package\Activities\Repositories\ActivityTemplateRepositoryInterface;
use Dpb\Package\Fleet;
use Dpb\Package\Inspections;
use Dpb\Package\Tasks;
use Dpb\Package\Tickets;
use Illuminate\Support\ServiceProvider;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories as TmsRepo;

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
        // fleet
        $this->app->bind(Fleet\Repositories\MaintenanceGroupRepositoryInterface::class, TmsRepo\Fleet\MaintenanceGroupRepositoryEloquent::class);    
        $this->app->bind(Fleet\Repositories\VehicleRepositoryInterface::class, TmsRepo\Fleet\VehicleRepositoryEloquent::class);    
        $this->app->bind(Fleet\Repositories\VehicleBrandRepositoryInterface::class, TmsRepo\Fleet\VehicleBrandRepositoryEloquent::class);    
        $this->app->bind(Fleet\Repositories\VehicleTypeRepositoryInterface::class, TmsRepo\Fleet\VehicleTypeRepositoryEloquent::class);    
        $this->app->bind(Fleet\Repositories\VehicleGroupRepositoryInterface::class, TmsRepo\Fleet\VehicleGroupRepositoryEloquent::class);    
        $this->app->bind(Fleet\Repositories\VehicleModelRepositoryInterface::class, TmsRepo\Fleet\VehicleModelRepositoryEloquent::class);    
        // inspections
        $this->app->bind(Inspections\Repositories\InspectionRepositoryInterface::class, TmsRepo\Inspections\InspectionRepositoryEloquent::class);    
        $this->app->bind(Inspections\Repositories\InspectionTemplateConditionRepositoryInterface::class, TmsRepo\Inspections\InspectionTemplateConditionRepositoryEloquent::class);    
        $this->app->bind(Inspections\Repositories\InspectionTemplateConditionTypeRepositoryInterface::class, TmsRepo\Inspections\InspectionTemplateConditionTypeRepositoryEloquent::class);    
        $this->app->bind(Inspections\Repositories\InspectionTemplateGroupRepositoryInterface::class, TmsRepo\Inspections\InspectionTemplateGroupRepositoryEloquent::class);    
        $this->app->bind(Inspections\Repositories\InspectionTemplateRepositoryInterface::class, TmsRepo\Inspections\InspectionTemplateRepositoryEloquent::class);    
        $this->app->bind(Inspections\Repositories\MeasurementUnitRepositoryInterface::class, TmsRepo\Inspections\MeasurementUnitRepositoryEloquent::class);    
        // tasks
        $this->app->bind(Tasks\Repositories\TaskGroupRepositoryInterface::class, TmsRepo\Tasks\TaskGroupRepositoryEloquent::class);    
        $this->app->bind(Tasks\Repositories\TaskRepositoryInterface::class, TmsRepo\Tasks\TaskRepositoryEloquent::class);    
        // tickets
        $this->app->bind(Tickets\Repositories\TicketTypeRepositoryInterface::class, TmsRepo\Tickets\TicketTypeRepositoryEloquent::class);    
        $this->app->bind(Tickets\Repositories\TicketRepositoryInterface::class, TmsRepo\Tickets\TicketRepositoryEloquent::class);    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
