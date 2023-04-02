<?php
$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "http://dev.local:3000" || $http_origin == "http://localhost:3000" || $http_origin = "https://primerjalko.vercel.app"){
    header("Access-Control-Allow-Origin: $http_origin");
}

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept');

$data = json_decode(file_get_contents('php://input'));

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){

    if($data->geslo !== $data->preveri_geslo){
        echo json_encode(['status' => 2]);
        exit;
    }

    $mysqli = require __DIR__ . "/database.php";
    $password_hash = password_hash($data->geslo, PASSWORD_DEFAULT);

    $sql = "INSERT INTO uporabnik (ime, email, password_hash) 
    VALUES (?, ?, ?)"
    ;

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)){
        echo("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sss",
        $data->ime, 
        $data->email, 
        $password_hash
    );

    if($stmt->execute()){
        echo json_encode(['status' => 1]);
        exit;
    }
    else{
        if($mysqli->errno === 1062){
            echo json_encode(['status' => 3]);
            exit;
        }
        else{
            echo json_encode(['status' => 0]);
            exit;
        }
}}
/*
header('Access-Control-Allow-Origin:*');
if($_POST["geslo"] !== $_POST["preveri_geslo"]){
    die("Gesla se ne ujemata");
}

$password_hash = password_hash($_POST["geslo"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO uporabnik (ime, email, password_hash) 
    VALUES (?, ?, ?)"
;

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)){
    echo("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
    $_POST["ime"], 
    $_POST["email"], 
    $password_hash
);

if($stmt->execute()){
    header("Location: http://localhost:3000/uspesna-registracija");
    exit;
}
else{
    if($mysqli->errno === 1062){
        die("Ta email je ze v uporabi");
    }
    else{
        die($mysqli->error . " " . $mysqli->errno);
    }
}*/
?>