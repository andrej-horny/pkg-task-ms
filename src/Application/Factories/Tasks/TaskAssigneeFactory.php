<?php

namespace Dpb\Package\TaskMS\Application\Factories\Tasks;

use Dpb\Package\Fleet\Repositories\MaintenanceGroupRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\MaintenanceGroupAsTaskAssigneeAdapter;
use Dpb\Package\Tasks\Contracts\AssigneeInterface as TaskAssigneeInterface;
use InvalidArgumentException;

class TaskAssigneeFactory
{
    public function __construct(
        private MaintenanceGroupRepositoryInterface $mgRepo,
    ) {}

    public function make(string $type, string $id): TaskAssigneeInterface
    {
        return match ($type) {
            'maintenance-group' => new MaintenanceGroupAsTaskAssigneeAdapter(
                $this->mgRepo->findById($id)
            ),

            default => throw new InvalidArgumentException("Unknown subject type [$type]"),
        };
    }
}