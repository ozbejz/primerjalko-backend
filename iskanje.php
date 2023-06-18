<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: *");

$header = apache_request_headers();

$mysqli = require __DIR__ . "/database.php";

if(isset($header["isci"])){
    if(strlen($header["isci"]) === 0){
        echo json_encode('');
        exit;
    }
    $niz = '%' . $header["isci"] . '%';
    $sql = "SELECT naziv, IdIzdelek FROM izdelek WHERE naziv LIKE ?";

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)){
        echo("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("s", $niz);

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