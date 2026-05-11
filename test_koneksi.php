<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$result = ['php'=>'OK','php_version'=>phpversion()];
require_once 'koneksi.php';
if ($conn->connect_error) {
    $result['database']='GAGAL'; $result['db_error']=$conn->connect_error;
} else {
    $result['database']='OK';
    $tables=[]; $q=$conn->query("SHOW TABLES");
    while($row=$q->fetch_array()) $tables[]=$row[0];
    $result['tables']=$tables;
    $conn->close();
}
echo json_encode($result, JSON_PRETTY_PRINT);
?>
