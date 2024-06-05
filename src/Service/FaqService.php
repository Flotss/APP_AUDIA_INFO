<?php

namespace App\Service;

use App\Database\DataBaseSingleton;

class FaqService
{
	private DataBaseSingleton $db;

	/**
	 * FaqService constructor.
	 */
	public function __construct()
	{
		$this->db = DataBaseSingleton::getInstance();
	}

	/**
	 * Get all questions from the FAQ table.
	 *
	 * @return array The array of questions.
	 */
	public function getQuestions()
	{
		$questions = $this->db->makeRequest("SELECT * FROM FAQ");
		return $questions;
	}

	/**
	 * Get a question by its ID from the FAQ table.
	 *
	 * @param int $id The ID of the question.
	 * @return array|null The question if found, null otherwise.
	 */
	public function getQuestionById($id)
	{
		$question = $this->db->makeRequest("SELECT * FROM FAQ WHERE id = ?", [$id]);
		return $question;
	}

	/**
	 * Add a new question to the FAQ table.
	 *
	 * @param string $question The question to add.
	 * @param string $answer The answer to the question.
	 * @return void
	 */
	public function addQuestion($question, $answer)
	{
		$this->db->makeRequest(
			"INSERT INTO FAQ (question, answer) VALUES (?, ?)",
			[$question, $answer]
		);
	}

	/**
	 * Update a question in the FAQ table.
	 *
	 * @param int $id The ID of the question to update.
	 * @param string $question The updated question.
	 * @param string $answer The updated answer.
	 * @return void
	 */
	public function updateQuestion($id, $question, $answer)
	{
		$this->db->makeRequest(
			"UPDATE FAQ SET question = ?, answer = ? WHERE id = ?",
			[$question, $answer, $id]
		);
	}

	/**
	 * Delete a question from the FAQ table.
	 *
	 * @param int $id The ID of the question to delete.
	 * @return void
	 */
	public function deleteQuestion($id)
	{
		$this->db->makeRequest("DELETE FROM FAQ WHERE id = ?", [$id]);
	}
}