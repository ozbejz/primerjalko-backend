<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "http://dev.local:3000" || $http_origin == "http://localhost:3000" || $http_origin = "https://primerjalko.vercel.app"){
    header("Access-Control-Allow-Origin: $http_origin");
}

if(!isset($_SESSION)) {
   session_start();
}

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept');

$data = json_decode(file_get_contents('php://input'));

$mysqli = require __DIR__ . "/database.php";

if(!isset($_SESSION["user_id"])){
    echo json_encode(['aktiven'=>0, 'je_admin'=>0]);
    exit;
}

$id = $_SESSION["user_id"];
$sql = "SELECT aktiven, je_admin, Id FROM uporabnik WHERE Id = ?";
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)){
    echo("SQL error: " . $mysqli->error);
}

$stmt->bind_param("i", $id);

$stmt->execute();

$rs = $stmt->get_result();

$result = array();

while($r = $rs->fetch_assoc()){
    array_push($result, $r);
    echo json_encode($r);
}

$stmt->close();
exit;
?>