<?php

namespace Dpb\Package\TaskMS\Application\Factories\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\EloquentMaintenanceGroupAsTaskAssigneeAdapter;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentMaintenanceGroup;
use Dpb\Package\Tasks\Contracts\AssigneeInterface as TaskAssigneeInterface;
use InvalidArgumentException;

class EloquentTaskAssigneeFactory
{
    public function make(object $eloquentModel): TaskAssigneeInterface
    {
        return match (get_class($eloquentModel)) {
            EloquentMaintenanceGroup::class => new EloquentMaintenanceGroupAsTaskAssigneeAdapter($eloquentModel),

            default => throw new InvalidArgumentException("Unknown subject type"),
        };
    }
}