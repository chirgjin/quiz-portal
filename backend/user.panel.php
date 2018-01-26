<?php

require_once __DIR__ . "/session.php";
require_once __DIR__ . "/user.class.php";

$session = new SESSION;

if (!$session->verify()) {
    sendApiError("user not logged in");
}

$user = $session->user();

if (!$user->isSuperUser()) {
    sendApiError("You don't have permission to view this page");
}

$users = $user->fetchAll();


?>
<html>
    <head>
        <title>Users</title>
        <link rel='stylesheet' href='//bootswatch.com/3/superhero/bootstrap.min.css' />
    </head>
    <body class='container' >

        <table class='table table-striped table-bordered' >
            <tr>
                <th>Name
                <th>Email
                <th>Phone
                <th>Team
                <th>Submitted
                <th>Marks
            </tr>
            <?php
            foreach ($users as $user) {
                $user->team_name = $user->team_name ? $user->team_name : " - ";
                $user->marks     = $user->marks ? $user->marks : " - ";
                $user->submitted = $user->submitted ? "checked" : "";

                echo "<tr><td>{$user->name}<td>{$user->email}<td>{$user->phone}<td>{$user->team_name}<td><input type='checkbox' {$user->submitted} /><td>{$user->marks}</tr>";
            }
            ?>
        </table>

    </body>
</html>