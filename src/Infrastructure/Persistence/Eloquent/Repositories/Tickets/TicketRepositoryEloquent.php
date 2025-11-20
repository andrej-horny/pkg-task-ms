<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Tickets;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tickets\TicketMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tickets\EloquentTicketType;
use Dpb\Package\Tickets\Entities\Ticket;
use Dpb\Package\Tickets\Repositories\TicketRepositoryInterface;

class TicketRepositoryEloquent implements TicketRepositoryInterface
{
    public function __construct(
        private TicketMapper $mapper,
        private EloquentTicketType $eloquentModel
        ) {}

    public function save(Ticket $ticket): Ticket
    {
        $model = $this->mapper->toEloquent($ticket);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?Ticket
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

}
