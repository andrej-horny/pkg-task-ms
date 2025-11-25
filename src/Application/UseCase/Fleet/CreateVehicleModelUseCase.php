<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Fleet;

use Dpb\Package\Fleet\Entities\VehicleModel;
use Dpb\Package\Fleet\Repositories\VehicleBrandRepositoryInterface;
use Dpb\Package\Fleet\Repositories\VehicleTypeRepositoryInterface;
use Dpb\Package\Fleet\Services\CreateVehicleModelService;
use Dpb\Package\TaskMS\Infrastructure\Services\LaravelIdGenerator;

class CreateVehicleModelUseCase
{
    public function __construct(
        private CreateVehicleModelService $createSvc,
        private LaravelIdGenerator $idGenerator,
        private VehicleTypeRepositoryInterface $vtRepo,
        private VehicleBrandRepositoryInterface $vbRepo,
    ) {}

    public function execute(array $data): ?VehicleModel
    {
        // vehicle type
        $type = $this->vtRepo->findById($data['type_id']);
        // vehicle brand
        $brand = $this->vbRepo->findById($data['brand_id']);

        $vehicleModel = new VehicleModel(
            $this->idGenerator->generate(),
            $data['title'],
            $data['year'],
            $type,
            $brand
        );

        return $this->createSvc->handle($vehicleModel);
    }
}
