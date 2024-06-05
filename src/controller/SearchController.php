<?php

namespace App\Controller;

use App\Service\RetrieveDataFromDataUtils;

class SearchController extends AbstractController
{
    public $searchArray = [
        [
            "name" => "Accueil",
            "description" => "Page d'accueil'",
            "url" => "/"
        ],
        [
            "name" => "Monitoring",
            "url" => "/monitoring"
        ],
        [
            "name" => "Contact",
            "url" => "/contact"
        ],
        [
            "name" => "FAQ",
            "url" => "/faq"
        ],
        [
            "name" => "Connexion",
            "url" => "/connexion"
        ],
        [
            "name" => "CGU",
            "url" => "/cgu"
        ],
        [
            "name" => "Mentions légales",
            "url" => "/mentionslegales"
        ],
        [
            "name" => "Déconnexion",
            "url" => "/deconnexion"
        ],
        [
            "name" => "FAQ Admin",
            "url" => "/admin/faq"
        ],
        [
            "name" => "CGU Admin",
            "url" => "/admin/cgu"
        ],
    ];
    public function __construct()
    {
        parent::__construct("search");

        $this->handleRequest();
    }


    public function handleRequest()
    {
        if (isset($_GET['query'])) {
            $query = $_GET['query'];

            $this->data['filteredArray'] =
                array_filter($this->searchArray, function ($item) use ($query) {
                    // FOR EACH ATTRIBUTE OF THE ITEM
                    foreach ($item as $key => $value) {
                        // IF THE VALUE IS A STRING
                        if (is_string($value)) {
                            // IF THE VALUE MATCHES THE QUERY
                            if (preg_match("/.*$query.*/", $value)) {
                                return true;
                            }
                        }
                    }
                });
        }
    }
}
