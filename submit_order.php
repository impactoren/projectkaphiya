<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "kaphiya_db";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap data dari form
$pesanan = $_POST['pesanan_detail'] ?? '';
$catatan = $_POST['catatan'] ?? '';
$metode = $_POST['metode_bayar'] ?? '';
$total = (int) ($_POST['total_harga'] ?? 0);

// Validasi
if ($pesanan == '' || $metode == '' || $total <= 0) {
    echo "Data tidak lengkap. Silakan kembali dan lengkapi form.";
    exit;
}

// Ambil waktu saat ini
date_default_timezone_set('Asia/Jakarta');
$waktu_now = date('Y-m-d H:i:s');

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO orders (pesanan, catatan, metode_bayar, total_harga, pesanan_detail, waktu_order) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiss", $pesanan, $catatan, $metode, $total, $pesanan, $waktu_now);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
    exit;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Pesanan 💖</title>
  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: #fff0f6;
      color: #880e4f;
      margin: 0;
      padding: 0;
    }
    .receipt {
      max-width: 500px;
      margin: 50px auto;
      background: #ffe3ec;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
    }
    h2 {
      color: #d81b60;
      margin-bottom: 10px;
    }
    .heart {
      font-size: 30px;
      animation: pulse 1s infinite;
    }
    p {
      margin: 10px 0;
      font-size: 16px;
    }
    .button {
      margin-top: 25px;
      padding: 12px 20px;
      background-color: #f06292;
      color: white;
      border: none;
      border-radius: 10px;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
    }
    .button:hover {
      background-color: #d81b60;
    }
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }
    @keyframes fadeIn {
      from {opacity: 0;}
      to {opacity: 1;}
    }
    .struk-box {
      background: #fff;
      border-radius: 15px;
      padding: 20px;
      margin-top: 20px;
      text-align: left;
      color: #6a1b9a;
    }
  </style>
</head>
<body>

<div class="receipt">
  <div class="heart">💗</div>
  <h2>Yay! Pesananmu sudah kami terima</h2>
  <div class="struk-box">
    <p><strong>Nomor Pesanan:</strong> #<?= $order_id; ?></p>
    <p><strong>Pesanan:</strong><br><?= nl2br(htmlspecialchars($pesanan)); ?></p>
    <p><strong>Catatan:</strong><br><?= nl2br(htmlspecialchars($catatan)); ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($metode); ?></p>
    <p><strong>Total:</strong> Rp<?= number_format($total, 0, ',', '.'); ?></p>
  </div>
  <?php if ($metode === 'QRIS') : ?>
    <p><strong>Silakan scan QR di bawah untuk bayar 💸</strong></p>
    <img src="https://api.qrserver.com/v1/create-qr-code/?data=KAPIHYA-ORDER-<?= $order_id; ?>&size=150x150" alt="QRIS" />
  <?php else : ?>
    <p>Silakan bayar langsung di kasir ya 💵</p>
  <?php endif; ?>
  <a href="ordernow.html" class="button">Kembali ke Order 💕</a>
</div>

</body>
</html>
