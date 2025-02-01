<?php include 'koneksi.php';
$sql = "SELECT * FROM kosan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Rumah Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="p-4 bg-white shadow-md">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <a href="../pages/index.php" class="flex items-center space-x-2">
                <svg fill="#e27712" height="40px" width="40px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219.151 219.151">
                    <g>
                        <path d="M109.576,219.151c60.419,0,109.573-49.156,109.573-109.576C219.149,49.156,169.995,0,109.576,0S0.002,49.156,0.002,109.575 C0.002,169.995,49.157,219.151,109.576,219.151z M109.576,15c52.148,0,94.573,42.426,94.574,94.575 c0,52.149-42.425,94.575-94.574,94.576c-52.148-0.001-94.573-42.427-94.573-94.577C15.003,57.427,57.428,15,109.576,15z"></path>
                        <path d="M94.861,156.507c2.929,2.928,7.678,2.927,10.606,0c2.93-2.93,2.93-7.678-0.001-10.608l-28.82-28.819l83.457-0.008 c4.142-0.001,7.499-3.358,7.499-7.502c-0.001-4.142-3.358-7.498-7.5-7.498l-83.46,0.008l28.827-28.825 c2.929-2.929,2.929-7.679,0-10.607c-1.465-1.464-3.384-2.197-5.304-2.197c-1.919,0-3.838,0.733-5.303,2.196l-41.629,41.628 c-1.407,1.406-2.197,3.313-2.197,5.303c0.001,1.99,0.791,3.896,2.198,5.305L94.861,156.507z"></path>
                    </g>
                </svg>
                <span class="text-lg font-bold text-gray-700">Beranda</span>
            </a>
            <button id="menu-toggle" class="md:hidden focus:outline-none">
                <span class="material-icons">menu</span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-extrabold text-blue-600">Daftar Rumah Kos</h1>
            <a href="create.php" class="bg-orange-600 text-white px-4 py-2 rounded-full hover:bg-orange-700 transition">Tambah Data Kos</a>
        </div>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full text-sm text-left border border-gray-200">
                <thead class="bg-gradient-to-r from-blue-400 to-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-3 border">ID</th>
                        <th class="px-4 py-3 border">Universitas</th>
                        <th class="px-4 py-3 border">Nama Kos</th>
                        <th class="px-4 py-3 border">Jenis Kos</th>
                        <th class="px-4 py-3 border">Tipe Kos</th>
                        <th class="px-4 py-3 border">Deskripsi</th>
                        <th class="px-4 py-3 border">Harga (Rp)</th>
                        <th class="px-4 py-3 border">Fasilitas</th>
                        <th class="px-4 py-3 border">WhatsApp</th>
                        <th class="px-4 py-3 border">Alamat</th>
                        <th class="px-4 py-3 border">Provinsi</th>
                        <th class="px-4 py-3 border">Kota</th>
                        <th class="px-4 py-3 border">Kecamatan</th>
                        <th class="px-4 py-3 border">Jarak (km)</th>
                        <th class="px-4 py-3 border">Latitude</th>
                        <th class="px-4 py-3 border">Longitude</th>
                        <th class="px-4 py-3 border">Foto</th>
                        <th class="px-4 py-3 border">Foto Tambahan</th>
                        <th class="px-4 py-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-blue-100 transition-all duration-200">
                            <td class="px-4 py-3 border text-center"><?php echo $row['id']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['universitas']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['nama_kos']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['jenis_kos']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['durasi_sewa']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['deskripsi']; ?></td>
                            <td class="px-4 py-3 border">Rp<?php echo$row['harga'], 0, ',', '.'; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['fasilitas']; ?></td>
                            <td class="px-4 py-3 border">+62<?php echo $row['no_telepon']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['alamat']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['provinsi']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['kota']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['kecamatan']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['jarak']; ?> km</td>
                            <td class="px-4 py-3 border"><?php echo $row['latitude']; ?></td>
                            <td class="px-4 py-3 border"><?php echo $row['longitude']; ?></td>
                            <td class="px-4 py-3 border">
                                <img src="<?php echo $row['gambar_url']; ?>" alt="Foto Kos" class="w-20 h-20 object-cover rounded-lg shadow-md">
                            </td>
                            <td class="px-4 py-3 border">
                                <?php $paths = explode(',', $row['gambar_tambahan']); ?>
                                <div class="flex space-x-1">
                                    <?php foreach ($paths as $path): ?>
                                        <img src="<?php echo htmlspecialchars($path); ?>" alt="Foto Tambahan" class="w-10 h-10 object-cover rounded-lg shadow-md">
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td class="px-4 py-3 border text-center">
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:underline">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="text-red-600 hover:underline ml-2">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>