<?php

$host = '192.99.106.60';
$user = 'pokedawn_quiz';
$pass = 'quizportal242';
$dbname = 'pokedawn_quizportal';
$dsn = "mysql:host=$host;dbname=$dbname";

$pdo = new PDO($dsn, $user, $pass);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);