<?php

namespace Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks;

use Dpb\Package\Fleet\Entities\MaintenanceGroup;
use Dpb\Package\Tasks\Contracts\AssigneeInterface;

class MaintenanceGroupAssigneeAdapter implements AssigneeInterface
{
    public function __construct(private MaintenanceGroup $maintenanceGroup) {}

    public function assigneeId(): string
    {
        return (string) $this->maintenanceGroup->id();
    }

    public function assigneeType(): string
    {
        return 'eloquent-maintenance-group';
    }

    public function assigneeLabel(): string
    {
        return $this->maintenanceGroup->title();
    }
}
