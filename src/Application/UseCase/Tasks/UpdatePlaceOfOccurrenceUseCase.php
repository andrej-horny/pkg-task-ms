<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Tasks;

use Dpb\Package\Tasks\Entities\PlaceOfOccurrence;
use Dpb\Package\Tasks\Repositories\PlaceOfOccurrenceRepositoryInterface;
use Dpb\Package\Tasks\Services\UpdatePlaceOfOccurrenceService;

class UpdatePlaceOfOccurrenceUseCase
{
    public function __construct(
        private UpdatePlaceOfOccurrenceService $updateSvc,
        private PlaceOfOccurrenceRepositoryInterface $repository,
    ) {}

    public function execute(string $id, array $data): ?PlaceOfOccurrence
    {
        $placeOfOccurence = $this->repository->findById($id);

        if (!$placeOfOccurence) {
            throw new \Exception("TaskGroup not found");
        }

        if (isset($data['title'])) {
            $placeOfOccurence->rename($data['title']); // domain behavior
        }

        if (array_key_exists('uri', $data)) {
            $placeOfOccurence->updateUri($data['uri']);
        }

        if (array_key_exists('description', $data)) {
            $placeOfOccurence->updateDescription($data['description']);
        }
        
        return $this->updateSvc->handle($placeOfOccurence);
    }
}
