<?php

namespace Dpb\Package\TaskMS\Application\Factories\Tasks;

use Dpb\Package\Tasks\Contracts\SubjectInterface as TaskSubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\EloquentVehicleAsTaskSubjectAdapter;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicle;
use InvalidArgumentException;

class EloquentTaskSubjectFactory
{
    public function make(object $eloquentModel): TaskSubjectInterface
    {
        return match (get_class($eloquentModel)) {
            EloquentVehicle::class => new EloquentVehicleAsTaskSubjectAdapter($eloquentModel),

            default => throw new InvalidArgumentException("Unknown subject type"),
        };
    }
}