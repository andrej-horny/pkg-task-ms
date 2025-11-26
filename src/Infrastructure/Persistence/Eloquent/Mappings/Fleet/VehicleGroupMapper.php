<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet;

use Dpb\Package\Fleet\Entities\VehicleGroup;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicleGroup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class VehicleGroupMapper
{
    public function __construct(
        private EloquentVehicleGroup $eloquentModel,
    ) {}

    public function toDomain(EloquentVehicleGroup $model): VehicleGroup
    {
        return new VehicleGroup(
            $model->id,
            $model->code,
            $model->title,
            $model->description,
        );
    }

    public function toEloquent(VehicleGroup $vehicleGroup): EloquentVehicleGroup
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $vehicleGroup->id()]);
        $model->code = $vehicleGroup->code();
        $model->title = $vehicleGroup->title();
        $model->description = $vehicleGroup->description();
        
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
