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

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM uporabnik WHERE email = ?";

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)){
        echo("SQL error: " . $mysqli->error);
    }
/*
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $rs = $stmt->get_result();
    $user = $rs->fetch_assoc();
    $stmt->close();

    if(password_verify($_POST["geslo"], $user["password_hash"])){
        session_start();
        $_SESSION['user_id'] = $user["Id"];

        session_write_close();
        header("Location: http://localhost:3000/uspesna-prijava");
    }
    
    */

    $stmt->bind_param("s", $data->email);
    $stmt->execute();
    $rs = $stmt->get_result();
    $user = $rs->fetch_assoc();
    $stmt->close();
    if($user){
        if(password_verify($data->geslo, $user["password_hash"])){
            $_SESSION["user_id"] = $user["Id"];
            session_write_close();
            
            echo json_encode(['status' => 1]);
            exit;
        }
        echo json_encode(['status' => 0]);
        exit;
    }
}
?>