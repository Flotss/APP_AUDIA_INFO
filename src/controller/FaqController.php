<?php

namespace App\Controller;

use App\Service\FaqService;

class FaqController extends AbstractController
{

    public function __construct()
    {
        parent::__construct("faq/user");

        $service = new FaqService();
        $questions = $service->getQuestions();
        $this->data["questions"] = $questions;
    }
}