<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\EloquentTask;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\TaskMapper;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Entities\TaskGroup;
use Dpb\Package\Tasks\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Arr;

class TaskRepositoryEloquent implements TaskRepositoryInterface
{
    public function __construct(private TaskMapper $mapper) {}

    public function save(Task $task): Task
    {
        $model = $this->mapper->toEloquent($task);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?Task
    {
        $model = EloquentTask::findOrFail($id);

        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function all(): ?array
    {
        return EloquentTask::all()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }

}
