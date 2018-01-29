<?php

$donotcheck = 1;
require_once __DIR__ . '/check.php';


if ($user && $user->isSuperUser()) {
    die( header("Location:panel.php"));
}

if ( isset($_POST['action']) && $_POST['action'] == 'login') {
    $user = new USER;

    $user->email = $_POST['email'];
    $user->phone = $_POST['password'];

    if (!$user->fetch()) {
        $msg = "Incorrect Credentials";
    }
    else if( !$user->isSuperUser() ) {
        $msg = "You are not authorized!";
    }
    else {
        
        $session->start( $user->id );
        die( header("Location:panel.php") );
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" lang="en">
    <link href="css/normalize.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <title>Admin Panel</title>
</head>
<body>
    <div class="container">
        <div class="row" id="login">
            <h2 class="text-center mute">Login</h2>
            <?php
                if(isset($msg))
                    echo "<h2 class=\"text-cente mute\" >{$msg}</h2>";
            ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="email@email.com" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="password" class="form-control" required>
                    </div>
                    <input type='hidden' name='action' value='login' />
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
        </div>
    </div>
</body>
<script
src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</html>
