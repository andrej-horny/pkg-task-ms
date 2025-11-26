<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tickets;

use DateTimeImmutable;
use Dpb\Package\TaskMS\Application\Factories\Tickets\TicketSubjectFactory;
use Dpb\Package\Tickets\Entities\Ticket;
use Dpb\Package\Tickets\Repositories\TicketRepositoryInterface;
use Dpb\Package\Tickets\Repositories\TicketTypeRepositoryInterface;
use Dpb\Package\Tickets\Services\UpdateTicketService;

class UpdateTicketUseCase
{
    public function __construct(
        private UpdateTicketService $updateSvc,
        private TicketRepositoryInterface $repository,
        private TicketTypeRepositoryInterface $ttRepo,
        private TicketSubjectFactory $subjectFactory,
    ) {}

    public function execute(string $id, array $data): ?Ticket
    {
        $ticket = $this->repository->findById($id);

        if (!$ticket) {
            throw new \Exception("Ticket not found");
        }

        if (array_key_exists('date', $data)) {
            $ticket->updateDate(new DateTimeImmutable($data['date']));
        }

        if (array_key_exists('type_id', $data)) {
            $ticketType = $this->ttRepo->findById($data['type_id']);
            $ticket->assignType($ticketType);
        }

        if (array_key_exists('description', $data)) {
            $ticket->updateDescription($data['description']);
        }

        if (array_key_exists('subject_id', $data)) {
            $subject = $this->subjectFactory->make('vehicle', $data['subject_id']);
            $ticket->assignSubject($subject);
        }  
        
        return $this->updateSvc->handle($ticket);
    }
}
