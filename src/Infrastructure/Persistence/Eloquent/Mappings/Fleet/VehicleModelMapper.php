<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet;

use Dpb\Package\Fleet\Entities\VehicleModel;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicleModel;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class VehicleModelMapper
{
    public function __construct(
        private EloquentVehicleModel $eloquentModel,
        private VehicleBrandMapper $vbMapper,
        private VehicleTypeMapper $vtMapper,
    ) {}

    public function toDomain(EloquentVehicleModel $model): VehicleModel
    {           
        return new VehicleModel(
            $model->id,
            $model->title,
            $model->year,
            $model->type ? $this->vtMapper->toDomain($model->type) : null,
            $model->brand ? $this->vbMapper->toDomain($model->brand) : null,
            // $model->code,
        );
    }

    public function toEloquent(VehicleModel $vehicleModel): EloquentVehicleModel
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $vehicleModel->id()]);
        $model->title = $vehicleModel->title();
        $model->year = $vehicleModel->year();
        $model->type_id = $vehicleModel->type()?->id();
        $model->brand_id = $vehicleModel->brand()?->id();
        
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
