<?php

namespace App\Exceptions;

use Exception;

/**
 * The PasswordSecurityException class is responsible for handling exceptions related to password security.
 */
class PasswordSecurityException extends Exception
{
    /**
     * Constructs a new instance of the PasswordSecurityException class.
     * @param string $message The message of the exception.
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
