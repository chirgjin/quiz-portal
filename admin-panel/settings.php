<?php
require_once __DIR__ . "/check.php";

setting_set("event_name", $_POST['event_name']);
setting_set("event_code", $_POST['event_code']);
setting_set("time_start", strtotime( $_POST['start_time'] ));
setting_set("time_end"  , strtotime( $_POST['end_time'] ));
setting_set("qualifier_number", $_POST['qualifier_number']);

header("Location:panel.php");