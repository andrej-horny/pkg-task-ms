<?php

namespace Dpb\Package\TaskMS\Infrastructure\Adapters\Inspections;

use Dpb\Package\Inspections\Contracts\SubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicle;

class EloquentVehicleAsInspectionSubjectAdapter implements SubjectInterface
{
    public function __construct(private EloquentVehicle $vehicle) {}

    public function subjectId(): string
    {
        return (string) $this->vehicle->id;
    }

    public function subjectType(): string
    {
        return $this->vehicle->getMorphClass();
    }

    public function subjectLabel(): string
    {
        return $this->vehicle->code_1;
    }
}
