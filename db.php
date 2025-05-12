<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "kaphiya_order";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
?>
