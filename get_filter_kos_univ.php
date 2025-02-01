<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'universitas');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari permintaan POST
$universitas = $_POST['universitas'] ?? '';
$harga = $_POST['harga'] ?? '';
$jarak = $_POST['jarak'] ?? '';
$fasilitas = $_POST['fasilitas'] ?? '';
$order = $_POST['order'] ?? ''; // 'asc' atau 'desc'

// Validasi input
if (empty($universitas)) {
    echo json_encode(['error' => 'Universitas tidak boleh kosong.']);
    exit;
}

// Query data kosan berdasarkan filter
$query = "SELECT * FROM kosan WHERE universitas = ?";
$params = [$universitas];
$types = "s";

// Tambahkan filter harga jika ada
if (!empty($harga)) {
    $query .= " AND harga <= ?";
    $params[] = intval($harga);
    $types .= "i";
}

// Tambahkan filter jarak jika ada
if (!empty($jarak)) {
    $query .= " AND jarak <= ?";
    $params[] = intval($jarak);
    $types .= "i";
}

// Tambahkan filter fasilitas jika ada
if (!empty($fasilitas)) {
    $fasilitasArray = explode(',', $fasilitas);
    foreach ($fasilitasArray as $fasilitas) {
        $query .= " AND fasilitas LIKE ?";
        $params[] = "%" . trim($fasilitas) . "%";
        $types .= "s";
    }
}


// Tambahkan urutan jarak jika parameter 'order' disediakan
if (!empty($order) && in_array(strtolower($order), ['asc', 'desc'])) {
    $query .= " ORDER BY jarak " . strtoupper($order);
}

// Siapkan statement
$stmt = $conn->prepare($query);

// Periksa jika statement gagal disiapkan
if (!$stmt) {
    echo json_encode(['error' => 'Gagal menyiapkan statement: ' . $conn->error]);
    exit;
}

// Bind parameter
$stmt->bind_param($types, ...$params);
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
        'no_telepon' => $row['no_telepon'],
        'jarak' => $row['jarak'], // Tambahkan jarak untuk ditampilkan jika diperlukan
    ];
}

// Kirim respons JSON
echo json_encode($kosan_list);

// Tutup koneksi
$stmt->close();
$conn->close();
?>
