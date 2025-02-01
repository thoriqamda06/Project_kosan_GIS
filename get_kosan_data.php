<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'universitas');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari permintaan POST
$university = $_POST['university'] ?? '';

// Jika universitas tidak dipilih, kirim respons kosong
if (empty($university)) {
    echo json_encode([]);
    exit;
}

// Query data kosan berdasarkan universitas
$stmt = $conn->prepare("SELECT * FROM kosan WHERE universitas = ?");
$stmt->bind_param("s", $university);
$stmt->execute();
$result = $stmt->get_result();

// Ambil data dan ubah ke format JSON
$kosan_list = [];
while ($row = $result->fetch_assoc()) {
    $kosan_list[] = [
        'id' => $row['id'],  
        'gambar_url' => $row['gambar_url'],
        'nama_kos' => $row['nama_kos'],
        'deskripsi' => $row['deskripsi'],
        'harga' => $row['harga'],
        'alamat' => $row['alamat'],
        'no_telepon' => $row['no_telepon']
    ];
}

// Kirim respons JSON
echo json_encode($kosan_list);

// Tutup koneksi
$stmt->close();
$conn->close();
