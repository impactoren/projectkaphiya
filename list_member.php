<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "kaphiya_db";
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM membership WHERE id=$id");
  header("Location: list_member.php");
  exit();
}

$result = $conn->query("SELECT * FROM membership ORDER BY tanggal_daftar DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Member - Kaphiya</title>
  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: #ffeef5;
      color: #333;
      padding: 30px;
      text-align: center;
    }
    h1 {
      color: #d14e79;
      margin-bottom: 30px;
    }
    table {
      width: 90%;
      margin: auto;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px #e0a5c0;
    }
    th, td {
      border: 1px solid #f3c1d8;
      padding: 10px;
    }
    th {
      background-color: #fcd3e1;
    }
    tr:nth-child(even) {
      background-color: #fdf5f9;
    }
    .delete-btn {
      background-color: #ff4f81;
      border: none;
      color: white;
      padding: 6px 10px;
      cursor: pointer;
      border-radius: 5px;
    }
    .delete-btn:hover {
      background-color: #e04371;
    }
  </style>
</head>
<body>
  <h1>💖 Daftar Kapi-Member 💖</h1>
  <table>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Email</th>
      <th>No HP</th>
      <th>Preferensi</th>
      <th>Pesan</th>
      <th>Terdaftar</th>
      <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['nama']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['nohp']) ?></td>
      <td><?= htmlspecialchars($row['preferensi']) ?></td>
      <td><?= nl2br(htmlspecialchars($row['pesan'])) ?></td>
      <td><?= $row['tanggal_daftar'] ?></td>
      <td>
        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin mau hapus data ini?')">
          <button class="delete-btn">Hapus</button>
        </a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
