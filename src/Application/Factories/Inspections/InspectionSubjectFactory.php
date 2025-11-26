<?php

namespace Dpb\Package\TaskMS\Application\Factories\Inspections;

use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;
use Dpb\Package\Inspections\Contracts\SubjectInterface as InspectionSubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Inspections\VehicleAsInspectionSubjectAdapter;
use InvalidArgumentException;

class InspectionSubjectFactory
{
    public function __construct(
        private VehicleRepositoryInterface $vehicleRepo,
        // private BuildingRepositoryInterface $buildingRepos,
    ) {}

    public function make(string $type, string $id): InspectionSubjectInterface
    {
        return match ($type) {
            'vehicle' => new VehicleAsInspectionSubjectAdapter(
                $this->vehicleRepo->findById($id)
            ),
            // 'building' => new BuildingSubjectAdapter(
            //     $this->buildings->findById($id)
            // ),
            default => throw new InvalidArgumentException("Unknown subject type [$type]"),
        };
    }
}