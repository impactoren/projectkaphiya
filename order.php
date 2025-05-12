<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "kaphiya_db");

if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

// Tambah data pesanan
if (isset($_POST['tambah'])) {
  $nama_menu = $_POST['nama_menu'];
  $kategori = $_POST['kategori'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];
  $jumlah = $_POST['jumlah'];
  $total = $harga * $jumlah;
  $kode = strtoupper(substr(uniqid(), -6));

  $koneksi->query("INSERT INTO orders (nama_menu, kategori, deskripsi, harga, jumlah, total, kode_pesanan) VALUES ('$nama_menu', '$kategori', '$deskripsi', '$harga', '$jumlah', '$total', '$kode')");
}

// Hapus pesanan
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $koneksi->query("DELETE FROM orders WHERE id=$id");
  header("Location: order.php");
}

// Ambil semua data pesanan
$data = $koneksi->query("SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Order - Kaphiya Coffee</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: 'Quicksand', sans-serif; background: #ffeef5; padding: 20px; }
    h1 { text-align: center; color: #d63384; }
    form { background: #fff0f6; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; }
    input, select, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ffd6e7; border-radius: 8px; }
    table { width: 100%; margin-top: 30px; border-collapse: collapse; background: #fff; }
    th, td { padding: 10px; border: 1px solid #ffd6e7; text-align: center; }
    .btn { background: #f06292; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; text-decoration: none; }
    .btn:hover { background: #ec407a; }
  </style>
</head>
<body>
<h1>Form Order Kaphiya</h1>
<form method="POST">
  <input type="text" name="nama_menu" placeholder="Nama Menu" required>
  <select name="kategori">
    <option value="Dessert">Dessert</option>
    <option value="Kopi">Kopi</option>
  </select>
  <textarea name="deskripsi" placeholder="Deskripsi Menu"></textarea>
  <input type="number" name="harga" placeholder="Harga" required>
  <input type="number" name="jumlah" placeholder="Jumlah" required>
  <button class="btn" type="submit" name="tambah">Tambah Order</button>
</form>

<table>
  <tr>
    <th>No</th><th>Menu</th><th>Kategori</th><th>Harga</th><th>Jumlah</th><th>Total</th><th>Kode</th><th>Aksi</th>
  </tr>
  <?php $no = 1; while ($row = $data->fetch_assoc()) { ?>
  <tr>
    <td><?= $no++ ?></td>
    <td><?= $row['nama_menu'] ?></td>
    <td><?= $row['kategori'] ?></td>
    <td>Rp<?= number_format($row['harga']) ?></td>
    <td><?= $row['jumlah'] ?></td>
    <td>Rp<?= number_format($row['total']) ?></td>
    <td><?= $row['kode_pesanan'] ?></td>
    <td><a class="btn" href="order.php?hapus=<?= $row['id'] ?>">Hapus</a></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>