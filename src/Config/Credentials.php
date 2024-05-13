<?php

namespace App\Config;

class Credentials
{
    /**
     * The production database environment.
     *
     * @var string
     */
    public static $DB_PROD = 'prod';

    /**
     * The development database environment.
     *
     * @var string
     */
    public static $DB_DEV = 'dev';

    /**
     * The array to store the database credentials.
     *
     * @var array
     */
    private static $credentials = [];

    /**
     * Initializes the database credentials.
     *
     * @return void
     */
    public static function init()
    {
        self::$credentials[self::$DB_PROD] =
         new DataBaseCredentials('mysql-eventit-eventit.b.aivencloud.com', 'defaultdb', 15997, 'avnadmin', 'AVNS_k_qgtpArDleB03zYwm0');
        // self::$credentials[self::$DB_DEV] =
           // new DataBaseCredentials('mysql-4d9b6a3-eventit.b.aivencloud.com', 'defaultdb', 15997, 'avnadmin', 'AVNS_9GXsMZrg9tnGk2_opAu');
    }

    /**
     * Retrieves the database credentials for the specified environment.
     *
     * @param string $env The environment (prod or dev).
     * @return DataBaseCredentials|null The database credentials or null if not found.
     */
    public static function getCredentials($env)
    {
        return isset(self::$credentials[$env]) ? self::$credentials[$env] : null;
    }
}

Credentials::init();
