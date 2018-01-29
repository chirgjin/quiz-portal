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
    <title>Add Questions</title>
</head>
<body>
    <div class="container">
        <h1>Add Questions</h1>
            <div id="q">
                <form method="POST" action="idk.php">
                    <div class="form-group">
                        <label>Question 1</label>
                        <textarea class="form-control" name="question[]" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Option 1</label>
                        <input type="text" name="option1[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Option 2</label>
                        <input type="text" name="option2[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Option 3</label>
                        <input type="text" name="option3[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Option 4</label>
                        <input type="text" name="option4[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Correct Option</label>
                        <input type="number" name="correct[]" class="form-control" required>
                    </div>
                    <hr id="line">
                    <button id="sub" type="submit" class="btn btn-success pull-right">Submit</button>
                </form>
                <button id="add" class="btn btn-primary">Add a Question</button>
            </div>
        </div>
    </div>
</body>
<script
src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
crossorigin="anonymous"></script>
<script src="js/questions.js"></script>
</html>
