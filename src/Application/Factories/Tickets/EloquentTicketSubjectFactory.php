<?php

namespace Dpb\Package\TaskMS\Application\Factories\Tickets;

use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;
use Dpb\Package\Tickets\Contracts\SubjectInterface as TicketSubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tickets\EloquentVehicleAsTicketSubjectAdapter;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicle;
use InvalidArgumentException;

class EloquentTicketSubjectFactory
{
    public function make(object $eloquentModel): TicketSubjectInterface
    {
        return match (get_class($eloquentModel)) {
            EloquentVehicle::class => new EloquentVehicleAsTicketSubjectAdapter($eloquentModel),

            default => throw new InvalidArgumentException("Unknown subject type"),
        };
    }
}