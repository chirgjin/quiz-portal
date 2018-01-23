<?php
require_once __DIR__ . "/user.class.php";

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

$verify = new Verification;
if($_POST['isTeam'] == 'false') {
    // var_dump($verify->verifyLoneWolf($_REQUEST['email'], $_REQUEST['phone']));
   var_dump( (new USER)->set("email" , $_REQUEST['email'])->set("phone",$_REQUEST['phone'])->fetch());
   echo $verify->verifyLoneWolf($_REQUEST['email'], $_REQUEST['phone']);

} else if($_POST['isTeam'] == 'true') {
    // var_dump($verify->verifyTeam($_REQUEST['teamName'], $_REQUEST['teamCode']));
    echo json_encode($verify->verifyTeam($_REQUEST['teamName'], $_REQUEST['teamCode']));

}


?>
