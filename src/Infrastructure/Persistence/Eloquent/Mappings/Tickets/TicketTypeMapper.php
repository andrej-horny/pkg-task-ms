<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tickets;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tickets\EloquentTicketType;
use Dpb\Package\Tickets\Entities\TicketType;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TicketTypeMapper
{
    public function __construct(
        private EloquentTicketType $eloquentModel,
    ) {}

    public function toDomain(EloquentTicketType $model): TicketType
    {
        return new TicketType(
            id: $model->id,
            code: $model->code,
            title: $model->title,
        );
    }

    public function toEloquent(TicketType $ticketType): EloquentTicketType
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $ticketType->id()]);
        $model->code = $ticketType->code();
        $model->title = $ticketType->title();
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
