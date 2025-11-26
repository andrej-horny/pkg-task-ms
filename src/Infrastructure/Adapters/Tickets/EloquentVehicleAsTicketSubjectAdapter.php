<?php

namespace Dpb\Package\TaskMS\Infrastructure\Adapters\Tickets;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicle;
use Dpb\Package\Tickets\Contracts\SubjectInterface;

class EloquentVehicleAsTicketSubjectAdapter implements SubjectInterface
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
        return $this->vehicle->subjectLabel();
    }
}
