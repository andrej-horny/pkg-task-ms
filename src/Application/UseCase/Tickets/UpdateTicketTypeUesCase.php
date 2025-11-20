<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tickets;

use Dpb\Package\Tickets\Entities\TicketType;
use Dpb\Package\Tickets\Repositories\TicketTypeRepositoryInterface;
use Dpb\Package\Tickets\Services\UpdateTicketTypeService;

class UpdateTicketTypeUesCase
{
    public function __construct(
        private UpdateTicketTypeService $updateSvc,
        private TicketTypeRepositoryInterface $repository,
    ) {}

    public function execute(string $id, array $data): ?TicketType
    {
        $task = $this->repository->findById($id);

        if (!$task) {
            throw new \Exception("TicketType not found");
        }

        if (isset($data['title'])) {
            $task->rename($data['title']); 
        }

        if (array_key_exists('code', $data)) {
            $task->updateCode($data['code']);
        }

        return $this->updateSvc->handle($task);
    }
}
