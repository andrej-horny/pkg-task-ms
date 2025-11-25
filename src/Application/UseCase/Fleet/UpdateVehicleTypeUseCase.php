<?php

namespace Dpb\Package\TaskMS\Application\UseCase\Fleet;

use Dpb\Package\Fleet\Entities\VehicleType;
use Dpb\Package\Fleet\Repositories\VehicleTypeRepositoryInterface;
use Dpb\Package\Fleet\Services\UpdateVehicleTypeService;

class UpdateVehicleTypeUseCase
{
    public function __construct(
        private UpdateVehicleTypeService $updateSvc,
        private VehicleTypeRepositoryInterface $vbRepo,
    ) {}

    public function execute(string $id, array $data): ?VehicleType
    {
        $vehicleType = $this->vbRepo->findById($id);

        if (!$vehicleType) {
            throw new \Exception("VehicleType not found");
        }

        if (array_key_exists('code', $data)) {
            $vehicleType->updateCode($data['code']);
        }

        if (array_key_exists('title', $data)) {
            $vehicleType->rename($data['title']);
        }

        return $this->updateSvc->handle($vehicleType);
    }
}
