<?php

namespace App\Entity;

use App\Service\MonitoringService;

class DataMonitoring
{

    private $dataTemperature; // DATAMONITORING SINGLE ARRAY
    private $dataSound;
    private $dataCO2;

    public function __construct()
    {
        $this->dataTemperature = [];
        $this->dataSound = [];
        $this->dataCO2 = [];
    }

    public function generateData($id): self
    {
        $service = new MonitoringService();

        $this->dataTemperature = $service->getDataTEMP($id);
        $this->dataSound = $service->getDataSound($id);
        $this->dataCO2 = $service->getDataCO2($id);

        return $this;
    }

    public function getMonitoring($id): array
    {
        $this->generateData($id);
        return $this->serialize();
    }

    public function getDataTemperature(): array
    {
        return $this->dataTemperature;
    }

    public function getDataSound(): array
    {
        return $this->dataSound;
    }

    public function getDataCO2(): array
    {
        return $this->dataCO2;
    }

    private function serialize(): array
    {
        return [
            'dataTemperature' => $this->serializeData($this->dataTemperature),
            'dataSound' => $this->serializeData($this->dataSound),
            'dataCO2' => $this->serializeData($this->dataCO2),
        ];
    }

    private function serializeData($data): array
    {
        $result = [];
        foreach ($data as $item) {
            $result[] = [
                'value' => $item->getValue(),
                'date' => $item->getDate(),
            ];
        }
        return $result;
    }
}
