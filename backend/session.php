<?php
    require __DIR__ . '/user.class.php';
    require_once __DIR__ . '/dbconfig.php';

    $user = new USER;

    $user->id = $_SESSION['id'];

    print_r($user->fetch());

    if(isset($_SESSION)) {
        session_destroy();
    }

?>
