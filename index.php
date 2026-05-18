<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AGM API</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      min-height: 100vh;
      background: #f8f9fa;
      font-family: 'Inter', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #1a1a2e;
    }

    .container {
      width: 90%;
      max-width: 480px;
    }

    .header {
      margin-bottom: 32px;
    }

    .logo {
      font-size: 13px;
      font-weight: 600;
      letter-spacing: 3px;
      color: #888;
      text-transform: uppercase;
      margin-bottom: 12px;
    }

    h1 {
      font-size: 32px;
      font-weight: 600;
      color: #1a1a2e;
      letter-spacing: -0.5px;
      line-height: 1.2;
    }

    h1 span {
      color: #4361ee;
    }

    .subtitle {
      margin-top: 8px;
      font-size: 14px;
      color: #888;
      font-weight: 400;
    }

    .divider {
      width: 40px;
      height: 3px;
      background: #4361ee;
      border-radius: 2px;
      margin: 24px 0;
    }

    .card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      margin-bottom: 12px;
      border: 1px solid #f0f0f0;
      box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    .card-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .card-label {
      font-size: 12px;
      font-weight: 500;
      color: #aaa;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .card-value {
      font-size: 14px;
      font-weight: 500;
      color: #1a1a2e;
    }

    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-badge.online {
      background: #f0faf4;
      color: #2d9e5f;
    }

    .status-badge.offline {
      background: #fff0f0;
      color: #e53e3e;
    }

    .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
    }

    .dot.online { background: #2d9e5f; }
    .dot.offline { background: #e53e3e; }

    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 12px;
    }

    .stat-card {
      background: white;
      border-radius: 16px;
      padding: 20px;
      border: 1px solid #f0f0f0;
      box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    .stat-number {
      font-size: 28px;
      font-weight: 600;
      color: #4361ee;
      letter-spacing: -1px;
    }

    .stat-label {
      font-size: 12px;
      color: #aaa;
      margin-top: 4px;
      font-weight: 500;
    }

    .footer {
      margin-top: 24px;
      font-size: 12px;
      color: #bbb;
      text-align: center;
    }
  </style>
</head>
<body>

<?php
 $host   = 'centerbeam.proxy.rlwy.net';
$dbname = 'railway';
$user   = 'root';
$pass   = 'cmApvVYAkvQYQBkKITqodrfFgcHjSgnK';
$port   = 14473;

$conn = new mysqli($host, $user, $pass, $dbname, $port);
  $dbOk = !$conn->connect_error;

  $guruCount   = 0;
  $kelasCount  = 0;
  $jadwalCount = 0;

  if ($dbOk) {
    $r1 = $conn->query("SELECT COUNT(*) as c FROM guru");
    if ($r1) $guruCount = $r1->fetch_assoc()['c'];

    $r2 = $conn->query("SELECT COUNT(*) as c FROM kelas");
    if ($r2) $kelasCount = $r2->fetch_assoc()['c'];

    $r3 = $conn->query("SELECT COUNT(*) as c FROM data_jadwal");
    if ($r3) $jadwalCount = $r3->fetch_assoc()['c'];
  }

  $status = $dbOk ? 'online' : 'offline';
  $statusText = $dbOk ? 'Online' : 'Offline';
?>

<div class="container">
  <div class="header">
    <div class="logo">Sistem Informasi</div>
    <h1>Jadwal <span>Mengajar</span></h1>
    <p class="subtitle">Backend API untuk aplikasi mobile AGM</p>
  </div>

  <div class="divider"></div>

  <div class="card">
    <div class="card-row">
      <div>
        <div class="card-label">Status Server</div>
        <div class="card-value" style="margin-top:4px">API berjalan normal</div>
      </div>
      <div class="status-badge <?= $status ?>">
        <div class="dot <?= $status ?>"></div>
        <?= $statusText ?>
      </div>
    </div>
  </div>

  <div class="grid">
    <div class="stat-card">
      <div class="stat-number"><?= $guruCount ?></div>
      <div class="stat-label">Guru</div>
    </div>
    <div class="stat-card">
      <div class="stat-number"><?= $kelasCount ?></div>
      <div class="stat-label">Kelas</div>
    </div>
    <div class="stat-card">
      <div class="stat-number"><?= $jadwalCount ?></div>
      <div class="stat-label">Jadwal</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">PHP</div>
      <div class="stat-label"><?= phpversion() ?></div>
    </div>
  </div>

  <div class="footer">
    <?= date('d M Y · H:i') ?> WIB
  </div>
</div>

</body>
</html>
