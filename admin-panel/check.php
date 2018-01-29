<?php

require_once __DIR__ . '/../backend/session.php';
require_once __DIR__ . '/../backend/user.class.php';
require_once __DIR__ . '/../backend/question.class.php';
require_once __DIR__ . '/../backend/submission.class.php';
require_once __DIR__ . '/../backend/settings.php';

$session = new SESSION;

$session->verify();

$user = $session->user;

if (!isset($donotcheck) && (!$user || !$user->isSuperUser())) {
    die(header("Location:index.php"));
}