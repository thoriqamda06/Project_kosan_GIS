<?php
$host = "localhost"; // Ganti dengan host Anda
$user = "root"; // Ganti dengan username Anda
$password = ""; // Ganti dengan password Anda
$dbname = "universitas";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>