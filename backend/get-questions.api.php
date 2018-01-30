<?php

require_once __DIR__ . "/check.php";
require_once __DIR__ . "/question.class.php";
require_once __DIR__ . "/submission.class.php";

header("Access-Control-Allow-Origin:{$dom}");
header("access-control-allow-credentials:true");
header("Access-Control-Allow-Headers:access-control-allow-headers,access-control-allow-credentials,content-type");
header("Content-Type:application/json");

$session = new SESSION;

if (!$session->verify()) {
    sendApiError("user not logged in");
}


if ( $_SERVER['REQUEST_METHOD'] == "GET" ) {
    $submission = new SUBMISSION;
    $submission->user_id = $session->user->id;

    $submissions = $submission->fetch();

    $ids = array();

    if ($submissions != null) {
        if(!is_array($submissions))
            $submissions = array($submissions);
        
        foreach($submissions as $submission)
            $ids[] = $submission->ques_id;
    } else {
        /*
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
        }*/

        $question_amt = setting_get("no_of_questions");

        foreach ((new QUESTION)->loadRandom($question_amt) as $question) {
            $submission = new SUBMISSION;
            $submission->user_id = $session->user->id;
            $submission->ques_id = $question->id;
            $submission->answer  = 0;
            $submission->insert();
            $ids[] = $question->id;
        }
    }

    $question_cls = new QUESTION;

    $questions = array();

    foreach ($ids as $id) {
        $question = (new QUESTION)->set("id" , $id)->fetch();

        $questions[] = array(
            "id" => $question->id,
            "question" => $question->question,
            "options"  => $question->options()
        );
    }

    die(
        sendApiSuccess( array("data" => $questions) )
    );

} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user = $session->user;

    if ($user->endTime() < time()) {
        sendApiError("Submission time ended!");
    } else if ($user->submitted == '1') {
        sendApiError("Final submission already done!");
    }
    
    $_POST = json_decode(file_get_contents('php://input'), true);

    $submissions = json_decode($_POST['data']);

    foreach ($submissions as $submission) {
        $sub_cls = new SUBMISSION;
        $sub_cls->ques_id = $submission->ques_id;
        $sub_cls->answer  = $submission->answer;
        $sub_cls->user_id = $session->user->id;

        $sub_cls->update();
    }

    $user->set("submitted", 1)->update();

    sendApiSuccess($user);
}
else
    sendApiError("Invalid Method");