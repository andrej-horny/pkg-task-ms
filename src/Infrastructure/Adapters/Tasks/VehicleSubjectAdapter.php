<?php

namespace Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks;

use Dpb\Package\Fleet\Entities\Vehicle;
use Dpb\Package\Tasks\Contracts\SubjectInterface;

class VehicleSubjectAdapter implements SubjectInterface
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
        return $this->vehicle->code();
    }
}
