<?php

require_once '../../backend/question.class.php';

$ques = new QUESTION;

$query = $_SERVER['QUERY_STRING'];
$vars = array(
    "question" => array(),
    "option1" => array(),
    "option2" => array(),
    "option3" => array(),
    "option4" => array(),
    "correct" => array()
);


foreach (explode('&', $query) as $pair) {
    list($key, $value) = explode('=', $pair);
    switch(urldecode($key)) {
        case 'question':
            $vars['question'][] = urldecode($value);
            break;
        case 'option1':
            $vars['option1'][] = urldecode($value);
            break;
        case 'option2':
            $vars['option2'][] = urldecode($value);
            break;
        case 'option3':
            $vars['option3'][] = urldecode($value);
            break;
        case 'option4':
            $vars['option4'][] = urldecode($value);
            break;
        case 'correct':
            $vars['correct'][] = urldecode($value);
            break;
    }
}

for($i = 0; $i < count($vars['question']); $i++) {
    $ques->question = $vars['question'][$i];
    $ques->option1 = $vars['option1'][$i];
    $ques->option2 = $vars['option1'][$i];
    $ques->option3 = $vars['option1'][$i];
    $ques->option4 = $vars['option1'][$i];
    $ques->correct = $vars['option1'][$i];
    $ques->insert();
}

header('Location: panel.php');

?>
