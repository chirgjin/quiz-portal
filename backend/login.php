<?php
/**
 * Login Api
 * 
 * @category Login
 * @package  LOGINAPI
 */

require_once __DIR__ . "/check.php";

$session = new SESSION;
$verify = new USER;

header("Access-Control-Allow-Origin:{$dom}");
header("access-control-allow-credentials:true");
header("Access-Control-Allow-Headers:access-control-allow-headers,access-control-allow-credentials,content-type");

$_POST = json_decode(file_get_contents('php://input'), true);
if (!isset($_POST) || !isset($_POST['isTeam'])) {
    sendApiError("Invalid Method/Arguments");
} else if ($session->verify()) { //session already exists..
    sendApiError("User already logged in");
}

if ($_POST['isTeam'] == 'false') {
    $verify->email = $_POST['email'];
    $verify->phone = $_POST['phone'];
    if (!($verify->fetch() == null)) {
        // session start
        
        $session->start($verify);
        
        if ($verify->starting_time == null) {
            $verify->starting_time = time();
            $verify->update();
        }

        sendApiSuccess(
            array("starting_time" => $verify->starting_time , "ending_time" => $verify->endTime(),"current_time"=>time())
        );

    } else {
        sendApiError("Invalid Credentials");
    }
} else if ($_POST['isTeam'] == 'true') {
    $verify->team_name = $_POST['teamName'];
    $verify->team_code = $_POST['teamCode'];
    if (!($verify->fetch() == null)) {
        // session start

        $session->start($verify);

        if ($verify->starting_time == null) {
            $verify->starting_time = time();
            $verify->update();
        }

        sendApiSuccess(
            array("starting_time" => $verify->starting_time , "ending_time" => $verify->endTime(),"current_time"=>time())
        );
    } else {
        sendApiError("Invalid credentials");
    }
}
