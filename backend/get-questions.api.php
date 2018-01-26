<?php

require_once __DIR__ . "/check.php";
require_once __DIR__ . "/question.class.php";

$session = new SESSION;

if (!$session->verify()) {
    sendApiError("user not logged in");
}

$question_cls = new QUESTION;

$questions = array();

foreach ($question_cls->fetchAll() as $question) {
    $questions[] = array(
        "id" => $question->id,
        "question" => $question->question,
        "options"  => $question->options()
    );
}

die(
    json_encode($questions)
);