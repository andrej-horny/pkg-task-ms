<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Fleet;

use Dpb\Package\Fleet\Entities\VehicleType;
use Dpb\Package\Fleet\Services\CreateVehicleTypeService;
use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;

class CreateVehicleTypeUseCase
{
    public function __construct(
        private CreateVehicleTypeService $createSvc,
        private LaravelIdGenerator $idGenerator,
    ) {}

    public function execute(array $data): ?VehicleType
    {
        $vehicleType = new VehicleType(
            $this->idGenerator->generate(),
            $data['code'],
            $data['title']
        );

        return $this->createSvc->handle($vehicleType);
    }
}
