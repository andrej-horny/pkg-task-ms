<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use App\Models\IncidentAssignment;
use DateTimeImmutable;
use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Dpb\Package\Tasks\Services\CreateTaskService;

class CreateTaskFromIncidentUseCase
{
    public function __construct(
        private CreateTaskService $createSvc,
        private LaravelIdGenerator $idGenerator,
        private TaskGroupRepositoryInterface $taskGroupRepo,
    ) {}

    public function execute(IncidentAssignment $incidentAssignment): ?Task
    {
        $task = new Task(
            $this->idGenerator->generate(),
            new DateTimeImmutable('now'),
             null,
            $incidentAssignment->incident->description,
            $this->taskGroupRepo->findByUri($incidentAssignment->incident->type->code)->id(),
            null,
            null,
            null,
            auth()->user()->id,
        );

        return $this->createSvc->handle($task);
    }
}
