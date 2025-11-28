<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentTaskItemGroup;
use Dpb\Package\Tasks\Entities\TaskItemGroup;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TaskItemGroupMapper
{
    public function __construct(
        private EloquentTaskItemGroup $eloquentModel,
        // private TaskGroupMapper $tgMapper,
    ) {}

    public function toDomain(EloquentTaskItemGroup $model): TaskItemGroup
    {
        return new TaskItemGroup(
            $model->id,
            $model->uri,
            $model->title,
            // $model->group ? $this->tgMapper->toDomain($model->group) : null,
        );
    }

    public function toEloquent(TaskItemGroup $taskItemGroup): EloquentTaskItemGroup
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $taskItemGroup->id()]);
        $model->code = $taskItemGroup->code();
        $model->title = $taskItemGroup->title();
        // $model->task_group_id = $taskItemGroup->taskGroup()->id();
        return $model;
    }

    public function toDomainCollection(EloquentCollection $models): array
    {
        return $models
            ->map(
                fn($model) =>
                $this->toDomain($model)
            )
            ->all();
    }
}
