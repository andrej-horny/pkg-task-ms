<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use DateTimeImmutable;
use Dpb\Package\TaskMS\Application\Factories\Tasks\TaskAssigneeFactory;
use Dpb\Package\TaskMS\Application\Factories\Tasks\TaskSubjectFactory;
use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Repositories\TaskGroupRepositoryInterface;
use Dpb\Package\Tasks\Services\CreateTaskService;

class CreateTaskUseCase
{
    public function __construct(
        private CreateTaskService $createSvc,
        private IdGeneratorInterface $idGenerator,
        private TaskGroupRepositoryInterface $tgRepo,
        private TaskSubjectFactory $subjectFactory,
        private TaskAssigneeFactory $assigneeFactory,
    ) {}

    public function execute(array $data): ?Task
    {
        // subject
        $subject = $this->subjectFactory->make('vehicle', $data['subject_id']);        
        $assignee = $this->assigneeFactory->make('maintenance-group', $data['assigned_to_id']);        

        $task = new Task(
            $this->idGenerator->generate(),
            new DateTimeImmutable($data['date']),
            $data['title'] ?? null,
            $data['description'] ?? null,
            $this->tgRepo->findById($data['group_id']),
            $subject,
            null,
            $assignee,
            auth()->user()->id,
        );
        // dd($task);
        return $this->createSvc->handle($task);
    }
}
