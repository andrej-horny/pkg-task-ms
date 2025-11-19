<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Services\CreateTaskService;

class CreateTaskUesCase
{
    public function __construct(
        private CreateTaskService $createSvc,
        private LaravelIdGenerator $idGenerator
    ) {}

    public function execute(array $data): ?Task
    {
        $task = new Task(
            $this->idGenerator->generate(),
            $data['date'],
            $data['title'] ?? null,
            $data['description'] ?? null,
            $data['group'] ?? null,
            null,
            null
        );
        
        return $this->createSvc->handle($task);
    }
}
