<?php

namespace Dpb\Package\TaskMS\Application\Factories\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\EloquentMaintenanceGroupAsAssigneeAdapter;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentMaintenanceGroup;
use Dpb\Package\Tasks\Contracts\AssigneeInterface as TaskItemAssigneeInterface;
use InvalidArgumentException;

class EloquentTaskItemAssigneeFactory
{
    public function make(object $eloquentModel): TaskItemAssigneeInterface
    {
        return match (get_class($eloquentModel)) {
            EloquentMaintenanceGroup::class => new EloquentMaintenanceGroupAsAssigneeAdapter($eloquentModel),

            default => throw new InvalidArgumentException("Unknown subject type"),
        };
    }
}