<?php

namespace App\Controller;

use App\Service\FaqService;

/**
 * The FaqController class is responsible for handling requests related to FAQs.
 */
class FaqController extends AbstractController
{

    /**
     * Constructs a new FaqController object.
     * Initializes the parent class and retrieves the list of questions from the FaqService.
     */
    public function __construct()
    {
        parent::__construct("faq/user");

        // Retrieve the list of questions from the FaqService
        $service = new FaqService();
        $questions = $service->getQuestions();
        $this->data["questions"] = $questions;
    }
}
