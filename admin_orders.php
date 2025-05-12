<?php
$conn = new mysqli("localhost", "root", "", "kaphiya_db");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$result = $conn->query("SELECT * FROM orders ORDER BY waktu_order DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan Masuk - Admin Kaphiya</title>
  <style>
    body { font-family: 'Quicksand', sans-serif; background: #fff0f5; padding: 20px; }
    h2 { color: #d63384; }
    table { width: 100%; border-collapse: collapse; background: white; }
    th, td { border: 1px solid #f8c0d4; padding: 10px; text-align: left; }
    th { background-color: #ff8fb1; color: white; }
    tr:nth-child(even) { background-color: #fff5f9; }
  </style>
</head>
<body>
  <h2>📋 Daftar Pesanan Masuk</h2>
  <table>
    <tr>
      <th>No</th>
      <th>Waktu</th>
      <th>Pesanan</th>
      <th>Catatan</th>
      <th>Metode Bayar</th>
      <th>Total</th>
    </tr>
    <?php $no=1; while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['waktu_order'] ?></td>
        <td><?= htmlspecialchars($row['pesanan_detail']) ?></td>
        <td><?= htmlspecialchars($row['catatan']) ?></td>
        <td><?= $row['metode_bayar'] ?></td>
        <td>Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
