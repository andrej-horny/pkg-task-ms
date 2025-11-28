<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;
use Dpb\Package\Tasks\Entities\PlaceOfOccurrence;
use Dpb\Package\Tasks\Services\CreatePlaceOfOccurrenceService;

class CreatePlaceOfOccurrenceUseCase
{
    public function __construct(
        private CreatePlaceOfOccurrenceService $createSvc,
        private IdGeneratorInterface $idGenerator,
    ) {}

    public function execute(array $data): ?PlaceOfOccurrence
    {
        $placeOfOccurence = new PlaceOfOccurrence(
            $this->idGenerator->generate(),
            $data['uri'] ?? null,
            $data['title'] ?? null,
            $data['description'] ?? null,
        );
        
        return $this->createSvc->handle($placeOfOccurence);
    }
}
