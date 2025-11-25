<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet;

use Dpb\Package\Fleet\Entities\VehicleBrand;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicleBrand;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class VehicleBrandMapper
{
    public function __construct(
        private EloquentVehicleBrand $eloquentModel,
    ) {}

    public function toDomain(EloquentVehicleBrand $model): VehicleBrand
    {
        return new VehicleBrand(
            $model->id,
            $model->title,
        );
    }

    public function toEloquent(VehicleBrand $vehicleBrand): EloquentVehicleBrand
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $vehicleBrand->id()]);
        $model->title = $vehicleBrand->title();
        
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
