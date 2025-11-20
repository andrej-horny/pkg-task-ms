<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tickets;

use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Tickets\Entities\Ticket;
use Dpb\Package\Tickets\Repositories\TicketTypeRepositoryInterface;
use Dpb\Package\Tickets\Services\CreateTicketService;
use Illuminate\Support\Carbon;

class CreateTicketUesCase
{
    public function __construct(
        private CreateTicketService $createSvc,
        private LaravelIdGenerator $idGenerator,
        private TicketTypeRepositoryInterface $ttRepo,
    ) {}

    public function execute(array $data): ?Ticket
    {
        $ticketType = $this->ttRepo->findById($data['type_id']);
// dd($data['date']);
        $ticket = new Ticket(
            $this->idGenerator->generate(),
            Carbon::createFromFormat('Y-m-d', $data['date']),
            $ticketType ,
            null,
            auth()->user()->id,
            null
        );

        return $this->createSvc->handle($ticket);
    }
}
