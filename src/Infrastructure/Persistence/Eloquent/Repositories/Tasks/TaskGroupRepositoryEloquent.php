<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentTaskGroup;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks\TaskGroupMapper;
use Dpb\Package\Tasks\Entities\TaskGroup;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Illuminate\Support\Arr;

class TaskGroupRepositoryEloquent implements TaskGroupRepositoryInterface
{
    public function __construct(
        private TaskGroupMapper $mapper,
        private EloquentTaskGroup $eloquentModel
        ) {}

    public function save(TaskGroup $taskGroup): TaskGroup
    {
        $model = $this->mapper->toEloquent($taskGroup);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?TaskGroup
    {
        $model = $this->eloquentModel->findOrFail($id);

        return $model ? $this->mapper->toDomain($model) : null;
    }

    public function all(): ?array
    {
        return $this->eloquentModel->all()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }

    public function findByUri(string $uri): ?TaskGroup
    {
        $model = $this->eloquentModel
            ->where('uri', '=', $uri)
            ->first();
        
            return $this->mapper->toDomain($model);
    }

    public function byUri(string|array $uri): ?array
    {
        $uri = Arr::wrap($uri);

        return $this->eloquentModel->whereIn('uri', $uri)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }
}
