<?php

namespace Dpb\Package\TaskMS\Infrastructure\Adapters\Inspections;

use Dpb\Package\Fleet\Entities\Vehicle;
use Dpb\Package\Inspections\Contracts\SubjectInterface;

class VehicleAsInspectionSubjectAdapter implements SubjectInterface
{
    public function __construct(private Vehicle $vehicle) {}

    public function subjectId(): string
    {
        return (string) $this->vehicle->id();
    }

    public function subjectType(): string
    {
        return 'eloquent-vehicle';
    }

    public function subjectLabel(): string
    {
        return $this->vehicle->code()->code();
    }
}
