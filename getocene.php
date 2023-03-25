<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: *");

$header = apache_request_headers();

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT o.IdOcena, o.vrednost, o.komentar, u.ime, u.Id FROM ocena o  INNER JOIN uporabnik u ON u.Id = o.IdUporabnik WHERE o.IdIzdelek = ? ORDER BY o.vrednost";
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)){
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