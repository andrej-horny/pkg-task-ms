<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet;

use Dpb\Package\Fleet\Entities\VehicleType;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicleType;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class VehicleTypeMapper
{
    public function __construct(
        private EloquentVehicleType $eloquentModel,
    ) {}

    public function toDomain(EloquentVehicleType $model): VehicleType
    {
        return new VehicleType(
            $model->id,
            $model->code,
            $model->title,
        );
    }

    public function toEloquent(VehicleType $vehicleType): EloquentVehicleType
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $vehicleType->id()]);
        $model->code = $vehicleType->code();
        $model->title = $vehicleType->title();
        
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
