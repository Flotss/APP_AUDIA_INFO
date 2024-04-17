<?php

namespace App\Utils;

/**
 * The Cookies class provides methods for working with cookies in PHP.
 */
class Cookies
{
    /**
     * Sets a cookie with the specified name, value, and optional parameters.
     *
     * @param string $name The name of the cookie.
     * @param string $value The value of the cookie.
     * @param int $expire The expiration time of the cookie (default is 0).
     * @param string $path The path on the server where the cookie will be available (default is '/').
     * @param string $domain The domain that the cookie is available to (default is an empty string).
     * @param bool $secure Indicates if the cookie should only be transmitted over a secure HTTPS connection (default is false).
     * @param bool $httponly Indicates if the cookie should only be accessible through the HTTP protocol (default is false).
     */
    public static function set($name, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Retrieves the value of the cookie with the specified name.
     *
     * @param string $name The name of the cookie.
     * @return mixed|null The value of the cookie, or null if the cookie does not exist.
     */
    public static function get($name)
    {
        return $_COOKIE[$name] ?? null;
    }

    /**
     * Deletes the cookie with the specified name.
     *
     * @param string $name The name of the cookie.
     * @param string $path The path on the server where the cookie was set (default is '/').
     * @param string $domain The domain that the cookie was set for (default is an empty string).
     */
    public static function delete($name, $path = '/', $domain = '')
    {
        setcookie($name, '', time() - 3600, $path, $domain);
        unset($_COOKIE[$name]);
    }

    /**
     * Checks if a cookie with the specified name exists.
     *
     * @param string $name The name of the cookie.
     * @return bool True if the cookie exists, false otherwise.
     */
    public static function exists($name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Deletes all cookies.
     */
    public static function clear()
    {
        foreach ($_COOKIE as $name => $value) {
            self::delete($name);
        }
    }

    /**
     * Retrieves all cookies.
     *
     * @return array An associative array containing all cookies.
     */
    public static function COOKIE()
    {
        return $_COOKIE;
    }

    /**
     * Checks if a cookie with the specified name exists.
     *
     * @param string $name The name of the cookie.
     * @return bool True if the cookie exists, false otherwise.
     */
    public static function has($name)
    {
        return isset($_COOKIE[$name]);
    }
}