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
	// Recupere les dernière 24h de données de la table temperature, si les dernières données sont plus anciennes que 24h alors prendre cela
	public function getDataTEMP($cinemaId)
	{
		$dataTEMP = $this->db->makeRequest("SELECT date, value FROM TempValue 
		WHERE cinemaId = :cinemaId AND date >= (SELECT MAX(date) FROM TempValue WHERE cinemaId = :cinemaId) - INTERVAL 24 HOUR", [':cinemaId' => $cinemaId]);

		return $this->makeArrayDataMonitoringSingle($dataTEMP);
	}

	public function getDataSound($cinemaId)
	{
		$dataSound = $this->db->makeRequest("SELECT date, value FROM SoundValue 
		WHERE cinemaId = :cinemaId AND date >= (SELECT MAX(date) FROM SoundValue WHERE cinemaId = :cinemaId) - INTERVAL 24 HOUR", [':cinemaId' => $cinemaId]);

		return $this->makeArrayDataMonitoringSingle($dataSound);
	}

	public function getDataCO2($cinemaId)
	{
		$dataCO2 = $this->db->makeRequest("SELECT date, value FROM CO2Value 
		WHERE cinemaId = :cinemaId AND date >= (SELECT MAX(date) FROM CO2Value WHERE cinemaId = :cinemaId) - INTERVAL 24 HOUR", [':cinemaId' => $cinemaId]);

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
