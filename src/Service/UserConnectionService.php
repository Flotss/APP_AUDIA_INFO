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
    private UserService $userService;
    private DataBaseSingleton $db;

    /**
     * UserConnectionService constructor.
     * 
     * @param DataBaseSingleton $db The database singleton instance.
     */
    public function __construct()
    {
        $this->userService = new UserService();
        $this->db = DataBaseSingleton::getInstance();
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
        $user = $this->userService->getUserByEmail($email);

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
     * @param string $firstName The user's first name.
     * @param string $lastName The user's last name.
     * 
     * @return bool True if the registration is successful, false otherwise.
     */
    public function registerUser($username, $email, $password, $firstName, $lastName): bool
    {
        // Create a new User object
        $user = new User(0, $username, $email, $password, $firstName, $lastName);

        // Set the user's password
        $user->setPasswordHashed($password);

        // Save the user to the database
        $user = $this->userService->saveUser($user);

        // Save the user to a cookie
        $user = serialize($user);
        Cookies::set('user', $user);

        return true;
    }

    /**
     * Stores the authentication token for a user.
     * 
     * @param User $user The user object.
     * @param string $token The authentication token.
     * 
     * @return void
     */
    public function storeUserToken(User $user, string $token)
    {
        $this->db->makeRequest("UPDATE User SET token = :token WHERE id = :id", [
            'token' => $token,
            'id' => $user->getId()
        ]);
    }

    /**
     * Updates the password for a user.
     * 
     * @param User $user The user object.
     * @param string $password The new password.
     * 
     * @return void
     */
    public function updateUserPassword(User $user, string $password)
    {
        $this->db->makeRequest("UPDATE User SET password = :password WHERE id = :id", [
            'password' => $password,
            'id' => $user->getId()
        ]);

        $this->db->makeRequest("UPDATE User SET token = NULL WHERE id = :id", [
            'id' => $user->getId()
        ]);
    }
}
