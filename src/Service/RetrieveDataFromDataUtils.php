<?php

namespace App\Service;

use App\Database\DataBaseSingleton;
use App\Entity\Content;

/**
 * Class RetrieveDataFromDataUtils
 * 
 * This class provides methods to retrieve and update content from the DataUtil table in the database.
 */
class RetrieveDataFromDataUtils
{

    private DataBaseSingleton $db;

    /**
     * RetrieveDataFromDataUtils constructor.
     * 
     * Initializes the database connection.
     */
    public function __construct()
    {
        $this->db = DataBaseSingleton::getInstance();
    }

    /**
     * Retrieves content from the database based on the provided key.
     * 
     * @param string $key The key to search for in the database.
     * @return Content The retrieved content.
     * @throws \Exception If no content is found for the provided key.
     */
    public function getContentByKey($key): Content
    {
        $result = $this->db->makeRequest("SELECT * FROM DataUtil WHERE cle = :cle", ["cle" => $key]);

        // If no content is found for the provided key, throw an exception
        if (empty($result)) {
            throw new \Exception("No content found for key $key");
        }

        return new Content($result[0]['id'], $result[0]['cle'], $result[0]['texte']);
    }

    /**
     * Updates the content in the database based on the provided key.
     * 
     * @param string $key The key to search for in the database.
     * @param string $value The new value to update the content with.
     */
    public function updateContentByKey($key, $value)
    {
        $this->db->makeRequest("UPDATE DataUtil SET texte = :texte WHERE cle = :cle", ["texte" => $value, "cle" => $key]);
    }
}