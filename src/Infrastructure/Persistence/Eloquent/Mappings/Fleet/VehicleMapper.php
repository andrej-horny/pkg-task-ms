<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet;

use Dpb\Package\Fleet\Entities\Vehicle;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicle;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class VehicleMapper
{
    public function __construct(
        private EloquentVehicle $eloquentModel,
        private VehicleModelMapper $vmMapper,
        private MaintenanceGroupMapper $mgMapper,
    ) {}

    public function toDomain(EloquentVehicle $model): Vehicle
    {
        return new Vehicle(
            $model->id,
            $model->vin,
            $model->model ? $this->vmMapper->toDomain($model->model) : null,
            $model->maintenanceGroup ? $this->mgMapper->toDomain($model->maintenanceGroup) : null,
            []
            // $model->description,
        );
    }

    public function toEloquent(Vehicle $vehicle): EloquentVehicle
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $vehicle->id()]);
        $model->code_1 = $vehicle->code();
        $model->vin = $vehicle->vin();
        $model->model_id = $vehicle->model()->id();
        $model->maintenance_group_id = $vehicle->maintenanceGroup()->id();
        // $model->vin = $vehicle->vin();
        
        return $model;
    }

    public function toDomainCollection(EloquentCollection $models): array
    {
        return $models
            ->map(
                fn($model) =>
                $this->toDomain($model)
            )
            ->all();
    }
}
