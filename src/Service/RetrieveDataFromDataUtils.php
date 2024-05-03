<?php

namespace App\Service;

use App\Database\DataBaseSingleton;
use App\Entity\Content;


class RetrieveDataFromDataUtils
{

    private DataBaseSingleton $db;

    public function __construct()
    {
        $this->db = DataBaseSingleton::getInstance();
    }

    public function getContentByKey($key): Content
    {
        $result = $this->db->makeRequest("SELECT * FROM DataUtil WHERE cle = :cle", ["cle" => $key]);

        return new Content($result[0]['id'], $result[0]['cle'], $result[0]['texte']);
    }

    public function updateContentByKey($key, $value)
    {
        $this->db->makeRequest("UPDATE DataUtil SET texte = :texte WHERE cle = :cle", ["texte" => $value, "cle" => $key]);
    }
}