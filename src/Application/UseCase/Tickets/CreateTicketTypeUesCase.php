<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tickets;

use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Tickets\Entities\TicketType;
use Dpb\Package\Tickets\Services\CreateTicketTypeService;

class CreateTicketTypeUesCase
{
    public function __construct(
        private CreateTicketTypeService $createSvc,
        private LaravelIdGenerator $idGenerator
    ) {}

    public function execute(array $data): ?TicketType
    {
        $ticketType = new TicketType(
            $this->idGenerator->generate(),
            $data['code'],
            $data['title'] ?? null,
        );
        
        return $this->createSvc->handle($ticketType);
    }
}
