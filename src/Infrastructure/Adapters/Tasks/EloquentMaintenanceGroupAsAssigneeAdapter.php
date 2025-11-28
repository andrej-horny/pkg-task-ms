<?php

namespace Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentMaintenanceGroup;
use Dpb\Package\Tasks\Contracts\AssigneeInterface;

class EloquentMaintenanceGroupAsAssigneeAdapter implements AssigneeInterface
{
    public function __construct(private EloquentMaintenanceGroup $maintenanceGroup) {}

    public function assigneeId(): string
    {
        return (string) $this->maintenanceGroup->id;
    }

    public function assigneeType(): string
    {
        return $this->maintenanceGroup->getMorphClass();
    }

    public function assigneeLabel(): string
    {
        return $this->maintenanceGroup->title;
    }
}
