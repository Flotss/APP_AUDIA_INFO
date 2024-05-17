<?php

namespace App\Controller\ApiController;

use App\Entity\DataMonitoring;

class MonitoringApiController extends ApiAbstractController
{
    private $monitoring;

    public function __construct()
    {
        $this->monitoring = new DataMonitoring();
    }

    public function get()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            return ['error' => 'Invalid id'];
        }

        $id = $_GET['id'];

        echo json_encode($this->monitoring->getMonitoring($id), JSON_PRETTY_PRINT);
    }
}
