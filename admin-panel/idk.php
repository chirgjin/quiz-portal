<?php

require_once __DIR__ . "/check.php";


$ques = new QUESTION;


$vars = $_POST;

for ($i = 0; $i < count($vars['question']); $i++) {
    $ques->question = $vars['question'][$i];
    $ques->option1 = $vars['option1'][$i];
    $ques->option2 = $vars['option2'][$i];
    $ques->option3 = $vars['option3'][$i];
    $ques->option4 = $vars['option4'][$i];
    $ques->correct = $vars['correct'][$i];
    $ques->insert();
}

header('Location: panel.php');

die();