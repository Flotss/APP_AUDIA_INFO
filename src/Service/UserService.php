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
    private DataBaseSingleton $db;

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

    public function getUserById(int $id): ?User
    {
        $query = $this->db->getConnection()->prepare('SELECT * FROM User WHERE id = :id');
        $query->execute(['id' => $id]);
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


    /**
     * Save a user to the database.
     *
     * @param User $user The user to be saved.
     * @return void
     */
    public function saveUser(User $user): User
    {
        if ($user->getId() != 0) {
            $query = $this->db->getConnection()->prepare('UPDATE User SET username = :username, firstName = :firstName, lastName = :lastName, email = :email, location = :location, phone = :phone, password = :password, role = :role WHERE id = :id');
            $query->bindValue('id', $user->getId());
        } else {
            $query = $this->db->getConnection()->prepare('INSERT INTO User (username, firstName, lastName, email, location, phone, password, role) VALUES (:username, :firstName, :lastName, :email, :location, :phone, :password, :role)');
        }
        $query->execute([
            'username' => $user->getUsername(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'location' => $user->getLocation(),
            'phone' => $user->getPhone(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
        ]);

        if ($user->getId() == 0) {
            $user->setId($this->db->getConnection()->lastInsertId());
        }

        return $user;
    }

    /**
     * Get a user from the database by username.
     *
     * @param string $username The username of the user.
     * @return User|null The user object if found, null otherwise.
     */
    public function getUserByUsername(string $username): ?User
    {
        $query = $this->db->getConnection()->prepare('SELECT * FROM User WHERE username = :username');
        $query->execute(['username' => $username]);
        $userData = $query->fetch();

        if ($userData) {
            return User::createUserFromArray($userData);
        }

        return null;
    }

    /**
     * Get a user from the database by email.
     *
     * @param string $email The email of the user.
     * @return User|null The user object if found, null otherwise.
     */
    public function getUserByEmail(string $email): ?User
    {
        $query = $this->db->getConnection()->prepare('SELECT * FROM User WHERE email = :email');
        $query->execute(['email' => $email]);
        $userData = $query->fetch();

        if ($userData) {
            return User::createUserFromArray($userData);
        }

        return null;
    }

    /**
     * Get a user by their token.
     *
     * @param string $token The token of the user.
     * @return User|null The user object if found, null otherwise.
     */
    public function getUserByToken(string $token): ?User
    {
        $userData = $this->db->makeRequest('SELECT * FROM User WHERE token = :token', ['token' => $token]);

        if (!empty($userData)) {
            return User::createUserFromArray($userData[0]);
        }

        return null;
    }

    /**
     * Deletes a user from the database.
     *
     * @param int $id The ID of the user to delete.
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $this->db->makeRequest('DELETE FROM UserPreferences WHERE userId = :id', ['id' => $id]);
        $this->db->makeRequest('DELETE FROM User WHERE id = :id', ['id' => $id]);
    }
}
