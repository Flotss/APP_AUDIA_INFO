<?php

namespace App\Service;

use App\Database\DataBaseSingleton;
use App\Entity\DataMonitoringSingle;

class MonitoringService
{
	private DataBaseSingleton $db;

	public function __construct()
	{
		$this->db = DataBaseSingleton::getInstance();
	}

	public function getDataTEMP($cinemaId)
	{
		$dataTEMP = $this->db->makeRequest("SELECT date, value FROM TempValue 
		WHERE cinemaId = :cinemaId AND (date >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
		 OR date >= (SELECT date FROM TempValue WHERE cinemaId = :cinemaId ORDER BY date DESC LIMIT 1 OFFSET 24))", [':cinemaId' => $cinemaId]);

		return $this->makeArrayDataMonitoringSingle($dataTEMP);
	}

	public function getDataSound($cinemaId)
	{
		$dataSound = $this->db->makeRequest("SELECT date, value FROM SoundValue 
		WHERE cinemaId = :cinemaId AND (date >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
		 OR date >= (SELECT date FROM SoundValue WHERE cinemaId = :cinemaId ORDER BY date DESC LIMIT 1 OFFSET 24))", [':cinemaId' => $cinemaId]);

		return $this->makeArrayDataMonitoringSingle($dataSound);
	}

	public function getDataCO2($cinemaId)
	{
		$dataCO2 = $this->db->makeRequest("SELECT date, value FROM CO2Value 
		WHERE cinemaId = :cinemaId AND (date >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
		 OR date >= (SELECT date FROM CO2Value WHERE cinemaId = :cinemaId ORDER BY date DESC LIMIT 1 OFFSET 24))", [':cinemaId' => $cinemaId]);

		return $this->makeArrayDataMonitoringSingle($dataCO2);
	}


	private function makeArrayDataMonitoringSingle($data)
	{
		if (empty($data)) {
			return [];
		}

		$tab = [];
		foreach ($data as $value) {
			$tab[] = new DataMonitoringSingle($value['date'], $value['value']);
		}
		return $tab;
	}
}
