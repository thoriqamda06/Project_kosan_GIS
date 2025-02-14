<?php
include 'koneksi.php';

$id = intval($_GET['id']); // Sanitasi ID
$sql = "SELECT * FROM kosan WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $universitas = $conn->real_escape_string($_POST['universitas']);
    $nama_kos = $conn->real_escape_string($_POST['nama_kos']);
    $jenis_kos = $conn->real_escape_string($_POST['jenis_kos']);
    $durasi_sewa = $conn->real_escape_string($_POST['durasi_sewa']);
    $harga = $conn->real_escape_string($_POST['harga']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $no_telepon = $conn->real_escape_string($_POST['no_telepon']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $provinsi = $conn->real_escape_string($_POST['provinsi']);
    $kota = $conn->real_escape_string($_POST['kota']);
    $kecamatan = $conn->real_escape_string($_POST['kecamatan']);


    // Upload foto jika ada
    $foto_uploaded = false;
    if (!empty($_FILES['foto']['name'])) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_types)) {
            $foto = uniqid() . '.' . $file_extension; // Buat nama file unik
            $target_dir = "../uploads/";
            $target_file = $target_dir . $foto;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                $foto_uploaded = true;
            }
        } else {
            echo "File format tidak valid.";
            exit;
        }
    }

    // Update query
    if ($foto_uploaded) {
        $sql = "UPDATE kosan SET universitas=?, nama_kos=?, jenis_kos=?, durasi_sewa=?, harga=?, deskripsi=?, no_telepon=?, alamat=?, provinsi=?, kota=?, kecamatan=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssi", $universitas, $nama_kos, $jenis_kos, $durasi_sewa, $harga , $deskripsi, $no_telepon, $alamat, $provinsi, $kota, $kecamatan, $id);
    } else {
        $sql = "UPDATE kosan SET universitas=?, nama_kos=?, jenis_kos=?, durasi_sewa=?, harga=?, deskripsi=?, no_telepon=?, alamat=?, provinsi=?, kota=?, kecamatan=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssi", $universitas, $nama_kos, $jenis_kos, $durasi_sewa, $harga, $deskripsi, $no_telepon, $alamat, $provinsi, $kota, $kecamatan, $id);
    }

    // Eksekusi query
    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kos</title>
    <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 px-4 w-2/3">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Edit Data Kos</h1>
        <form action="" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            <!-- Universitas -->
            <div class="mb-4">
                <label for="universitas" class="block text-sm font-medium text-gray-700 mb-1">Universitas:</label>
                <select name="universitas" id="universitas" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="UNIVERSITAS MALIKUSSALEH" <?php echo ($row['universitas'] == 'UNIVERSITAS MALIKUSSALEH') ? 'selected' : ''; ?>>UNIVERSITAS MALIKUSSALEH</option>
                    <option value="POLTEK LHOKSEUMAWE" <?php echo ($row['universitas'] == 'POLTEK LHOKSEUMAWE') ? 'selected' : ''; ?>>POLTEK LHOKSEUMAWE</option>
                    <option value="STIE LHOKSEUMAWE" <?php echo ($row['universitas'] == 'STIE LHOKSEUMAWE') ? 'selected' : ''; ?>>STIE LHOKSEUMAWE</option>
                    <option value="STIAN LHOKSEUMAWE" <?php echo ($row['universitas'] == 'STIAN LHOKSEUMAWE') ? 'selected' : ''; ?>>STIAN LHOKSEUMAWE</option>
                    <option value="UNIVERSITAS BUMI PERSADA" <?php echo ($row['universitas'] == 'UNIVERSITAS BUMI PERSADA') ? 'selected' : ''; ?>>UNIVERSITAS BUMI PERSADA</option>
                    <option value="INSTITUT AGAMA ISLAM NEGERI LHOKSEUMAWE" <?php echo ($row['universitas'] == 'INSTITUT AGAMA ISLAM NEGERI LHOKSEUMAWE') ? 'selected' : ''; ?>>INSTITUT AGAMA ISLAM NEGERI LHOKSEUMAWE</option>
                    <option value="UNIVERSITAS ISLAM KEBANGSAAN INDONESIA" <?php echo ($row['universitas'] == 'UNIVERSITAS ISLAM KEBANGSAAN INDONESIA') ? 'selected' : ''; ?>>UNIVERSITAS ISLAM KEBANGSAAN INDONESIA</option>
                    <option value="STIKKES DARUSSALAM LHOKSEUMAWE" <?php echo ($row['universitas'] == 'STIKKES DARUSSALAM LHOKSEUMAWE') ? 'selected' : ''; ?>>STIKKES DARUSSALAM LHOKSEUMAWE</option>
                    <option value="STIKKES MUHAMMADIYAH LHOKSEUMAWE" <?php echo ($row['universitas'] == 'STIKKES MUHAMMADIYAH LHOKSEUMAWE') ? 'selected' : ''; ?>>STIKKES MUHAMMADIYAH LHOKSEUMAWE</option>
                    <option value="SEKOLAH TINGGI ILMU HUKUM AL-BANNA" <?php echo ($row['universitas'] == 'SEKOLAH TINGGI ILMU HUKUM AL-BANNA') ? 'selected' : ''; ?>>SEKOLAH TINGGI ILMU HUKUM AL-BANNA</option>
                    <option value="STIKES GETSEMPANA LHOKSUKON" <?php echo ($row['universitas'] == 'STIKES GETSEMPANA LHOKSUKON') ? 'selected' : ''; ?>>STIKES GETSEMPANA LHOKSUKON</option>
                    <option value="STAI JAMIATUT TARBIYAH LHOKSUKON" <?php echo ($row['universitas'] == 'STAI JAMIATUT TARBIYAH LHOKSUKON') ? 'selected' : ''; ?>>STAI JAMIATUT TARBIYAH LHOKSUKON</option>
                </select>
            </div>

            <!-- Nama Kos -->
            <div class="mb-4">
                <label for="nama_kos" class="block text-sm font-medium text-gray-700 mb-1">Nama Kos:</label>
                <input type="text" name="nama_kos" id="nama_kos" value="<?php echo $row['nama_kos']; ?>" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Jenis Kos -->
            <div class="mb-4">
                <label for="jenis_kos" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kos:</label>
                <select name="jenis_kos" id="jenis_kos" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="Pria" <?php echo ($row['jenis_kos'] == 'Pria') ? 'selected' : ''; ?>>Pria</option>
                    <option value="Wanita" <?php echo ($row['jenis_kos'] == 'Wanita') ? 'selected' : ''; ?>>Wanita</option>
                </select>
            </div>

            <!-- Tipe Kos -->
            <div class="mb-4">
                <label for="durasi_sewa" class="block text-sm font-medium text-gray-700 mb-1">Tipe Kos:</label>
                <select name="durasi_sewa" id="durasi_sewa" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="Bulanan" <?php echo ($row['durasi_sewa'] == 'Bulanan') ? 'selected' : ''; ?>>Bulanan</option>
                    <option value="Tahunan" <?php echo ($row['durasi_sewa'] == 'Tahunan') ? 'selected' : ''; ?>>Tahunan</option>
                </select>
            </div>

            <!-- Harga -->
            <div class="mb-4">
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga :</label>
                <input type="text" name="harga" id="harga" value="<?php echo $row['harga']; ?>" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required><?php echo $row['deskripsi']; ?></textarea>
            </div>

            <!-- Nomor WhatsApp -->
            <div class="mb-4">
                <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp:</label>
                <input type="text" name="no_telepon" id="no_telepon" value="<?php echo $row['no_telepon']; ?>" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat:</label>
                <input type="text" name="alamat" id="alamat" value="<?php echo $row['alamat']; ?>" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

             <!-- Prov -->
            <div class="mb-4">
                <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1">Provinsi :</label>
                <select name="provinsi" id="provinsi" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="Aceh" <?php echo ($row['provinsi'] == 'Aceh') ? 'selected' : ''; ?>>Aceh</option>
                </select>
            </div>

            <!-- Kota/Kab -->
            <div class="mb-4">
                <label for="kota" class="block text-sm font-medium text-gray-700 mb-1">Kota/Kab :</label>
                <select name="kota" id="kota" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="Lhokseumawe" <?php echo ($row['kota'] == 'Lhokseumawe') ? 'selected' : ''; ?>>Lhokseumawe</option>
                    <option value="Aceh Utara" <?php echo ($row['kota'] == 'Aceh Utara') ? 'selected' : ''; ?>>Aceh Utara</option>
                </select>
            </div>

            <!-- Kec -->
            <div class="mb-4">
                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kec :</label>
                <select name="kecamatan" id="kecamatan" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="Banda Sakti" <?php echo ($row['kecamatan'] == 'Banda Sakti') ? 'selected' : ''; ?>>Banda Sakti</option>
                    <option value="Muara Satu" <?php echo ($row['kecamatan'] == 'Muara Satu') ? 'selected' : ''; ?>>Muara Satu</option>
                    <option value="Muara Dua" <?php echo ($row['kecamatan'] == 'Muara Dua') ? 'selected' : ''; ?>>Muara Dua</option>
                    <option value="Blang Mangat" <?php echo ($row['kecamatan'] == 'Blang Mangat') ? 'selected' : ''; ?>>Blang Mangat</option>
                    <option value="Tanah Pasir" <?php echo ($row['kecamatan'] == 'Tanah Pasir') ? 'selected' : ''; ?>>Tanah Pasir</option>
                    <option value="Dewantara" <?php echo ($row['kecamatan'] == 'Dewantara') ? 'selected' : ''; ?>>Dewantara</option>
                    <option value="Muara Batu" <?php echo ($row['kecamatan'] == 'Muara Batu') ? 'selected' : ''; ?>>Muara Batu</option>
                    <option value="Lhoksukon" <?php echo ($row['kecamatan'] == 'Lhoksukon') ? 'selected' : ''; ?>>Lhoksukon</option>
                </select>
            </div>

            <!-- Foto Kos -->
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Foto Kos:</label>
                <input type="file" name="foto" id="foto" class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" accept="image/*">
                <?php if (!empty($row['foto'])): ?>
                    <img src="<?php echo $row['foto']; ?>" alt="Foto Kos" class="mt-2 rounded-lg shadow-md w-36">
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-md shadow hover:bg-orange-700 focus:ring focus:ring-orange-500">Update</button>
            </div>
        </form>
    </div>
</body>

</html>