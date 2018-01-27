<?php

require_once __DIR__ . "/check.php";
require_once __DIR__ . "/submission.class.php";

$qid = $_POST['ques_id'];


$session = new SESSION;
$session->verify();
$user    = $session->user;

if (!$user) {
    sendApiError("User not logged in");
}