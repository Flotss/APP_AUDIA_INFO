<?php

namespace App\Database;

use App\Config\Credentials;
use App\Entity\User;
use PDO;

/**
 * The DataBaseSingleton class represents a singleton database connection.
 */
class DataBaseSingleton
{
    private static ?DataBaseSingleton $instance = null;
    public PDO $connection;

    /**
     * Private constructor to prevent creating multiple instances of the class.
     */
    private function __construct()
    {
        $credentials = Credentials::getCredentials(Credentials::$DB_PROD);

        $this->connection = new PDO(
            'mysql:host=' . $credentials->getHost() . ';port=' . $credentials->getPort() . ';dbname=' . $credentials->getName(),
            $credentials->getUser(),
            $credentials->getPassword()
        );
    }

    /**
     * Get the instance of the DataBaseSingleton class.
     *
     * @return DataBaseSingleton The instance of the DataBaseSingleton class.
     */
    public static function getInstance(): DataBaseSingleton
    {
        if (self::$instance === null) {
            self::$instance = new DataBaseSingleton();
        }
        return self::$instance;
    }

    /**
     * Get the database connection.
     *
     * @return PDO The database connection.
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Make a database query and return the result as an array.
     *
     * @param string $query The SQL query.
     * @param array $params The parameters for the query.
     * @return array The result of the query as an array.
     */
    public function makeRequest($query, $params = []): array
    {
        $query = $this->connection->prepare($query);
        $query->execute($params);
        return $query->fetchAll();
    }
}
