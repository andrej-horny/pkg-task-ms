<?php

namespace Dpb\Package\TaskMS\Application\Factories\Tasks;

use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;
use Dpb\Package\Tasks\Contracts\SubjectInterface as TaskSubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\VehicleAsTaskSubjectAdapter;
use InvalidArgumentException;

class TaskSubjectFactory
{
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepo,
        // private BuildingRepositoryInterface $buildingRepos,
    ) {}

    public function make(string $type, string $id): TaskSubjectInterface
    {
        return match ($type) {
            'vehicle' => new VehicleAsTaskSubjectAdapter(
                $this->vehicleRepo->findById($id)
            ),
            // 'building' => new BuildingSubjectAdapter(
            //     $this->buildings->findById($id)
            // ),
            default => throw new InvalidArgumentException("Unknown subject type [$type]"),
        };
    }
}