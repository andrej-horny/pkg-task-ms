<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tickets;

use Dpb\Package\Tickets\Entities\Ticket;
use Dpb\Package\Tickets\Repositories\TicketRepositoryInterface;
use Dpb\Package\Tickets\Repositories\TicketTypeRepositoryInterface;
use Dpb\Package\Tickets\Services\UpdateTicketService;
use Illuminate\Support\Carbon;

class UpdateTicketUesCase
{
    public function __construct(
        private UpdateTicketService $updateSvc,
        private TicketRepositoryInterface $repository,
        private TicketTypeRepositoryInterface $ttRepo,
    ) {}

    public function execute(string $id, array $data): ?Ticket
    {
        $ticket = $this->repository->findById($id);

        if (!$ticket) {
            throw new \Exception("TicketType not found");
        }

        if (array_key_exists('date', $data)) {
            $ticket->updateDate(Carbon::createFromFormat('Y-m-d', $data['date']));
        }

        if (array_key_exists('type_id', $data)) {
            $ticketType = $this->ttRepo->findById($data['type_id']);
            $ticket->assignType($ticketType);
        }

        if (array_key_exists('description', $data)) {
            $ticket->updateDescription($data['description']);
        }

        return $this->updateSvc->handle($ticket);
    }
}
