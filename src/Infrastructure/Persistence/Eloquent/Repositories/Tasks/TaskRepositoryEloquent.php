<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks\TaskItemMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentTask;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks\TaskMapper;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Arr;

class TaskRepositoryEloquent implements TaskRepositoryInterface
{
    public function __construct(
        private TaskMapper $mapper,
        private TaskItemMapper $tiMapper,
        private EloquentTask $eloquentModel
    ) {}

    public function save(Task $task): Task
    {
        $model = $this->mapper->toEloquent($task);
        // dd($model);
        $model->save();
        // $model->taskItems()->saveMany();

        // --------------------------------------------
        // Save added items
        // --------------------------------------------
        foreach ($task->addedItems() as $item) {
            $model->taskItems()->create([
                'id' => $item->id(),
                'date' => $item->date(),
                'group_id' => $item->group()->id(),
                // $item->title(),
                // $this->tiMapper->toEloquent($item)
            ]
            );
        }

        // remove items

        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?Task
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

    public function findByTaskGroupUri(string|array $uri): ?array
    {
        $uri = Arr::wrap($uri);

        return $this->eloquentModel
            ->whereHas('troup', function ($q) use ($uri) {
                $q->byUri($uri);
            })
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }
}
