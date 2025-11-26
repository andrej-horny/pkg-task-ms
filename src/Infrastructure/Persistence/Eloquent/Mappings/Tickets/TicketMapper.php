<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Mappings\Tickets;

use DateTimeImmutable;
use Dpb\Package\TaskMS\Application\Factories\Tickets\EloquentTicketSubjectFactory;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tickets\EloquentTicket;
use Dpb\Package\Tickets\Entities\Ticket;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class TicketMapper
{
    public function __construct(
        private EloquentTicket $eloquentModel,
        private TicketTypeMapper $ttMapper,
        private EloquentTicketSubjectFactory $subjectFactory,
    ) {}

    public function toDomain(EloquentTicket $model): Ticket
    {
        return new Ticket(
            id: $model->id,
            date: new DateTimeImmutable($model->date),
            type: $this->ttMapper->toDomain($model->type),
            subject: $this->subjectFactory->make($model->subject),
            authorId: $model->author_id,
            description: $model->description,
        );
    }

    public function toEloquent(Ticket $ticket): EloquentTicket
    {
        $model = $this->eloquentModel->firstOrNew(['id' => $ticket->id()]);
        $model->date = $ticket->date();
        $model->description = $ticket->description();
        $model->type_id = $ticket->type()->id();
        $model->author_id = $ticket->authorId();
        $model->subject_id = $ticket->subject()->subjectId();
        $model->subject_type = $ticket->subject()->subjectType();
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
