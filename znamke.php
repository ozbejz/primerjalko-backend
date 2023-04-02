<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: *");

$header = apache_request_headers();

$mysqli = require __DIR__ . "/database.php";

if(isset($header["id"])){

    $sql = "SELECT DISTINCT znamka FROM izdelek WHERE IdKategorija = ?";

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
}
?>