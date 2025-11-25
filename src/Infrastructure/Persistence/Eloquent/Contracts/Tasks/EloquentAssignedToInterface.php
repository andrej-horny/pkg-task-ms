<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Tasks;

interface EloquentAssignedToInterface
{
    public function assignedToLabel(): string;
}