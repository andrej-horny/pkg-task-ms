<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\EloquentTask;
use Dpb\Package\Tasks\Entities\Task;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TaskMapper
{
    public function toDomain(EloquentTask $model): Task
    {
        return new Task(
            $model->id,
            $model->date,
            $model->title,
            $model->description,
            $model->group_id,
            null,
            $model->state,
            null,
            null,
        );
    }

    public function toEloquent(Task $task): EloquentTask
    {
        $model = EloquentTask::firstOrNew(['id' => $task->id()]);
        $model->date = $task->date();
        $model->title = $task->title();
        $model->description = $task->description();
        $model->group_id = $task->taskGroupId();
        // $model->sate = $task->state();
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
