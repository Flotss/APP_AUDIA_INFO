<?php

namespace App\Service;

use App\Entity\User;
use App\Utils\Cookies;

/**
 * The CookieService class provides methods for setting and retrieving user cookies.
 */
class CookieService
{
    /**
     * Sets the user cookie.
     *
     * @param User $user The user object to be stored in the cookie.
     * @return void
     */
    public static function setUserCookie(User $user)
    {
        // Store the user object in the cookie for 7 days
        Cookies::set('user', $user, time() + 60 * 60 * 24 * 7);
    }

    /**
     * Retrieves the user object from the cookie.
     *
     * @return User|null The user object retrieved from the cookie, or null if the cookie is not set.
     */
    public static function getUserFromCookie()
    {
        return $_COOKIE['user'] ?? null;
    }
}
