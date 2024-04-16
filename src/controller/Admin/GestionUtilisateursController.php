<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;

class GestionUtilisateursController extends AbstractController
{

    public function __construct()
    {
        parent::__construct("admin/gestion_utilisateurs");
    }
}
