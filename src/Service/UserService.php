<?php

namespace App\Service;

use App\Entity\User;
use App\Database\DataBaseSingleton;
use App\Utils\Cookies;

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

    public function getAllUser(): array
    {
        $query = $this->db->getConnection()->prepare('SELECT * FROM User');
        $query->execute();
        $users = $query->fetchAll();
        return $users;
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

    public function getImage(string $email): ?string
    {
        $query = $this->db->getConnection()->prepare('SELECT image FROM User WHERE email = :email');
        $query->execute(['email' => $email]);
        $image = $query->fetchColumn();
        return $image;
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

    public function updateUser(User $user): void
    {
        $query = $this->db->getConnection()->prepare('UPDATE User SET username = :username, email = :email, password = :password, firstName = :firstName, lastName = :lastName, location = :location, phone = :phone, role = :role, image = :image WHERE id = :id');
        $query->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'location' => $user->getLocation(),
            'phone' => $user->getPhone(),
            'role' => $user->getRole(),
            'image' => $user->getImage(),
            'id' => $user->getId()
        ]);

        Cookies::set('user', serialize($user));
    }

    public function updatePreferenceTemperature(User $user, string $preferenceTemperature): void
    {
        $query = $this->db->getConnection()->prepare('UPDATE UserPreferences up
        SET temperatureTypeId = (SELECT id FROM temperatureType WHERE name = :name)
        WHERE userId = :userId');
        $query->execute(['name' => $preferenceTemperature, 'userId' => $user->getId()]);
    }

    public function updatePreferenceSon(User $user, string $preferenceSon): void
    {
        $query = $this->db->getConnection()->prepare('UPDATE UserPreferences up
        SET acousticsTypeId = (SELECT id FROM acousticsType WHERE name = :name)
        WHERE userId = :userId');
        $query->execute(['name' => $preferenceSon, 'userId' => $user->getId()]);
    }
}
