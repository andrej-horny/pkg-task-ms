<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks\PlaceOfOccurrenceMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentPlaceOfOccurrence;
use Dpb\Package\Tasks\Entities\PlaceOfOccurrence;
use Dpb\Package\Tasks\Repositories\PlaceOfOccurrenceRepositoryInterface;
use Illuminate\Support\Arr;

class PlaceOfOccurrenceRepositoryEloquent implements PlaceOfOccurrenceRepositoryInterface
{
    public function __construct(
        private PlaceOfOccurrenceMapper $mapper,
        private EloquentPlaceOfOccurrence $eloquentModel
        ) {}

    public function save(PlaceOfOccurrence $taskGroup): PlaceOfOccurrence
    {
        $model = $this->mapper->toEloquent($taskGroup);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?PlaceOfOccurrence
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

    public function findByUri(string $uri): ?PlaceOfOccurrence
    {
        $model = $this->eloquentModel
            ->where('uri', '=', $uri)
            ->first();
        
            return $this->mapper->toDomain($model);
    }

    public function byUri(string|array $uri): ?array
    {
        $uri = Arr::wrap($uri);

        return $this->eloquentModel->whereIn('uri', $uri)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }
}
