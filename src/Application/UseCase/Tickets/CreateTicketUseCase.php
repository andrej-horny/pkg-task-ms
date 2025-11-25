<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tickets;

use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tickets\VehicleSubjectAdapter;
use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Tickets\Entities\Ticket;
use Dpb\Package\Tickets\Repositories\TicketTypeRepositoryInterface;
use Dpb\Package\Tickets\Services\CreateTicketService;
use Illuminate\Support\Carbon;

class CreateTicketUseCase
{
    public function __construct(
        private CreateTicketService $createSvc,
        private LaravelIdGenerator $idGenerator,
        private TicketTypeRepositoryInterface $ttRepo,
        private VehicleRepositoryInterface $vehicleRepo,
    ) {}

    public function execute(array $data): ?Ticket
    {
        // ticket type
        $ticketType = $this->ttRepo->findById($data['type_id']);
        // subject
        $vehicle = $this->vehicleRepo->findById($data['subject']);
        $subject = new VehicleSubjectAdapter($vehicle);

        // dd($data['date']);
        $ticket = new Ticket(
            $this->idGenerator->generate(),
            Carbon::createFromFormat('Y-m-d', $data['date']),
            $ticketType,
            $subject,
            auth()->user()->id,
            null
        );

        return $this->createSvc->handle($ticket);
    }
}
