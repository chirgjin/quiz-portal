<?php
/**
 * get questions data from post and add to db
 */

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/question.class.php";
require_once __DIR__ . "/user.class.php";

$session = new SESSION;

if (!$session->verify()) {
    die(
        json_encode(
            array("success"=>false,"message"=>"User not logged in")
        )
    );
} else if (!$session->user()->isSuperUser()) {
    die(
        json_encode(
            array("success"=>false,"message"=>"User not authorized")
        )
    );
}

$question_obj = json_decode( urldecode($_GET['question']) );

var_dump($question_obj);

$number = $question_obj->no_of_questions;

$responses = array();

for ($i=1;$i<=$number;$i++) {
    $qnum = "question" . $i;
    $question = $question_obj->$qnum;

    $question_cls = new QUESTION;

    $question_cls
        ->set("question" , $question->question)
        ->set("option1"  , $question->option1)
        ->set("option2"  , $question->option2)
        ->set("option3"  , $question->option3)
        ->set("option4"  , $question->option4)
        ->set("correct"  , $question->correct);
    
    if($question_cls->insert())
        $responses[] = array("success"=>true,"index"=>$i,"question" => $question->question);
}

header("Content-Type:application/json");

die(
    json_encode($responses)
);