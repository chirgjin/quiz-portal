<?php

require_once __DIR__ . "/check.php";

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
              <li id="set"><a href="#">Settings</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div id="users">
            <h2>Participants</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Submitted</th>
                        <th>Team Name</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $users = (new USER)->fetchAll();
                    ?>
                    <?php foreach($users as $user) { ?>
                        <tr>
                            <td><?php echo $user->rank ?></td>
                            <td><?php echo $user->id ?></td>
                            <td><?php echo $user->name ?></td>
                            <td><?php echo $user->email ?></td>
                            <td><?php echo $user->submitted ?></td>
                            <td><?php echo $user->team_name ?></td>
                            <td><?php echo $user->marks ?></td>
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
                        <th>User</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $submissions = (new SUBMISSION)->fetchAll();
                    ?>
                    <?php foreach($submissions as $submission) { ?>
                        <?php
                            $quest = new QUESTION;
                            $quest->id = $submission->ques_id;
                            $quest->fetch();

                            $u  = new USER;
                            $u->set("id" , $submission->user_id)->fetch();
                        ?>
                        <tr>
                            <td><?php echo $u->team_name ? "Team - " . $u->team_name : $u->name; ?></td>
                            <td><?php echo htmlentities($quest->question); ?></td>
                            <td><?php echo $submission->answer; ?></td>
                            <td><?php echo $submission->calculateMarks(); ?></td>
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
                        <th>#</th>
                        <th>Question</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                        <th>Option 3</th>
                        <th>Option 4</th>
                        <th>Correct</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $questions = (new QUESTION)->fetchAll();
                    ?>
                    <?php foreach($questions as $i=>$question) { ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo htmlentities($question->question); ?></td>
                            <td><?php echo $question->option1 ?></td>
                            <td><?php echo $question->option2 ?></td>
                            <td><?php echo $question->option3 ?></td>
                            <td><?php echo $question->option4 ?></td>
                            <td><?php echo $question->correct ?></td>
                            <td><button class="btn btn-default" data-id='<?php echo $question->id; ?>' data-for='delete-ques' >X</button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="questions.php"><button class="btn btn-success pull-right">Add Questions</button></a>
        </div>
        <div id="settings">
            <h2>Settings</h2>
            <form method="POST" action="settings.php">
                <div class="form-group">
                    <label>Event Name</label>
                    <input type="text" name="event_name" class="form-control" value="<?php echo setting_get("event_name"); ?>" >
                </div>
                <div class="form-group">
                    <label>Event Code</label>
                    <input type="text" name="event_code" class="form-control" value="<?php echo setting_get("event_code"); ?>" >
                </div>
                <div class="form-group">
                    <label>Starting Time</label>
                    <input type="datetime-local" name="start_time" class="form-control" value="<?php echo date("Y-m-d", setting_get("time_start")) . "T" . date("h:m", setting_get("time_start")); ?>">
                </div>
                <div class="form-group">
                    <label>Ending Time</label>
                    <input type="datetime-local" name="end_time" class="form-control" value="<?php echo date("Y-m-d", setting_get("time_end")) . "T" . date("h:m", setting_get("time_end")); ?>">
                </div>
                <div class="form-group">
                    <label>Number of Students to be qualified</label>
                    <input type="number" name="qualifier_number" class="form-control" value="<?php echo setting_get("qualifier_number"); ?>" >
                </div>
                <input type="hidden" name="url" value="panel.php">
                <button type="submit" class="btn btn-primary pull-right">Save</button>
            </form>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery.min.js" ></script>
<script src="js/panel.js"></script>
</html>
<script>
    $("[data-for='delete-ques']").click(function () {
        var id = $(this).data("id") , t = $(this);

        $.post("delete-question.php" , { id : id } , function (r) {
            t.parents("tr").remove();
        }).error(function () {
            alert("Error - Can't connect to server");
        });
    });
</script>
