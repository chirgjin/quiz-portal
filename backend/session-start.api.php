<?php

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/user.class.php";

$session = new SESSION;
$session->verify();
$user    = $session->user;

if (!$user) {
    sendApiError("User not logged in");
} else if ($user->starting_time != null) {
    sendApiError("Session already started");
} else {
    //var_dump($user);
    $user->starting_time = time(); //set starting time
    $user->update();
    if (!$user->error) {
        sendApiSuccess(
            array("starting_time" => $user->starting_time , "ending_time" => $user->endTime())
        );
    } else {
        sendApiError("Error updating user's data\n<br>" . $user->error->message);
    }
}