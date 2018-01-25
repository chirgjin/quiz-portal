<?php
/**
 * get questions data from post and add to db
 */

require_once __DIR__ . "/session.php";


$question_obj = json_decode($_POST['question']);