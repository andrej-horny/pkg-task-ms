<?php

namespace Dpb\Package\TaskMS\Infrastructure\Eloquent\Models;

use Dpb\Package\Tasks\Entities\TaskGroup;
use Fleet\Domain\Entity\Vehicle;

class VehicleMapper
{
    public static function toDomain(EloquentTaskGroup $model): TaskGroup
    {
        return new Vehicle(
            new VehicleId($model->id),
            $model->vin,
            $model->maintenanceGroup?->toDomain(),
            new WarrantyInfo(
                $model->warranty_initial_date,
                $model->warranty_months,
            ),
            $model->state,
            $model->commissioning_date?->toImmutable()
        );
    }

    public static function toEloquent(Vehicle $vehicle): EloquentVehicle
    {
        $model = EloquentVehicle::firstOrNew(['id' => $vehicle->id()->value()]);
        $model->vin = $vehicle->vin();
        $model->state = $vehicle->state();
        // ...
        return $model;
    }
}