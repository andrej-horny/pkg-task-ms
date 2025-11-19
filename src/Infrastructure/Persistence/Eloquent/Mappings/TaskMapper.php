<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\EloquentTask;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\MaintenanceGroupAssigneeAdapter;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet\MaintenanceGroupMapper;
use Dpb\Package\Tasks\Entities\Task;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TaskMapper
{
    public function __construct(
        private EloquentTask $eloquentModel,
        private MaintenanceGroupMapper $mgMapper,
        // private MaintenanceGroupAssigneeAdapter $mgAdapter,
    ) {}

    public function toDomain(EloquentTask $model): Task
    {
        $assignedTo = null;
        if ($model->assignedTo != null) {
            $maintenanceGroup = $this->mgMapper->toDomain($model->assignedTo);
            new MaintenanceGroupAssigneeAdapter($maintenanceGroup);
        }           

        return new Task(
            id: $model->id,
            date: $model->date,
            title: $model->title,
            description: $model->description,
            taskGroupId: $model->group_id,
            subject: null,
            assignedTo: $assignedTo
            // assignedTo: new $this->mgAdapter($model->assignedTo)
            // $model->subject,
            // $model->assig,
            // null,
            // $model->state,
            // null,
            // null,
        );
    }

    public function toEloquent(Task $task): EloquentTask
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $task->id()]);
        $model->date = $task->date();
        $model->title = $task->title();
        $model->description = $task->description();
        $model->group_id = $task->taskGroupId();
        $model->assigned_to_id = $task->assignedTo()?->assigneeId();
        $model->assigned_to_type = $task->assignedTo()?->assigneeType();
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
