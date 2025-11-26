<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use DateTimeImmutable;
use Dpb\Package\TaskMS\Application\Factories\Tasks\TaskSubjectFactory;
use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;
use Dpb\Package\Tasks\Entities\Task;
use Dpb\Package\Tasks\Services\CreateTaskService;

class CreateTaskUseCase
{
    public function __construct(
        private CreateTaskService $createSvc,
        private IdGeneratorInterface $idGenerator,
        private TaskSubjectFactory $subjectFactory,
    ) {}

    public function execute(array $data): ?Task
    {
        // subject
        $subject = $this->subjectFactory->make('vehicle', $data['subject_id']);        

        $task = new Task(
            $this->idGenerator->generate(),
            new DateTimeImmutable($data['date']),
            $data['title'] ?? null,
            $data['description'] ?? null,
            $data['group'] ?? null,
            $subject,
            null,
            auth()->user()->id,
        );
        
        return $this->createSvc->handle($task);
    }
}
