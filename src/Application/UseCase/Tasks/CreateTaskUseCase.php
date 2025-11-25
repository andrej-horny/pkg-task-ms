<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\Fleet\Repositories\VehicleRepositoryInterface;
use Dpb\Package\TaskMS\Infrastructure\Adapters\Tasks\VehicleSubjectAdapter as VehicleTaskSubjectAdapter;
use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Services\CreateTaskService;

class CreateTaskUseCase
{
    public function __construct(
        private CreateTaskService $createSvc,
        private LaravelIdGenerator $idGenerator,
        private VehicleRepositoryInterface $vehicleRepo,
    ) {}

    public function execute(array $data): ?Task
    {
        // subject
        $vehicle = $this->vehicleRepo->findById($data['subject']);
        $subject = new VehicleTaskSubjectAdapter($vehicle);

        $task = new Task(
            $this->idGenerator->generate(),
            $data['date'],
            $data['title'] ?? null,
            $data['description'] ?? null,
            $data['group'] ?? null,
            $subject,
            null
        );
        
        return $this->createSvc->handle($task);
    }
}
