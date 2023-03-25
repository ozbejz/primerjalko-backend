<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: *");

$header = apache_request_headers();

$mysqli = require __DIR__ . "/database.php";

$q = "SELECT naziv, opis, znamka FROM izdelek WHERE IdIzdelek = ? ORDER BY naziv";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($q)){
    echo("SQL error: " . $mysqli->error);
}

$stmt->bind_param("i", $header["id"]);

$stmt->execute();

$rs = $stmt->get_result();

$result = array();
while($r = $rs->fetch_assoc()){
    array_push($result, $r);
}

$stmt->close();
echo json_encode($result);
?>