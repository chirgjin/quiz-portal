<?php

require_once __DIR__ . "/check.php";
require_once __DIR__ . "/question.class.php";
require_once __DIR__ . "/submission.class.php";

header("Access-Control-Allow-Origin:http://localhost:3000");
header("access-control-allow-credentials:true");
header("Access-Control-Allow-Headers:access-control-allow-headers,access-control-allow-credentials,content-type");
header("Content-Type:application/json");

$session = new SESSION;

if (!$session->verify()) {
    sendApiError("user not logged in");
}

$submission = new SUBMISSION;
$submission->user_id = $session->user->id;

$submissions = $submission->fetch();

$ids = array();

if ($submissions != null) {
    foreach($submissions as $submission)
        $ids[] = $submission->ques_id;
} else {
    for ($i=0;$i<20;$i++) {
        $question = new QUESTION;
        $question->loadRandom();

        if (!in_array($question->id, $ids)) {
            $ids[] = $question->id;
            $submission = new SUBMISSION;
            $submission->user_id = $session->user->id;
            $submission->ques_id = $question->id;
            $submission->answer  = 0;
            $submission->insert();
        }
        //else $i--;
    }
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