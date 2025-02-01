<?php
header('Content-Type: application/json'); // Pastikan respons berupa JSON

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'universitas'); // Sesuaikan dengan database Anda

// Cek koneksi
if ($conn->connect_error) {
    echo json_encode(['error' => 'Koneksi gagal: ' . $conn->connect_error]);
    exit;
}

// Query awal untuk mengambil data kosan
$query = "SELECT id, nama_kos, deskripsi, harga, alamat, no_telepon, gambar_url FROM kosan";

// Periksa apakah parameter universitas dikirimkan
if (isset($_POST['universitas']) && !empty($_POST['universitas'])) {
    $universitas = $_POST['universitas'];

    // Tambahkan filter universitas ke query
    $query .= " WHERE universitas = ?";
    $stmt = $conn->prepare($query);

    // Periksa jika statement gagal disiapkan
    if (!$stmt) {
        echo json_encode(['error' => 'Gagal menyiapkan statement: ' . $conn->error]);
        exit;
    }

    // Bind parameter ke statement
    $stmt->bind_param('s', $universitas);
} else {
    // Jika tidak ada parameter, tetap gunakan query awal
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['error' => 'Gagal menyiapkan statement: ' . $conn->error]);
        exit;
    }
}

// Eksekusi query
$stmt->execute();
$result = $stmt->get_result();

// Ambil data dari hasil query
$kosan_list = [];
while ($row = $result->fetch_assoc()) {
    $kosan_list[] = [
        'id' => $row['id'],
        'gambar_url' => $row['gambar_url'],
        'nama_kos' => $row['nama_kos'],
        'deskripsi' => $row['deskripsi'],
        'harga' => $row['harga'],
        'alamat' => $row['alamat'],
        'no_telepon' => $row['no_telepon'],
    ];
}

// Kirim data dalam format JSON
echo json_encode($kosan_list);

// Tutup koneksi
$stmt->close();
$conn->close();
?>
