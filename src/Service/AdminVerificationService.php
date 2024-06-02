<?php

namespace App\Service;

use App\Utils\Cookies;

class AdminVerificationService
{
    private UserService $userService;

    /**
     * AdminVerificationService constructor.
     */
    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Checks if the current user is an admin.
     *
     * @return bool Returns true if the user is an admin, false otherwise.
     */
    public function isAdmin()
    {
        // Check if user is in cookie
        if (!Cookies::exists('user')) {
            return false;
        }

        // Get user from cookie
        $user = Cookies::get('user');
        if ($user === null) {
            return false;
        }
        // If user is in cookie, unserialize it
        $user = unserialize($user);

        // Get user from database to be sure
        $user = $this->userService->getUserByEmail($user->getEmail());

        // If user is not in database or is not an admin, return false
        if ($user === null || $user->getRole() !== 'ADMIN') {
            return false;
        }

        return true;
    }
}
