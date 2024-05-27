<?php

namespace App\Service;

use App\Entity\User;
use App\Database\DataBaseSingleton;

/**
 * The UserService class provides methods to manage users.
 */
class UserService
{
    /**
     * The database connection.
     *
     * @var DataBaseSingleton
     */
    private $db;

    /**
     * Constructs a new UserService instance.
     */
    public function __construct()
    {
        $this->db = DataBaseSingleton::getInstance();
    }

    public function getUser(string $email): ?User
    {
        $query = $this->db->getConnection()->prepare('SELECT * FROM User WHERE email = :email');
        $query->execute(['email' => $email]);
        $userData = $query->fetch();

        if (!$userData) {
            return null;
        }

        $user = User::createUserFromArray($userData);
        return $user;
    }

    public function getPreferenceTemperature(string $email): ?string
    {
        $query = $this->db->getConnection()->prepare('SELECT name FROM User u 
        inner join UserPreferences up on u.id = up.userId
        inner join temperatureType tt on up.temperatureTypeId = tt.id
        WHERE email = :email');
        $query->execute(['email' => $email]);
        $preferenceTemperature = $query->fetchColumn();
        return $preferenceTemperature;
    }

    public function getPreferenceSon(string $email): ?string
    {
        $query = $this->db->getConnection()->prepare('SELECT name FROM User u
        inner join UserPreferences up on u.id = up.userId
        inner join acousticsType at on up.acousticsTypeId = at.id
        WHERE email = :email');
        $query->execute(['email' => $email]);
        $preferenceSon = $query->fetchColumn();
        return $preferenceSon;
    }
}