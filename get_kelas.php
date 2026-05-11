<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once 'koneksi.php';
$r = $conn->query("SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
if (!$r) { echo json_encode(['status'=>'error','message'=>$conn->error]); exit; }
$data = [];
while ($row = $r->fetch_assoc()) $data[] = $row;
echo json_encode(['status'=>'success','data'=>$data]);
$conn->close();
?>
