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
		$questions = $this->db->makeRequest("SELECT * FROM faq");
		return $questions;
	}

	public function getQuestionById($id)
	{
		$question = $this->db->makeRequest("SELECT * FROM faq WHERE id = ?", [$id]);
		return $question;
	}


	public function addQuestion($question, $answer)
	{
		$this->db->makeRequest(
			"INSERT INTO faq (question, answer) VALUES (?, ?)",
			[$question, $answer]
		);
	}

	public function updateQuestion($id, $question, $answer)
	{
		$this->db->makeRequest(
			"UPDATE faq SET question = ?, answer = ? WHERE id = ?",
			[$question, $answer, $id]
		);
	}


	public function deleteQuestion($id)
	{
		$this->db->makeRequest("DELETE FROM faq WHERE id = ?", [$id]);
	}
}