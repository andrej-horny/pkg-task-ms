<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use App\Models\IncidentAssignment;
use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Dpb\Package\Tasks\Services\CreateTaskService;
use Illuminate\Support\Carbon;

class CreateTaskFromIncidentUesCase
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
            Carbon::now(),
             null,
            $incidentAssignment->incident->description,
            $this->taskGroupRepo->findByCode($incidentAssignment->incident->type->code)->id(),
            null,
            null
        );

        return $this->createSvc->handle($task);
    }
}
