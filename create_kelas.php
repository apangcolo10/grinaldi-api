<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';
$nama = strtoupper(trim($_POST['nama_kelas'] ?? ''));
if (!$nama){echo json_encode(['status'=>'error','message'=>'Nama kelas wajib diisi']);exit;}
$n = $conn->real_escape_string($nama);
$cek = $conn->query("SELECT id_kelas FROM kelas WHERE nama_kelas='$n'");
if ($cek->num_rows>0){echo json_encode(['status'=>'error','message'=>"Kelas '$nama' sudah ada"]);exit;}
if ($conn->query("INSERT INTO kelas (nama_kelas) VALUES ('$n')")) {
    echo json_encode(['status'=>'success','message'=>'Kelas ditambahkan','data'=>['id_kelas'=>$conn->insert_id,'nama_kelas'=>$nama]]);
} else { echo json_encode(['status'=>'error','message'=>$conn->error]); }
$conn->close();
?>
