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
    $fasilitas = $_POST['fasilitas'];
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
    $fasilitas = mysqli_real_escape_string($conn, $fasilitas);

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

        // Cek ukuran file (misal, maksimal 5MB)
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



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="../src/output.css">


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


</head>

<style>
    /* body * {
            border: 1px solid red;
        } */
</style>

<body>
    <div class="container max-w-4xl mx-auto shadow-lg bg-white p-8 rounded-xl mt-8">
        <h2 class="text-center font-bold text-3xl text-gray-800 mb-8">Form Input Data Kos</h2>
        <form action="save.php" method="post" enctype="multipart/form-data" class="grid grid-cols-2 gap-6">
            <div class="flex flex-col space-y-3">
                <div class="flex flex-col  ">
                    <label for="universitas" class="font-semibold   mb-2">Universitas:</label>
                    <select name="universitas" id="universitas" required class="border border-gray-300 rounded-md p-2">
                        <option value="UNIVERSITAS MALIKUSSALEH">UNIVERSITAS MALIKUSSALEH</option>
                        <option value="POLTEK">POLTEK LHOKSEUMAWE</option>
                        <option value="STIE LHOKSEUMAWE">STIE LHOKSEUMAWE</option>
                        <option value="STIAN LHOKSEUMAWE">STIAN LHOKSEUMAWE</option>
                        <option value="UNIVERSITAS BUMI PERSADA">UNIVERSITAS BUMI PERSADA</option>
                        <option value="INSTITUT AGAMA ISLAM NEGERI LHOKSEUMAWE">INSTITUT AGAMA ISLAM NEGERI LHOKSEUMAWE
                        </option>
                        <option value="UNIVERSITAS ISLAM KEBANGSAAN INDONESIA">UNIVERSITAS ISLAM KEBANGSAAN INDONESIA
                        </option>
                        <option value="STIKKES DARUSSALAM LHOKSEUMAWE">STIKKES DARUSSALAM LHOKSEUMAWE</option>
                        <option value="STIKKES MUHAMMADIYAH LHOKSEUMAWE">STIKKES MUHAMMADIYAH LHOKSEUMAWE</option>
                        <option value="SEKOLAH TINGGI ILMU HUKUM AL-BANNA">SEKOLAH TINGGI ILMU HUKUM AL-BANNA</option>
                        <option value="STIKES GETSEMPANA LHOKSUKON">STIKES GETSEMPANA LHOKSUKON</option>
                        <option value="STAI JAMIATUT TARBIYAH LHOKSUKON">STAI JAMIATUT TARBIYAH LHOKSUKON</option>
                    </select>
                </div>
                <div class="flex flex-col  ">
                    <label for="nama_kos" class="font-semibold   mb-2">Nama Kos*</label>
                    <input type="text" name="nama_kos" id="nama_kos" required
                        class="border border-gray-300 rounded-md p-2">
                </div>
                <div class="flex flex-col  ">
                    <label for="durasi_sewa" class="font-semibold   mb-2">Tipe Kos:</label>
                    <select name="durasi_sewa" id="durasi_sewa" required class="border border-gray-300 rounded-md p-2">
                        <option value="Bulanan">Bulanan</option>
                        <option value="Tahunan">Tahunan</option>
                    </select>
                </div>
                <div class="flex flex-col  ">
                    <label for="alamat" class="font-semibold   mb-2">Alamat:</label>
                    <input type="text" name="alamat" id="alamat" required class="border border-gray-300 rounded-md p-2">
                </div>
                <div class="flex flex-col sm:grid sm:grid-cols-3 gap-2   ">
                    <div class="flex flex-col">
                        <label for="provinsi" class="font-semibold   mb-2">Provinsi:</label>
                        <select name="provinsi" id="provinsi" required class="border border-gray-300 rounded-md p-2">
                            <option value="Aceh">Aceh</option>
                        </select>
                    </div>

                    <div class="flex flex-col  ">
                        <label for="kota" class="font-semibold   mb-2">Kota/Kab:</label>
                        <select name="kota" id="kota" required class="border border-gray-300 rounded-md p-2">
                            <option value="Lhokseumawe">Lhokseumawe</option>
                            <option value="Aceh Utara">Aceh Utara</option>
                        </select>
                    </div>

                    <div class="flex flex-col  ">
                        <label for="kecamatan" class="font-semibold   mb-2">Kecamatan:</label>
                        <select name="kecamatan" id="kecamatan" required class="border border-gray-300 rounded-md p-2">
                            <option value="Banda Sakti">Banda Sakti</option>
                            <option value="Muara Satu">Muara Satu</option>
                            <option value="Muara Dua">Muara Dua</option>
                            <option value="Blang Mangat">Blang Mangat</option>
                            <option value="Tanah Pasir">Tanah Pasir</option>
                            <option value="Dewantara">Dewantara</option>
                            <option value="Muara Batu">Muara Batu</option>
                            <option value="Lhoksukon">Lhoksukon</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col mt-6  ">
                    <label for="marker" class="font-semibold   mb-2">Geser Marker Sesuai Posisi Kos:</label>
                    <div id="map" class="w-full h-96 border border-gray-300 rounded-md"></div>
                </div>
            </div>
            <div class="flex flex-col space-y-3">
                <div class="flex flex-col  ">
                    <label for="jenis_kos" class="font-semibold   mb-2">Jenis Kos:</label>
                    <select name="jenis_kos" id="jenis_kos" required class="border border-gray-300 rounded-md p-2">
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                </div>
                <div class="flex flex-col  ">
                    <label for="harga" class="font-semibold   mb-2">Harga:</label>
                    <input name="harga" id="harga" class="border border-gray-300 rounded-md p-2"></input>
                </div>
                <div class="flex flex-col  ">
                    <label for="deskripsi" class="font-semibold   mb-2">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="border border-gray-300 rounded-md p-2"></textarea>
                </div>
                <!-- Input Fasilitas -->
                <div class="flex flex-col mb-6">
                    <label for="fasilitas" class="font-semibold mb-2">Fasilitas:</label>
                    <div class="flex space-x-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Wifi" class="mr-2">WiFi
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Non Wifi" class="mr-2">Non WiFi
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Ac" class="mr-2">AC
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Kipas" class="mr-2">Kipas
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Parkir" class="mr-2">Parkir
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Kamar Mandi Indor" class="mr-2">Kamar Mandi
                            Inroom
                        </label>
                    </div>
                </div>
                <div class="flex flex-col mb-6">
                    <label for="fasilitas" class="font-semibold mb-2"></label>
                    <div class="flex space-x-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Kamar Mandi Outdor" class="mr-2">Kamar
                            Mandi Outroom
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Air Jernih Bersih" class="mr-2">Jernih Bersih
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Air Jernih Berkapur" class="mr-2">Jernih Berkapur
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Dapur Bersama" class="mr-2">Dapur Bersama
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fasilitas[]" value="Dapur Pribadi" class="mr-2">Dapur Pribadi
                        </label>


                    </div>
                </div>
                <div class="flex flex-col">
                    <label for="no_telepon" class="font-semibold   mb-2">Nomor WhatsApp:</label>
                    <input type="text" name="no_telepon" id="no_telepon"
                        class="border border-gray-300 rounded-md p-2 mb-4">
                </div>

                <div class="flex flex-col ">
                    <div class=" ">
                        <img id="imagePreview" src="" alt=" " class="hidden w-40   object-cover  rounded-md" />
                    </div>
                    <label for="foto" class="font-semibold   mb-2">Foto Kos:</label>
                    <input type="file" name="foto" id="foto" accept=".jpg, .jpeg, .png" required
                        class="border border-gray-300 rounded-md p-2" onchange="previewImage(event)">
                </div>
                <!-- Input Gambar Tambahan -->
                <div class="flex flex-col mb-6">
                    <div class=" ">
                        <img id="imagePreview1" src="" alt=" " class="hidden w-40   object-cover  rounded-md" />
                    </div>
                    <label class="font-semibold mb-2">Gambar Tambahan:</label>
                    <div id="gambar-tambahan-container" class="space-y-3">
                        <div class="flex items-center">
                            <input type="file" name="gambar_tambahan[]" accept=".jpg, .jpeg, .png"
                                class="border border-gray-300 rounded-md p-2">
                        </div>
                    </div>
                    <button type="button" id="tambah-gambar" class="mt-3 text-blue-500 hover:underline">
                        + Tambah Gambar
                    </button>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const container = document.getElementById("gambar-tambahan-container");
                        const tambahGambarButton = document.getElementById("tambah-gambar");

                        // Fungsi untuk membuat elemen pratinjau
                        function buatPreviewGambar(input) {
                            const reader = new FileReader();
                            const wrapper = document.createElement("div");
                            wrapper.className = "flex items-center space-x-3";

                            const image = document.createElement("img");
                            image.className = "w-40 object-cover rounded-md";

                            const deleteButton = document.createElement("button");
                            deleteButton.textContent = "Hapus";
                            deleteButton.type = "button";
                            deleteButton.className = "text-red-500 hover:underline";

                            deleteButton.addEventListener("click", function () {
                                wrapper.remove(); // Hapus elemen wrapper
                            });

                            reader.onload = function (e) {
                                image.src = e.target.result; // Atur sumber gambar
                            };

                            reader.readAsDataURL(input.files[0]); // Baca file sebagai URL data

                            wrapper.appendChild(image);
                            wrapper.appendChild(deleteButton);
                            container.appendChild(wrapper);
                        }

                        // Tambahkan event listener ke setiap input file
                        container.addEventListener("change", function (event) {
                            if (event.target.type === "file" && event.target.files[0]) {
                                buatPreviewGambar(event.target);
                            }
                        });

                        // Tambahkan input file baru saat tombol tambah gambar diklik
                        tambahGambarButton.addEventListener("click", function () {
                            const newInputWrapper = document.createElement("div");
                            newInputWrapper.className = "flex items-center space-x-3";

                            const newInput = document.createElement("input");
                            newInput.type = "file";
                            newInput.name = "gambar_tambahan[]";
                            newInput.accept = ".jpg, .jpeg, .png";
                            newInput.className = "border border-gray-300 rounded-md p-2";

                            const deleteButton = document.createElement("button");
                            deleteButton.textContent = "Hapus";
                            deleteButton.type = "button";
                            deleteButton.className = "text-red-500 hover:underline";

                            deleteButton.addEventListener("click", function () {
                                newInputWrapper.remove(); // Hapus elemen input wrapper
                            });

                            newInputWrapper.appendChild(newInput);
                            newInputWrapper.appendChild(deleteButton);
                            container.appendChild(newInputWrapper);
                        });
                    });
                </script>


                <div class="flex flex-col mt-4 gap-4">
                    <div class="flex flex-col mr-6 ">
                        <label for="latitude" class="font-semibold   mb-2">Latitude:</label>
                        <input type="number" id="latitude" step="any" name="latitude" required
                            class="border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="flex flex-col mr-6">
                        <label for="longitude" class="font-semibold   mb-2">Longitude:</label>
                        <input type="number" id="longitude" step="any" name="longitude" required
                            class="border border-gray-300 rounded-md p-2">
                    </div>
                    <div class="flex flex-col mr-6">
                        <label for="google_maps_link" class="font-semibold mb-2">Google Maps Link:</label>
                        <input type="text" id="google_maps_link" name="google_maps_link"
                            class="border border-gray-300 rounded-md p-2 bg-gray-100">
                    </div>
                </div>
            </div>


            <script>
                function previewImage(event) {
                    const file = event.target.files[0];
                    const reader = new FileReader();

                    reader.onload = function () {
                        const imagePreview = document.getElementById('imagePreview');
                        imagePreview.src = reader.result;
                        imagePreview.classList.remove('hidden');
                    }

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                }
            </script>



            <script>
                // Fungsi untuk memperbarui Google Maps Link
                function updateGoogleMapsLink() {
                    const lat = document.getElementById('latitude').value;
                    const lng = document.getElementById('longitude').value;
                    const googleMapsLink = `https://www.google.com/maps?q=${lat},${lng}`;

                    // Memperbarui input Google Maps Link
                    document.getElementById('google_maps_link').value = googleMapsLink;
                }

                // Menambahkan event listener ke latitude dan longitude untuk update link otomatis
                document.getElementById('latitude').addEventListener('input', updateGoogleMapsLink);
                document.getElementById('longitude').addEventListener('input', updateGoogleMapsLink);

                // Initialize Map dan marker
                let map;
                let marker;

                function initializeMap() {
                    const initialCoords = [5.18036, 97.14472];
                    map = L.map('map').setView(initialCoords, 13);

                    // Tile Layer
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    // Menambahkan marker dan memperbarui koordinat saat peta diklik
                    map.on('click', function (e) {
                        const { lat, lng } = e.latlng;

                        // Jika marker sudah ada, pindahkan
                        if (marker) {
                            marker.setLatLng([lat, lng]);
                        } else {
                            // Tambahkan marker baru
                            marker = L.marker([lat, lng]).addTo(map);
                        }

                        // Update input latitude dan longitude
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;

                        // Update Google Maps Link
                        updateGoogleMapsLink();
                    });

                    // Perbarui Google Maps Link setiap marker bergerak
                    map.on('moveend', function () {
                        const markerPosition = marker.getLatLng();
                        const googleMapsLink = `https://www.google.com/maps?q=${markerPosition.lat},${markerPosition.lng}`;
                        document.getElementById('google_maps_link').value = googleMapsLink;
                    });
                }

                // Panggil initializeMap saat halaman dimuat
                window.onload = initializeMap;

            </script>

            <select name="jarakuniversitas" id="jarakuniversitas" required class="border border-gray-300 rounded-md p-2"
                onchange="updateDistance()">
                <option value="1" data-lat="5.234752" data-lng="96.987710">UNIVERSITAS MALIKUSSALEH</option>
                <option value="2" data-lat="5.12066" data-lng="97.15857">POLTEK LHOKSEUMAWE</option>
                <option value="3" data-lat="5.18014" data-lng="97.13316">STIE LHOKSEUMAWE</option>
                <option value="4" data-lat="5.18009" data-lng="97.13343">STIA LHOKSEUMAWE</option>
                <option value="5" data-lat="5.13270" data-lng="97.15147">UNIVERSITAS BUMI PERSADA</option>
                <option value="6" data-lat="5.12765" data-lng="97.15336">INSTITUT AGAMA ISLAM NEGERI LHOKSEUMAWE
                </option>
                <option value="7" data-lat="5.12967" data-lng="97.15237">UNIVERSITAS ISLAM KEBANGSAAN INDONESIA</option>
                <option value="8" data-lat="5.18177" data-lng="97.15288">STIKKES DARUSSALAM LHOKSEUMAWE</option>
                <option value="9" data-lat="5.18925" data-lng="97.14666">STIKKES MUHAMMADIYAH LHOKSEUMAWE</option>
                <option value="10" data-lat="5.16520" data-lng="97.10643">SEKOLAH TINGGI ILMU HUKUM AL-BANNA</option>
                <option value="11" data-lat="5.10395" data-lng="97.29120">STIKES GETSEMPANA LHOKSUKON</option>
                <option value="12" data-lat="5.07383" data-lng="97.34294">STAI JAMIATUT TARBIYAH LHOKSUKON</option>


                <!-- Tambahkan universitas lainnya -->
            </select>
            <script>
                function calculateDistance(lat1, lon1, lat2, lon2) {
                    const R = 6371; // Radius bumi dalam km
                    const dLat = (lat2 - lat1) * Math.PI / 180;
                    const dLon = (lon2 - lon1) * Math.PI / 180;
                    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    return R * c; // Jarak dalam km
                }

                function updateDistance() {
                    const universitas = document.getElementById('jarakuniversitas');
                    const selectedOption = jarakuniversitas.options[jarakuniversitas.selectedIndex];
                    const latUniv = parseFloat(selectedOption.getAttribute('data-lat'));
                    const lngUniv = parseFloat(selectedOption.getAttribute('data-lng'));

                    const latKos = parseFloat(document.getElementById('latitude').value);
                    const lngKos = parseFloat(document.getElementById('longitude').value);

                    if (!isNaN(latUniv) && !isNaN(lngUniv) && !isNaN(latKos) && !isNaN(lngKos)) {
                        const distance = calculateDistance(latUniv, lngUniv, latKos, lngKos);
                        document.getElementById('jarak').value = distance.toFixed(2);
                    }
                }

                // Update jarak otomatis setiap koordinat berubah
                document.getElementById('latitude').addEventListener('input', updateDistance);
                document.getElementById('longitude').addEventListener('input', updateDistance);
                document.getElementById('jarakuniversitas').addEventListener('change', updateDistance);

            </script>


            <div class="flex flex-col">
                <label for="jarak" class="font-semibold mb-2">Jarak dari Universitas (km):</label>
                <input type="number" step="0.01" name="jarak" id="jarak" class="border border-gray-300 rounded-md p-2">
            </div>

            <div class=""></div>
            <div class="flex justify-center  col-span-2 w-full">
                <button type="submit"
                    class="bg-orange-500 w-full text-white font-semibold py-2 px-6 rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">Simpan</button>
            </div>

        </form>

    </div>

</body>

</html>