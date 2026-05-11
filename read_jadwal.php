<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
require_once 'koneksi.php';

$hari = isset($_GET['hari']) ? $conn->real_escape_string(trim($_GET['hari'])) : '';

$tabel = 'jadwal';
$cek = $conn->query("SHOW TABLES LIKE 'jadwal'");
if ($cek->num_rows === 0) $tabel = 'data_jadwal';

$sql = "SELECT j.id_jadwal, j.hari, j.jam_ke, j.waktu_mulai, j.waktu_selesai,
               k.nama_kelas, m.kode_mapel, m.nama_mapel, g.id_guru, g.nama_guru
        FROM $tabel j
        JOIN kelas k ON j.id_kelas = k.id_kelas
        JOIN mapel m ON j.kode_mapel = m.kode_mapel
        JOIN guru g ON j.id_guru = g.id_guru";
if ($hari !== '') $sql .= " WHERE j.hari = '$hari'";
$sql .= " ORDER BY FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat'), j.jam_ke ASC";

$r = $conn->query($sql);
if (!$r) { echo json_encode(['status'=>'error','message'=>$conn->error]); exit; }
$data = [];
while ($row = $r->fetch_assoc()) $data[] = $row;
echo json_encode(['status'=>'success','data'=>$data]);
$conn->close();
?>
