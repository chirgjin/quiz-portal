<?php

//settings.api.php


require_once __DIR__ . "/base.class.php";
require_once __DIR__ . "/settings.php";
require_once __DIR__ . "/user.class.php";
require_once __DIR__ . "/session.php";

$session = new SESSION;
$session->verify();

$user = $session->user;

if (!$user) {
    header("Location:" . $_POST['url']);
    die();
} else if(!$user->isSuperUser()) {
    header("Location:" . $_POST['url']);
    die();
}
