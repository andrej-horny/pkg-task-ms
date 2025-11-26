<?php

namespace Dpb\Package\TaskMS\Application\Factories\Tickets;

use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;
use Dpb\Package\Tickets\Contracts\SubjectInterface as TicketSubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tickets\VehicleAsTicketSubjectAdapter;
use InvalidArgumentException;

class TicketSubjectFactory
{
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepo,
        // private BuildingRepositoryInterface $buildingRepos,
    ) {}

    public function make(string $type, string $id): TicketSubjectInterface
    {
        return match ($type) {
            'vehicle' => new VehicleAsTicketSubjectAdapter(
                $this->vehicleRepo->findById($id)
            ),
            // 'building' => new BuildingSubjectAdapter(
            //     $this->buildings->findById($id)
            // ),
            default => throw new InvalidArgumentException("Unknown subject type [$type]"),
        };
    }
}