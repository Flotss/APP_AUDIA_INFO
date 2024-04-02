<?php

namespace App\Controller;

use App\Entity\User;

class IndexController extends AbstractController
{

    public function __construct()
    {
        parent::__construct("template/index");
    }
}
