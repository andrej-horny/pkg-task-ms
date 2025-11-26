<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tickets;

use DateTimeImmutable;
use Dpb\Package\TaskMS\Application\Factories\Tickets\TicketSubjectFactory;
use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;
use Dpb\Package\Tickets\Entities\Ticket;
use Dpb\Package\Tickets\Repositories\TicketTypeRepositoryInterface;
use Dpb\Package\Tickets\Services\CreateTicketService;

class CreateTicketUseCase
{
    public function __construct(
        private CreateTicketService $createSvc,
        private IdGeneratorInterface $idGenerator,
        private TicketTypeRepositoryInterface $ttRepo,
        private TicketSubjectFactory $subjectFactory,
    ) {}

    public function execute(array $data): ?Ticket
    {
        // ticket type
        $ticketType = $this->ttRepo->findById($data['type_id']);
        // subject
        $subject = $this->subjectFactory->make('vehicle', $data['subject_id']);        

        // dd($data['date']);
        $ticket = new Ticket(
            $this->idGenerator->generate(),
            new DateTimeImmutable($data['date']),
            $ticketType,
            $subject,
            auth()->user()->id,
            null
        );

        return $this->createSvc->handle($ticket);
    }
}
