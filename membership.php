<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "kaphiya_db";

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$nohp = $_POST['nohp'];
$preferensi = $_POST['preferensi'];
$pesan = $_POST['pesan'];

// Simpan ke database
$sql = "INSERT INTO membership (nama, email, nohp, preferensi, pesan)
        VALUES ('$nama', '$email', '$nohp', '$preferensi', '$pesan')";

if ($conn->query($sql) === TRUE) {
  echo "<script>alert('Terima kasih sudah daftar jadi Kapi-Member! ☕💕'); window.location.href='membership.html';</script>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
