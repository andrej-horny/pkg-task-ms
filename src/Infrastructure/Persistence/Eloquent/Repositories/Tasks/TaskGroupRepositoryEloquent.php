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

    public function findByCode(string $code): ?TaskGroup
    {
        $model = $this->eloquentModel
            ->where('code', '=', $code)
            ->first();
        
            return $this->mapper->toDomain($model);
    }

    public function byCode(string|array $code): ?array
    {
        $code = Arr::wrap($code);

        return $this->eloquentModel->whereIn('code', $code)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }
}
