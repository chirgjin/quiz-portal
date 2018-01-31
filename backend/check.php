<?php

require_once __DIR__ . "/base.class.php";
require_once __DIR__ . "/settings.php";
require_once __DIR__ . "/user.class.php";
require_once __DIR__ . "/session.php";

define("START_TIME" , (int)setting_get("time_start"));
define("END_TIME"   , (int)setting_get("time_end"));
define("EVENT_NAME" , (int)setting_get("event_name"));

$time = time();

if(isset($nocheck)) {

}
else if ($time < START_TIME)
    die("Submission time hasn't started yet.");
else if ($time > END_TIME)
    die("Submission time has ended.");


$dom = $_SERVER['HTTP_ORIGIN']; //"http://quiz-portal1.herokuapp.com";