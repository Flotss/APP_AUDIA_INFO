<?php

namespace App\Service;

use App\Database\DataBaseSingleton;

class FaqService
{
	private DataBaseSingleton $db;

	public function __construct()
	{
		$this->db = DataBaseSingleton::getInstance();
	}

	public function getQuestions()
	{
		$questions = $this->db->makeRequest("SELECT * FROM FAQ");
		return $questions;
	}

	public function getQuestionById($id)
	{
		$question = $this->db->makeRequest("SELECT * FROM FAQ WHERE id = ?", [$id]);
		return $question;
	}


	public function addQuestion($question, $answer)
	{
		$this->db->makeRequest(
			"INSERT INTO FAQ (question, answer) VALUES (?, ?)",
			[$question, $answer]
		);
	}

	public function updateQuestion($id, $question, $answer)
	{
		$this->db->makeRequest(
			"UPDATE FAQ SET question = ?, answer = ? WHERE id = ?",
			[$question, $answer, $id]
		);
	}


	public function deleteQuestion($id)
	{
		$this->db->makeRequest("DELETE FROM FAQ WHERE id = ?", [$id]);
	}
}