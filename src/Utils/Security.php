<?php

namespace App\Utils;

class Security
{
    /**
     * Hashes a password using the ARGON2ID algorithm.
     *
     * @param string $password The password to hash.
     * @return string The hashed password.
     */
    public static function hashPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
        return $hashedPassword;
    }

    /**
     * Verifies if a password matches a hashed password.
     *
     * @param string $password The password to verify.
     * @param string $hashedPassword The hashed password to compare against.
     * @return bool True if the password is correct, false otherwise.
     */
    public static function verifyPassword($password, $hashedPassword)
    {
        $isPasswordCorrect = password_verify($password, $hashedPassword);
        return $isPasswordCorrect;
    }

    /**
     * Generates a random token.
     *
     * @return string The generated token.
     */
    public static function generateToken()
    {
        $token = bin2hex(random_bytes(32));
        return $token;
    }

    /**
     * Sanitizes user input by converting special characters to HTML entities.
     *
     * @param string $input The input to sanitize.
     * @return string The sanitized input.
     */
    public static function sanitizeInput($input)
    {
        $sanitizedInput = htmlspecialchars($input);
        return $sanitizedInput;
    }

    /**
     * Validates if an email address is valid.
     *
     * @param string $email The email address to validate.
     * @return bool True if the email is valid, false otherwise.
     */
    public static function validateEmail($email)
    {
        $isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $isEmailValid;
    }

    /**
     * Validates if a password meets the minimum requirements.
     *
     * @param string $password The password to validate.
     * @return bool True if the password is valid, false otherwise.
     */
    public static function validatePassword($password)
    {
        $isPasswordValid = strlen($password) >= 8;
        return $isPasswordValid;
    }

    /**
     * Validates if a username meets the minimum requirements.
     *
     * @param string $username The username to validate.
     * @return bool True if the username is valid, false otherwise.
     */
    public static function validateUsername($username)
    {
        $isUsernameValid = preg_match('/^[a-zA-Z0-9]{5,}$/', $username);
        return $isUsernameValid;
    }
}