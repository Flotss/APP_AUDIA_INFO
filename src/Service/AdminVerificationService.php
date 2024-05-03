<?php

namespace App\Service;

use App\Database\DataBaseSingleton;
use App\Utils\Cookies;
use App\Entity\User;

class AdminVerificationService
{
    private $db;

    public function __construct()
    {
        $this->db = DataBaseSingleton::getInstance();
    }

    public function isAdmin()
    {
        $user = new User(1, 'admin', 'admin@gmail.com', 'admin', 'admin', 'admin', 'admin', 'admin', 'ADMIN');
        Cookies::set('user', serialize($user));
        // Get user from cookie
        $user = Cookies::get('user');
        if ($user === null) {
            return false;
        }
        $user = unserialize($user);

        // Get user from database to be sure
        $user = $this->db->getUserByEmail($user->getEmail());

        // Check if the user is an admin
        if ($user->getRole() !== 'ADMIN') {
            return false;
        }

        return true;
    }
}