<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet;

use Dpb\Package\Fleet\Entities\Vehicle;
use Dpb\Package\Fleet\Entities\VehicleCode;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicle;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicleCode;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class VehicleCodeMapper
{
    public function __construct(
        private EloquentVehicleCode $eloquentModel,
    ) {}

    public function toDomain(EloquentVehicleCode $model): VehicleCode
    {
        $code = new VehicleCode(
            $model->id,
            $model->code,
            $model->date_from,
            null
            // $model->description,
        );

        if ($model->date_to) {
            $code->endToDate($model->date_to);
        }

        return $code;
    }

    public function toEloquent(VehicleCode $vehicleCode): EloquentVehicleCode
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $vehicleCode->id()]);
        $model->code = $vehicleCode->code();
        $model->date_from = $vehicleCode->dateFrom();
        $model->date_to = $vehicleCode->dateTo();
        
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
