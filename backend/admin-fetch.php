<?php

require_once __DIR__ . "/user.class.php";
require_once __DIR__ . "/question.class.php";
require_once __DIR__ . "/submission.class.php";

$users = (new USER)->fetchAll();
$questions = (new QUESTION)->fetchAll();
$submission = (new SUBMISSION)->fetchAll();

print_r($users);
// var_dump($questions);
// var_dump($submission);
?>
