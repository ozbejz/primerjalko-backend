<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');

$data = json_decode(file_get_contents('php://input'));

$mysqli = require __DIR__ . "/database.php";

$sql = "DELETE FROM ocena WHERE IdOcena=?";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)){
    echo("SQL error: " . $mysqli->error);
}

$stmt->bind_param("i", $data->ocena);

if($stmt->execute()){
    echo json_encode(['status' => 1]);
    exit;
}
else{
    echo json_encode($mysqli->error);
    exit;
}
?>