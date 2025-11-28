<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks;

use DateTimeImmutable;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentTaskItem;
use Dpb\Package\Tasks\Entities\TaskItem;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TaskItemMapper
{
    public function __construct(
        private EloquentTaskItem $eloquentModel,
        private TaskItemGroupMapper $tigMapper,
    ) {}

    public function toDomain(EloquentTaskItem $model): TaskItem
    {
        return new TaskItem(
            $model->id,
            // $model->code,
            new DateTimeImmutable($model->date),
            $model->title,
            $model->description,
            $model->group ? $this->tigMapper->toDomain($model->group) : null,
        );
    }

    public function toEloquent(TaskItem $taskItem): EloquentTaskItem
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $taskItem->id()]);
        // $model->code = $taskItem->code();
        $model->date = $taskItem->date();
        $model->title = $taskItem->title();
        $model->description = $taskItem->description();
        $model->group_id = $taskItem->group()->id();
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
