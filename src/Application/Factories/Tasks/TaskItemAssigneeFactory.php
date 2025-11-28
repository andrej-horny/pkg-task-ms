<?php

namespace Dpb\Package\TaskMS\Application\Factories\Tasks;

use Dpb\Package\Fleet\Repositories\MaintenanceGroupRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\MaintenanceGroupAsAssigneeAdapter;
use Dpb\Package\Tasks\Contracts\AssigneeInterface as TaskItemAssigneeInterface;
use InvalidArgumentException;

class TaskItemAssigneeFactory
{
    public function __construct(
        private MaintenanceGroupRepositoryInterface $mgRepo,
    ) {}

    public function make(string $type, string $id): TaskItemAssigneeInterface
    {
        return match ($type) {
            'maintenance-group' => new MaintenanceGroupAsAssigneeAdapter(
                $this->mgRepo->findById($id)
            ),

            default => throw new InvalidArgumentException("Unknown subject type [$type]"),
        };
    }
}