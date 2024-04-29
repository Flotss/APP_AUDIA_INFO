<?php

namespace App\Controller;

class FaqController extends AbstractController
{

    public function __construct()
    {
        parent::__construct("faq/user");

        $questions = [];
        $questions[0] = ["question" => "What is the purpose of this website?", "answer" => "This website is a platform for students to share their notes and study materials with each other.This website is a platform for students to share their notes and study materials with each other.This website is a platform for students to share their notes and study materials with each other.This website is a platform for students to share their notes and study materials with each other.This website is a platform for students to share their notes and study materials with each other."];
        $questions[1] = ["question" => "How can I upload my notes?", "answer" => "You can upload your notes by clicking on the 'Upload' button on the top right corner of the website."];
        $questions[2] = ["question" => "How can I download notes?", "answer" => "You can download notes by clicking on the 'Download' button on the notes you want to download."];

        $this->data["questions"] = $questions;
    }
}