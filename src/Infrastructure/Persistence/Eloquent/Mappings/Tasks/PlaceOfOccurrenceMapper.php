<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks\EloquentPlaceOfOccurrence;
use Dpb\Package\Tasks\Entities\PlaceOfOccurrence;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class PlaceOfOccurrenceMapper
{
    public function toDomain(EloquentPlaceOfOccurrence $model): PlaceOfOccurrence
    {
        return new PlaceOfOccurrence(
            $model->id,
            $model->uri,
            $model->title,
            $model->description,
        );
    }

    public function toEloquent(PlaceOfOccurrence $placeOfOccurence): EloquentPlaceOfOccurrence
    {
        $model = EloquentPlaceOfOccurrence::firstOrNew(['id' => $placeOfOccurence->id()]);
        $model->uri = $placeOfOccurence->uri();
        $model->title = $placeOfOccurence->title();
        $model->description = $placeOfOccurence->description();
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
