<?php

namespace App\Config;

class DataBaseCredentials
{
    private $host = 'localhost';
    private $name = 'database_name';
    private $port = 3306;
    private $user = 'database_user';
    private $password = 'database_password';

    public function __construct($host, $name, $port, $user, $password)
    {
        $this->host = $host;
        $this->name = $name;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
