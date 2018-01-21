
<?php
//
// $host = "localhost";
// $username = "root";
// $password = "shreyans";
// $dbname = "quiz-portal";
// $dsn = "mysql:host=$host;dbname=$dbname";
//
// $pdo = new PDO($dsn, $username, $password);
// $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//
// $stmt = $pdo->query('SELECT * FROM users');
//
// if(!$stmt) {
//     // print_r($pdo->errorInfo());
// }
//
// while($row = $stmt->fetch()) {
//     // print_r($row);
// }
//
// $id = 1;
//
// $sql = "SELECT * FROM users WHERE id=?";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$id]);
// // echo $stmt->rowCount();
// $user = $stmt->fetchAll();

// var_dump($user);


class Verification
{
    // simple function to achieve connection to DB with pdo..
    private function connectToDB() {
        $host = "localhost";
        $username = "root";
        $password = "shreyans";
        $dbname = "quiz-portal";
        $dsn = "mysql:host=$host;dbname=$dbname";

        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $pdo;
    }

    private function verifyTeam($pdo, $teamName, $teamCode) {
        $sql = 'SELECT * FROM WHERE team_name = ? AND team_code = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$teamName, $teamCode]);
        echo $stmt->rowCount() . "<br>"; //test
        $participants = $stmt->fetchAll();
        var_dump($participants); //test
    }

    private function verifyLoneWolf($pdo, $email, $phone) {
        $sql = 'SELECT * FROM users WHERE email = :email AND phone = :phone';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email, 'phone' => $phone]);
        echo $stmt->rowCount(); //test
        $participant = $stmt->fetchAll();
        var_dump($participant); //test
    }

    /*
    *isTeam = used to check whether a team or a lone wolf
    *args = are the arguments sent by the user of verification with name specified
    */
    public function verify($isTeam, $args) {
        $pdo = $this->connectToDB();
        if($isTeam == false) {
            $this->verifyLoneWolf($pdo, $args['email'], $args['phone']);
        } else if($isTeam == true) {
            $this->verifyTeam($pdo, $args['team_name'], $args['team_code']);
        }
    }
}

if( sizeof($_GET) < 3 ) {
    @$result->error = true; //warning de rha hai bc ki unnamed variable pe operation.. later fix
    $result->description = 'Few arguments.. can\'t figure out shit';
    echo json_encode($result);
} else if( sizeof($_GET) > 3 ) {
    $result->error = true;
    $result->description = 'Too Many arguments.. can\'t figure out shit';
    echo json_encode($result);
} else {
    $verify = new Verification;
    $verify->verify($_GET['team'], $_GET);
}

?>
