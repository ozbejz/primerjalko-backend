<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "http://dev.local:3000" || $http_origin == "http://localhost:3000" || $http_origin = "https://primerjalko.vercel.app"){
    header("Access-Control-Allow-Origin: $http_origin");
}
ini_set('session.cookie_domain', 'https://primerjalko.vercel.app');
if(!isset($_SESSION)) {
   session_start();
}

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept');

$data = json_decode(file_get_contents('php://input'));

$mysqli = require __DIR__ . "/database.php";

$stmt = $mysqli->stmt_init();
if(isset($data->komentar)){
    $q = "INSERT INTO ocena(vrednost, komentar, IdUporabnik, IdIzdelek) VALUES (?,?,?,?)";
    if (!$stmt->prepare($q)){
        echo("SQL error: " . $mysqli->error);
    }
    $stmt->bind_param("isii",
        $data->vrednost,
        $data->komentar,
        $_SESSION["user_id"],
        $data->IdIzdelek
    );
}
else{
    $q = "INSERT INTO ocena(vrednost, IdUporabnik, IdIzdelek) VALUES (?,?,?)";
    if (!$stmt->prepare($q)){
        echo("SQL error: " . $mysqli->error);
    }
    $stmt->bind_param("iii",
        $data->vrednost,
        $_SESSION["user_id"],
        $data->IdIzdelek
    );
}

if($stmt->execute()){
    echo json_encode(['status' => 1]);
    exit;
}
else{
    echo json_encode(session_id());
    exit;
}

?>