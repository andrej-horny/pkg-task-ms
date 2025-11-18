<?php

namespace Dpb\Package\TaskMS\Infrastructure\Eloquent\Repositories;

use Dpb\Package\Tasks\Entities\TaskGroup;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskGroupRepositoryEloquent implements TaskGroupRepositoryInterface
{

    public function save(TaskGroup $taskGroup)
    {}
    public function find(string $id): ?TaskGroup
    {}
}
