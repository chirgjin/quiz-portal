<?php

require_once __DIR__ . "/check.php";
require_once __DIR__ . "/submission.class.php";



$session = new SESSION;
$session->verify();
$user    = $session->user;

if (!$user) {
    sendApiError("User not logged in");
} else if ($user->endTime() < time()) {
    sendApiError("Submission time ended!");
}

$question_id = (int) $_POST['ques_id'];


$submission = new SUBMISSION;
$submission->ques_id = $question_id;
$submission->user_id = $user->id;
$submission->answer  = (int) $_POST['answer'];

$submission->update();

sendApiSuccess();