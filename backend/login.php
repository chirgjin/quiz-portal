<?php
/**
 * Login Api
 * 
 * @category Login
 * @package  LOGINAPI
 * @author   Shreyans <shreyans@gmail.com>
 */
require_once __DIR__ . "/user.class.php";
require_once __DIR__ . "/session.php";

/*
class Verification
{
    // simple function to achieve connection to DB with pdo..
    private function connectToDB() {
        require  __DIR__ . '/dbconfig.php';
        return $pdo;
    }

    private function vTeam($pdo, $teamName, $teamCode) {
        $sql = "SELECT * FROM users WHERE team_name = ? AND team_code = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$teamName, $teamCode]);
        if($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }

    public function verifyTeam($teamName, $teamCode) {
        $pdo = $this->connectToDB();
        return $this->vTeam($pdo, $teamName, $teamCode);
    }

    private function vLone($pdo, $email, $phone) {
        $sql = 'SELECT * FROM users WHERE email = :email AND phone = :phone';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email, 'phone' => $phone]);
        if($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }

    public function verifyLoneWolf($email, $phone) {
        $pdo = $this->connectToDB();
        return $this->vLone($pdo, $email, $phone);
    }

}
*/

$session = new SESSION;
$verify = new USER;

header("Content-Type:application/json");

if (!isset($_POST) || !isset($_POST['isTeam'])) {
    die(
        json_encode(
            array(
                "success"=>false,
                "message"=>"Invalid Method"
            )
        )
    );
} else if ($session->verify()) { //session already exists..
    die(
        json_encode(
            array(
                "success"=>false,
                "message"=>"User already logged in"
            )
        )
    );
}

if ($_POST['isTeam'] == 'false') {
    $verify->email = $_POST['email'];
    $verify->phone = $_POST['phone'];
    if (!($verify->fetch() == null)) {
        // session start
        
        $session->start($verify);
        
        die(
            json_encode(
                array(
                    'success'       => true,
                    'starting_time' => $verify->get("starting_time"),
                    'ending_time'   => $verify->get("ending_time")
                )
            )
        );

    } else {
        echo json_encode(
            array(
                'success' => false,
                'message' => "Invalid credentials"
            )
        );
        exit;
    }
} else if ($_POST['isTeam'] == 'true') {
    $verify->team_name = $_POST['teamName'];
    $verify->team_code = $_POST['teamCode'];
    if (!($verify->fetch() == null)) {
        // session start

        $session->start($verify);
        die(
            json_encode(
                array(
                    'success'       => true,
                    'starting_time' => $verify->get("starting_time"),
                    'ending_time'   => $verify->get("ending_time")
                )
            )
        );
    } else {
        echo json_encode(
            array(
                'success' => false,
                'message' => "Invalid credentials"
            )
        );
        die();
    }
}
