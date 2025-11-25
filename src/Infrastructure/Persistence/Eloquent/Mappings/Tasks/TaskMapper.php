<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentTask;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\MaintenanceGroupAssigneeAdapter;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\VehicleSubjectAdapter as VehicleTaskSubjectAdapter;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet\MaintenanceGroupMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Fleet\VehicleMapper;
use Dpb\Package\Tasks\Entities\Task;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TaskMapper
{
    public function __construct(
        private EloquentTask $eloquentModel,
        private MaintenanceGroupMapper $mgMapper,
        private VehicleMapper $vehicleMapper,
        // private MaintenanceGroupAssigneeAdapter $mgAdapter,
    ) {}

    public function toDomain(EloquentTask $model): Task
    {

        $subject = null;
        if ($model->subject != null) {
            $vehicle = $this->vehicleMapper->toDomain($model->subject);
            new VehicleTaskSubjectAdapter($vehicle);
        }  

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
            subject: $subject,
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
        $model->subject_id = $task->subject()?->subjectId();
        $model->subject_type = $task->subject()?->subjectType();

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
