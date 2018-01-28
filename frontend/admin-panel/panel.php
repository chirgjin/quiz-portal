<?php

require_once '../../backend/user.class.php';
require_once '../../backend/question.class.php';
require_once '../../backend/submission.class.php';

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
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
              <li id="p"><a href="#">Paricipants</a></li>
              <li id="s"><a href="#">Submissions</a></li>
              <li id="q"><a href="#">Questions</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div id="users">
            <h2>Participants</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Submitted</th>
                        <th>Team Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $users = (new USER)->fetchAll();
                    ?>
                    <?php foreach($users as $user) { ?>
                        <tr>
                            <td><?php echo $user->id ?></td>
                            <td><?php echo $user->name ?></td>
                            <td><?php echo $user->email ?></td>
                            <td><?php echo $user->submitted ?></td>
                            <td><?php echo $user->team_name ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div id="submissions">
            <h2>Submissions</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User Id</th>
                        <th>Question Id</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $submissions = (new SUBMISSION)->fetchAll();
                    ?>
                    <?php foreach($submissions as $submission) { ?>
                        <tr>
                            <td><?php echo $submission->user_id ?></td>
                            <td><?php echo $submission->question_id ?></td>
                            <td><?php echo $submission->answer ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div id="questions">
            <h2>Questions</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                        <th>Option 3</th>
                        <th>Option 4</th>
                        <th>Correct</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $questions = (new QUESTION)->fetchAll();
                    ?>
                    <?php foreach($questions as $question) { ?>
                        <tr>
                            <td><?php echo $question->question ?></td>
                            <td><?php echo $question->option1 ?></td>
                            <td><?php echo $question->option2 ?></td>
                            <td><?php echo $question->option3 ?></td>
                            <td><?php echo $question->option4 ?></td>
                            <td><?php echo $question->correct ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="questions.html"><button class="btn btn-success pull-right">Add Questions</button></a>
        </div>
    </div>
</body>
<script
src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
crossorigin="anonymous"></script>
<script src="js/questions.js"></script>
</html>
