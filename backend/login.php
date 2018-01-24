<?php
require_once __DIR__ . "/user.class.php";

// class Verification
// {
//     // simple function to achieve connection to DB with pdo..
//     private function connectToDB() {
//         require  __DIR__ . '/dbconfig.php';
//         return $pdo;
//     }
//
//     private function vTeam($pdo, $teamName, $teamCode) {
//         $sql = "SELECT * FROM users WHERE team_name = ? AND team_code = ?";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([$teamName, $teamCode]);
//         if($stmt->rowCount() > 0) {
//             return $stmt->fetchAll();
//         } else {
//             return false;
//         }
//     }
//
//     public function verifyTeam($teamName, $teamCode) {
//         $pdo = $this->connectToDB();
//         return $this->vTeam($pdo, $teamName, $teamCode);
//     }
//
//     private function vLone($pdo, $email, $phone) {
//         $sql = 'SELECT * FROM users WHERE email = :email AND phone = :phone';
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute(['email' => $email, 'phone' => $phone]);
//         if($stmt->rowCount() > 0) {
//             return $stmt->fetchAll();
//         } else {
//             return false;
//         }
//     }
//
//     public function verifyLoneWolf($email, $phone) {
//         $pdo = $this->connectToDB();
//         return $this->vLone($pdo, $email, $phone);
//     }
//
// }

$verify = new USER;

if($_POST['isTeam'] == 'false') {
    $verify->email = $_POST['email'];
    $verify->phone = $_POST['phone'];
    if(!($verify->fetch() == null)) {
        echo json_encode(array('success' => true));
    }
} else if($_POST['isTeam'] == 'true') {

}


?>
