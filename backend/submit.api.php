<?php

require_once __DIR__ . "/check.php";
require_once __DIR__ . "/question.class.php";
require_once __DIR__ . "/submission.class.php";

header("Access-Control-Allow-Origin:{$dom}");
header("access-control-allow-credentials:true");
header("Access-Control-Allow-Headers:access-control-allow-headers,access-control-allow-credentials,content-type");


$session = new SESSION;
$session->verify();
$user    = $session->user;

if (!$user) {
    sendApiError("User not logged in");
} else if ($user->endTime() < time()) {
    sendApiError("Submission time ended!");
} else if ($user->submitted == '1') {
    sendApiError("Final submission already done!");
}

$_POST = json_decode(file_get_contents('php://input'), true);


$question_id = (int) $_POST['ques_id'];

$question = new QUESTION;
$question->id = $question_id;
$question->fetch();

$options = $question->options();

$answer = (int) $_POST['answer'];

/*
switch ($_POST['answer']) {
    case "None of the above" :
        $answer = 0;
    break;
    case $options[0] :
        $answer = 1;
    break;
    case $options[1] :
        $answer = 2;
    break;
    case $options[2] :
        $answer = 3;
    break;
    case $options[3] :
        $answer = 4;
    break;
}*/

$submission = new SUBMISSION;
$submission->ques_id = $question_id;
$submission->user_id = $user->id;
$submission->answer  = $answer;

$submission->update();

sendApiSuccess();