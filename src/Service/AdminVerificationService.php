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
        if (!Cookies::exists('user')) {
            return false;
        }

        // Get user from cookie
        $user = Cookies::get('user');
        if ($user === null) {
            return false;
        }
        $user = unserialize($user);

        // Get user from database to be sure
        $user = $this->db->getUserByEmail($user->getEmail());

        if ($user === null || $user->getRole() !== 'ADMIN') {
            return false;
        }

        return true;
    }
}
