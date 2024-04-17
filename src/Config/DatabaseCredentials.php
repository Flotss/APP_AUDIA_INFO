<?php

namespace App\Config;

/**
 * Class DataBaseCredentials
 * Represents the credentials required to connect to a database.
 */
class DataBaseCredentials
{
    /**
     * @var string The host of the database.
     */
    private $host = 'localhost';

    /**
     * @var string The name of the database.
     */
    private $name = 'database_name';

    /**
     * @var int The port number of the database.
     */
    private $port = 3306;

    /**
     * @var string The username for the database connection.
     */
    private $user = 'database_user';

    /**
     * @var string The password for the database connection.
     */
    private $password = 'database_password';

    /**
     * DataBaseCredentials constructor.
     * @param string $host The host of the database.
     * @param string $name The name of the database.
     * @param int $port The port number of the database.
     * @param string $user The username for the database connection.
     * @param string $password The password for the database connection.
     */
    public function __construct($host, $name, $port, $user, $password)
    {
        $this->host = $host;
        $this->name = $name;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the host of the database.
     * @return string The host of the database.
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Get the name of the database.
     * @return string The name of the database.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the port number of the database.
     * @return int The port number of the database.
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Get the username for the database connection.
     * @return string The username for the database connection.
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the password for the database connection.
     * @return string The password for the database connection.
     */
    public function getPassword()
    {
        return $this->password;
    }
}