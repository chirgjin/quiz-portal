<?php
require_once __DIR__ . "/check.php";

$id = $_POST['id'];

$question = new QUESTION;

$question->id = $id;

$question->delete();