<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');

$data = json_decode(file_get_contents('php://input'));

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO izdelek (IdKategorija, naziv, opis, znamka) 
        VALUES (?, ?, ?, ?)"
    ;

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)){
    echo("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssss",
        $data->kategorija,
        $data->naziv, 
        $data->opis,
        $data->znamka
    );

if($stmt->execute()){
    echo json_encode(['status' => 1]);
    exit;
}
else{
    echo json_encode($data);
    exit;
}
?>