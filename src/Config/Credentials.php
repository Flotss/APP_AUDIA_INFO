<?php

namespace App\Config;

class Credentials
{
    const DB_PROD = 'prod';
    const DB_DEV = 'dev';

    private static $credentials = [];

    public static function init()
    {
        self::$credentials[self::DB_PROD] =
            new DataBaseCredentials('mysql-eventit-eventit.b.aivencloud.com', 'defaultdb', 15997, 'avnadmin', 'AVNS_k_qgtpArDleB03zYwm0');
        self::$credentials[self::DB_DEV] =
            new DataBaseCredentials('mysql-4d9b6a3-eventit.b.aivencloud.com', 'defaultdb', 15997, 'avnadmin', 'AVNS_9GXsMZrg9tnGk2_opAu');
    }

    public static function getCredentials($env)
    {
        return isset(self::$credentials[$env]) ? self::$credentials[$env] : null;
    }
}

Credentials::init();
