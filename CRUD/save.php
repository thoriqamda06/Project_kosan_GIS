<?php
include 'koneksi.php'; // Pastikan file koneksi sudah benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $universitas = $_POST['universitas'];
    $nama_kos = $_POST['nama_kos'];
    $jenis_kos = $_POST['jenis_kos'];
    $durasi_sewa = $_POST['durasi_sewa'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];
    $provinsi = $_POST['provinsi'];
    $kota = $_POST['kota'];
    $kecamatan = $_POST['kecamatan'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $jarak = $_POST['jarak'];
    $google_maps_link = "https://www.google.com/maps?q={$latitude},{$longitude}";
    $fasilitas = isset($_POST['fasilitas']) ? implode(',', $_POST['fasilitas']) : '';
    $gambarTambahanPaths = [];
    if (!empty($_FILES['gambar_tambahan']['name'][0])) {
        $target_dir = "../uploads/";
        foreach ($_FILES['gambar_tambahan']['name'] as $key => $name) {
            $fileTmpPath = $_FILES['gambar_tambahan']['tmp_name'][$key];
            $fileName = basename($name);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validasi ekstensi file
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                echo "Format file $fileName tidak valid.";
                exit;
            }

            // Validasi ukuran file
            if ($_FILES['gambar_tambahan']['size'][$key] > 10 * 1024 * 1024) {
                echo "Ukuran file $fileName terlalu besar (maksimal 10MB).";
                exit;
            }

            // Simpan file ke direktori target tanpa menambahkan timestamp
            $targetFilePath = $target_dir . $fileName;

            // Pastikan tidak ada file dengan nama sama di folder tujuan
            if (file_exists($targetFilePath)) {
                echo "File $fileName sudah ada. Harap ganti nama file.";
                exit;
            }

            if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                $gambarTambahanPaths[] = $targetFilePath; // Tambahkan ke array
            } else {
                echo "Gagal mengunggah file $fileName.";
                exit;
            }
        }
    }

    // Jika hanya ingin satu file (ambil elemen pertama), gunakan:
    if (!empty($gambarTambahanPaths)) {
        $gambarTambahanString = $gambarTambahanPaths[0]; // Ambil file pertama
    } else {
        $gambarTambahanString = '';
    }

    // Jika semua file diinginkan sebagai string, gabungkan dengan koma:
    $gambarTambahanString = implode(',', $gambarTambahanPaths);

    // Validasi dan sanitasi input
    $universitas = mysqli_real_escape_string($conn, $universitas);
    $nama_kos = mysqli_real_escape_string($conn, $nama_kos);
    $jenis_kos = mysqli_real_escape_string($conn, $jenis_kos);
    $durasi_sewa = mysqli_real_escape_string($conn, $durasi_sewa);
    $harga = mysqli_real_escape_string($conn, $harga);
    $deskripsi = mysqli_real_escape_string($conn, $deskripsi);
    $no_telepon = mysqli_real_escape_string($conn, $no_telepon);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    $provinsi = mysqli_real_escape_string($conn, $provinsi);
    $kota = mysqli_real_escape_string($conn, $kota);
    $kecamatan = mysqli_real_escape_string($conn, $kecamatan);
    $latitude = mysqli_real_escape_string($conn, $latitude);
    $longitude = mysqli_real_escape_string($conn, $longitude);
    $jarak = mysqli_real_escape_string($conn, $jarak);

    // Validasi file foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = basename($_FILES['foto']['name']);
        $target_dir = "../uploads/";

        // Cek ekstensi file (hanya izinkan gambar)
        $allowed_types = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

        if (!in_array($file_extension, $allowed_types)) {
            echo "Hanya file gambar yang diperbolehkan.";
            exit;
        }

        // Cek ukuran file (misal, maksimal 10MB)
        if ($_FILES['foto']['size'] > 10 * 1024 * 1024) {
            echo "Ukuran file terlalu besar. Maksimal 10MB.";
            exit;
        }

        $foto_path = $target_dir . $foto;

        // Pindahkan file yang diunggah
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
            echo "Gagal mengunggah file.";
            exit;
        }
    } else {
        echo "Tidak ada file yang diunggah atau terjadi kesalahan.";
        exit;
    }

    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("INSERT INTO kosan (universitas, nama_kos, jenis_kos, durasi_sewa, harga, deskripsi, no_telepon, alamat, provinsi, kota, kecamatan, latitude, longitude, jarak, gambar_url, google_maps_link, fasilitas, gambar_tambahan) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssss", $universitas, $nama_kos, $jenis_kos, $durasi_sewa, $harga, $deskripsi, $no_telepon, $alamat, $provinsi, $kota, $kecamatan, $latitude, $longitude, $jarak, $foto_path, $google_maps_link, $fasilitas, $gambarTambahanString);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect jika berhasil
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
