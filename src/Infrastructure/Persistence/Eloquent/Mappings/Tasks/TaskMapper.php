<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks;

use DateTimeImmutable;
use Dpb\Package\TaskMS\Application\Factories\Tasks\EloquentTaskAssigneeFactory;
use Dpb\Package\TaskMS\Application\Factories\Tasks\EloquentTaskSubjectFactory;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentTask;
use Dpb\Package\Tasks\Entities\Task;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TaskMapper
{
    public function __construct(
        private EloquentTask $eloquentModel,
        private EloquentTaskSubjectFactory $subjectFactory,
        private EloquentTaskAssigneeFactory $assigneeFacotry
    ) {}

    public function toDomain(EloquentTask $model): Task
    {
        return new Task(
            id: $model->id,
            // date: new DateTimeImmutable($model->date),
            date: $model->date,
            title: $model->title,
            description: $model->description,
            taskGroupId: $model->group_id,
            subject: $this->subjectFactory->make($model->subject),
            assignedTo: $this->assigneeFacotry->make($model->assignedTo),
            authorId: $model->author_id
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
