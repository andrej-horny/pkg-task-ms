<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Fleet;

use Dpb\Package\Fleet\Entities\VehicleGroup;
use Dpb\Package\Fleet\Services\CreateVehicleGroupService;
use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;

class CreateVehicleGroupUseCase
{
    public function __construct(
        private CreateVehicleGroupService $createSvc,
        private IdGeneratorInterface $idGenerator,
    ) {}

    public function execute(array $data): ?VehicleGroup
    {
        $vehicleGroup = new VehicleGroup(
            $this->idGenerator->generate(),
            $data['code'],
            $data['title'],
            $data['description']
        );

        return $this->createSvc->handle($vehicleGroup);
    }
}
