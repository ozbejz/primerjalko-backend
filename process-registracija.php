<?php
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
}
?>