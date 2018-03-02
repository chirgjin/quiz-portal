<?php
/**
 * End Time Api
 * 
 * @category Api
 * @package  ENDTIMEAPI
 */

 $nocheck = 1;
require_once __DIR__ . "/check.php";

$session = new SESSION;
$verify = new USER;

header("Access-Control-Allow-Origin:{$dom}");
header("access-control-allow-credentials:true");
header("Access-Control-Allow-Headers:access-control-allow-headers,access-control-allow-credentials,content-type");

sendApiSuccess(
    array(
        "end_time" => (int) setting_get("time_end"),
        "start_time" => (int) setting_get("time_start"),
        "current_time"=>time()
    )
);