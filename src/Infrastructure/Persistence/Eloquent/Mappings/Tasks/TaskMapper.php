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
        private EloquentTaskAssigneeFactory $assigneeFacotry,
        private TaskGroupMapper $tgMapper,
        private TaskItemMapper $tiMapper,
        private PlaceOfOccurrenceMapper $poMapper,
    ) {}

    public function toDomain(EloquentTask $model): Task
    {
        $taskItems = $model->taskItems
            ->map(fn ($itemModel) => $this->tiMapper->toDomain($itemModel))
            ->toArray();

        return new Task(
            id: $model->id,
            date: new DateTimeImmutable($model->date),
            // date: $model->date,
            title: $model->title,
            description: $model->description,
            taskGroup: $model->group ? $this->tgMapper->toDomain($model->group) : null,
            subject: $this->subjectFactory->make($model->subject),
            assignedTo: $this->assigneeFacotry->make($model->assignedTo),
            placeOfOccurence: $model->placeOfOccurence ? $this->poMapper->toDomain($model->placeOfOccurence) : null,
            authorId: $model->author_id,
            // taskItems: $taskItems
        );
    }

    public function toEloquent(Task $task): EloquentTask
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $task->id()]);
        $model->date = $task->date();
        $model->title = $task->title();
        $model->description = $task->description();
        $model->group_id = $task->taskGroup()->id();
        $model->assigned_to_id = $task->assignedTo()?->assigneeId();
        $model->assigned_to_type = $task->assignedTo()?->assigneeType();
        $model->subject_id = $task->subject()?->subjectId();
        $model->subject_type = $task->subject()?->subjectType();
        $model->place_of_occurence_id = $task->placeOfOccurence()?->id();
        $model->author_id = $task->authorId();

        // $model->sate = $task->state();
        // map items 
        // $model->items = collect($task->taskItems())
        //     ->map(fn($item) => $this->tiMapper->toEloquent($item))
        //     ->toArray();

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
