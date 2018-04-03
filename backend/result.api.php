<?php

$nocheck = 1;
require_once __DIR__ . "/check.php";
header("Access-Control-Allow-Origin:{$dom}");
header("access-control-allow-credentials:true");
header("Access-Control-Allow-Headers:access-control-allow-headers,access-control-allow-credentials,content-type");

$user = new USER;

$sql = "SELECT * FROM `" . $user->table() . "` ORDER BY `rank` ASC";
$data = array();

$stmt = $user->query($sql, $data);

$data = array();

$threshold = (int) setting_get("qualifier_number");

foreach ($stmt->fetchAll() as $user) {
    $data[] = array(
        "name" => $user['name'],
        "team" => $user['team_name'] ? $user['team_name'] : "-",
        "rank" => $user['rank'],
        "qualified" => (int)$user['rank'] <= $threshold
    );
}

sendApiSuccess(array("data"=>$data));