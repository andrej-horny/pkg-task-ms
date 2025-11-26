<?php

namespace Dpb\Package\TaskMS\Application\Factories\Inspections;

use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;
use Dpb\Package\Inspections\Contracts\SubjectInterface as InspectionSubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Inspections\EloquentVehicleAsInspectionSubjectAdapter;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicle;
use InvalidArgumentException;

class EloquentInspectionSubjectFactory
{
    public function make(object $eloquentModel): InspectionSubjectInterface
    {
        return match (get_class($eloquentModel)) {
            EloquentVehicle::class => new EloquentVehicleAsInspectionSubjectAdapter($eloquentModel),

            default => throw new InvalidArgumentException("Unknown subject type"),
        };
    }
}