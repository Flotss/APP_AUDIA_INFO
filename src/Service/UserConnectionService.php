<?php

namespace App\Service;

use App\Database\DataBaseSingleton;
use App\Entity\User;
use App\Utils\Security;
use App\Utils\Cookies;

/**
 * Class UserConnectionService
 * 
 * This class provides methods for user authentication and registration.
 */
class UserConnectionService
{
    private DataBaseSingleton $db;

    /**
     * UserConnectionService constructor.
     * 
     * @param DataBaseSingleton $db The database singleton instance.
     */
    public function __construct()
    {
        $this->db = DataBaseSingleton::getInstance();
    }

    /**
     * Creates a new user from cookie data.
     * 
     * @return User The created user object.
     */
    public function createUserFromCookie(): ?User
    {
        return Cookies::get('user') ?? null;
    }

    /**
     * Logs in a user with the provided email and password.
     * 
     * @param string $email The user's email.
     * @param string $password The user's password.
     * 
     * @return bool True if the login is successful, false otherwise.
     */
    public function loginUser($email, $password): bool
    {
        // Check if the user exists in the database
        $user = $this->db->getUserByEmail($email);

        if ($user && Security::verifyPassword($password, $user->getPassword())) {
            // Save the user to a cookie
            $user = serialize($user);
            Cookies::set('user', $user);
            return true;
        }

        // Delete the user cookie if the login is unsuccessful
        Cookies::delete('user');

        return false;
    }

    /**
     * Registers a new user with the provided username, email, and password.
     * 
     * @param string $username The user's username.
     * @param string $email The user's email.
     * @param string $password The user's password.
     * 
     * @return User The registered user object.
     */
    public function registerUser($username, $email, $password, $firstName, $lastName): bool
    {
        // Create a new User object
        $user = new User(0, $username, $email, $password, $firstName, $lastName);

        // Set the user's password
        $user->setPasswordHashed($password);

        // Save the user to the database
        $user = $this->db->saveUser($user);

        // Save the user to a cookie
        $user = serialize($user);
        Cookies::set('user', $user);

        return true;
    }
}
