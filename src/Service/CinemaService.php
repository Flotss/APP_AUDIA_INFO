<?php

namespace App\Service;

use App\Database\DataBaseSingleton;

class CinemaService
{
	private DataBaseSingleton $db;

	public function __construct()
	{
		$this->db = DataBaseSingleton::getInstance();
	}

	public function getCinemas()
	{
		$cinemas = $this->db->makeRequest("SELECT * FROM Cinema");
		return $cinemas;
	}
}
