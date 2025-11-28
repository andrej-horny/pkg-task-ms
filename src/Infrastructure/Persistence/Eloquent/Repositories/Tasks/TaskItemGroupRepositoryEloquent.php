<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks\TaskItemGroupMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentTaskItemGroup;
use Dpb\Package\Tasks\Entities\TaskItemGroup;
use Dpb\Package\Tasks\Repositories\TaskItemGroupRepositoryInterface;

class TaskItemGroupRepositoryEloquent implements TaskItemGroupRepositoryInterface
{
    public function __construct(
        private TaskItemGroupMapper $mapper,
        private EloquentTaskItemGroup $eloquentModel
        ) {}

    public function save(TaskItemGroup $taskItemGroup): TaskItemGroup
    {
        $model = $this->mapper->toEloquent($taskItemGroup);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?TaskItemGroup
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

}
