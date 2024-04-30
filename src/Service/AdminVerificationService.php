<?php

namespace App\Service;

use App\Database\DataBaseSingleton;
use App\Utils\Cookies;

class AdminVerificationService
{
    private $db;

    public function __construct()
    {
        $this->db = DataBaseSingleton::getInstance();
    }

    public function isAdmin()
    {
        // Get user from cookie
        $user = Cookies::get('user');
        $user = unserialize($user);


        // Get user from database to be sure
        $user = $this->db->getUserByEmail($user->getEmail());
        echo $user->toString();

        // Check if the user is an admin
        if ($user->getRole() !== 'ADMIN') {
            return false;
        }

        return true;
    }
}
