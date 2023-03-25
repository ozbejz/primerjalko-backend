<?php
    header('Access-Control-Allow-Origin:*');
    
    $ime = "admin";
    $email = "admin@gmail.com";
    $geslo = "admin";
    $je_admin = 1;

    $password_hash = password_hash($geslo, PASSWORD_DEFAULT);

    $mysqli = require __DIR__ . "/database.php";

    $sql = "INSERT INTO uporabnik (ime, email, password_hash, je_admin) 
        VALUES (?, ?, ?, ?)"
    ;

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)){
        echo("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("ssss",
        $ime, 
        $email, 
        $password_hash,
        $je_admin
    );
    
    if($stmt->execute()){
        header("Location: http://localhost:3000/registracija-uspesna");
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