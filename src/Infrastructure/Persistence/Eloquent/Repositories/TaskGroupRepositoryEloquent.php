<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\EloquentTaskGroup;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\TaskGroupMapper;
use Dpb\Package\Tasks\Entities\TaskGroup;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Illuminate\Support\Arr;

class TaskGroupRepositoryEloquent implements TaskGroupRepositoryInterface
{
    public function __construct(private TaskGroupMapper $mapper) {}

    public function save(TaskGroup $taskGroup): TaskGroup
    {
        $model = $this->mapper->toEloquent($taskGroup);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?TaskGroup
    {
        $model = EloquentTaskGroup::findOrFail($id);

        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function all(): ?array
    {
        return EloquentTaskGroup::all()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }

    public function byCode(string|array $code): ?array
    {
        $code = Arr::wrap($code);

        return EloquentTaskGroup::whereIn('code', $code)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }

}
