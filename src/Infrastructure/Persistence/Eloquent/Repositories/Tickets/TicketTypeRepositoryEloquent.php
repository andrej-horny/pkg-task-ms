<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Repositories\Tickets;

use Dpb\Package\Tickets\Entities\TicketType;
use Dpb\Package\Tickets\Repositories\TicketTypeRepositoryInterface;
use Illuminate\Support\Arr;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tickets\TicketTypeMapper;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tickets\EloquentTicketType;

class TicketTypeRepositoryEloquent implements TicketTypeRepositoryInterface
{
    public function __construct(
        private TicketTypeMapper $mapper,
        private EloquentTicketType $eloquentModel
        ) {}

    public function save(TicketType $taskGroup): TicketType
    {
        $model = $this->mapper->toEloquent($taskGroup);
        $model->save();
        return $this->mapper->toDomain($model);
    }

    public function findById(string $id): ?TicketType
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

    public function findByCode(string $code): ?TicketType
    {
        $model = $this->eloquentModel
            ->where('code', '=', $code)
            ->first();
        
            return $this->mapper->toDomain($model);
    }

    public function byCode(string|array $code): ?array
    {
        $code = Arr::wrap($code);

        return $this->eloquentModel->whereIn('code', $code)
            ->get()
            ->map(fn($m) => $this->mapper->toDomain($m))
            ->toArray();
    }
}
