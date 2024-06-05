<?php

namespace App\Controller\Admin;

use App\Service\FaqService;
use InvalidArgumentException;

/**
 * The FaqAdminController class is responsible for handling requests related to the FAQ page.
 */
class FaqAdminController extends AbstractAdminController
{
    private FaqService $service;

    /**
     * Constructs a new instance of the FaqAdminController class.
     */
    public function __construct()
    {
        parent::__construct("faq/admin");

        // Initialize the service
        $this->service = new FaqService();

        // Handle POST request if it exists
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["typeActionFaq"])) {
            $this->handlePostRequest();
        }

        // Fetch questions from the service
        $this->data["questions"] = $this->service->getQuestions();
    }

    /**
     * Handle POST request based on the action type.
     */
    private function handlePostRequest(): void
    {
        $action = $_POST["typeActionFaq"];
        $question = $_POST["question"] ?? null;
        $answer = $_POST["answer"] ?? null;
        $id = $_POST["id"] ?? null;

        if ($action === "add") {
            // Check if question and answer are set
            if (!$question || !$answer) {
                throw new InvalidArgumentException("Question and answer must be provided for adding.");
            }
            $this->service->addQuestion($question, $answer);
        } else if ($action === "update") {
            // Check if id, question and answer are set
            if (!$id || !$question || !$answer) {
                throw new InvalidArgumentException("ID, question and answer must be provided for updating.");
            }
            $this->service->updateQuestion($id, $question, $answer);
        } else if ($action === "delete") {
            // Check if id is set
            if (!$id) {
                throw new InvalidArgumentException("ID must be provided for deleting.");
            }
            $this->service->deleteQuestion($id);
        } else {
            throw new InvalidArgumentException("Invalid action type.");
        }
    }
}