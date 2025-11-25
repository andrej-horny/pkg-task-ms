<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Fleet;

use Dpb\Package\Fleet\Entities\VehicleBrand;
use Dpb\Package\Fleet\Services\CreateVehicleBrandService;
use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;

class CreateVehicleBrandUseCase
{
    public function __construct(
        private CreateVehicleBrandService $createSvc,
        private LaravelIdGenerator $idGenerator,
    ) {}

    public function execute(array $data): ?VehicleBrand
    {
        $vehicleBrand = new VehicleBrand(
            $this->idGenerator->generate(),
            $data['title']
        );

        return $this->createSvc->handle($vehicleBrand);
    }
}
