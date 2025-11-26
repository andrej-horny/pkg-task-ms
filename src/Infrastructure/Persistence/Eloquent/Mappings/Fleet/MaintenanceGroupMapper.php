<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet;

use Dpb\Package\Fleet\Entities\MaintenanceGroup;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentMaintenanceGroup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class MaintenanceGroupMapper
{
    public function __construct(
        private EloquentMaintenanceGroup $eloquentModel,
        private VehicleTypeMapper $vtMapper,
    ) {}

    public function toDomain(EloquentMaintenanceGroup $model): MaintenanceGroup
    {
        return new MaintenanceGroup(
            $model->id,
            $model->code,
            $model->title,
            $model->description,
            $model->vehicleType ? $this->vtMapper->toDomain($model->vehicleType) : null,
        );
    }

    public function toEloquent(MaintenanceGroup $maintenanceGroup): EloquentMaintenanceGroup
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $maintenanceGroup->id()]);
        $model->code = $maintenanceGroup->code();
        $model->title = $maintenanceGroup->title();
        $model->description = $maintenanceGroup->description();
        $model->vehicle_type_id = $maintenanceGroup->vehicleType()->id();
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
