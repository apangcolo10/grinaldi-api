<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once 'koneksi.php';
$r = $conn->query("SELECT kode_mapel, nama_mapel FROM mapel ORDER BY nama_mapel ASC");
if (!$r) { echo json_encode(['status'=>'error','message'=>$conn->error]); exit; }
$data = [];
while ($row = $r->fetch_assoc()) $data[] = $row;
echo json_encode(['status'=>'success','data'=>$data]);
$conn->close();
?>
