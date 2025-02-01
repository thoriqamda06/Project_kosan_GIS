<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'universitas'); // Ganti dengan database yang sesuai

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

 
 

// Ambil ID kosan dari URL
$id = intval($_GET['id']); // Pastikan ID adalah angka untuk keamanan

// Query data kosan berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM kosan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$kosan = $result->fetch_assoc();

// Tampilkan data kosan jika tersedia
if ($kosan): 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kos</title>
    <link href="../src/output.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
         /* body * {
            border: 1px solid red;
        } */
    </style>
</head>
<body class="   w-full font-montserrat">
    <section class="w-full">
        <nav class="w-full  flex justify-between ">
            <img src="../src/img/awakkoss.png" alt="awakkos" class="w-48">
                <ul class="flex flex-row justify-items-start gap-6 items-center">
                                    <li href="javascript:void(0)" class="relative group">
                                        <a href="../pages/index.php" class="font-semibold text-base duration-500">
                                            HOME
                                        </a>
                                        <div class="absolute left-0 w-0 duration-500 group-hover:w-full h-1 bg-orange-500">
                                        </div>
                                    </li>
                                    <li href="javascript:void(0)" class="relative group">
                                        <a href="semua_kos.php" class="font-semibold  text-base duration-500">
                                            CARI KOS
                                        </a>
                                        <div class="absolute   left-0 w-0 duration-500 group-hover:w-full h-1 bg-orange-500">
                                        </div>
                                    </li>                    
                                                 
                                    <li href="javascript:void(0)" class="relative group">
                                        <a href="kontak.php" class="font-semibold  text-base duration-500">
                                            KONTAK
                                        </a>
                                        <div class="absolute   left-0 w-0 duration-500 group-hover:w-full h-1 bg-orange-500">
                                        </div>
                                    </li>                    
                </ul>
            <div>
                <a href="../login.php">
                <button class="py-2 px-4 m-2 rounded-full border-2 font-semibold border-blue-300 bg-orange-500 hover:bg-orange-600 ">Masuk</button>

                </a>
            </div>
        </nav>
    </section>
    <section class="   px-8   ">
        <div class="bg-gray-200 rounded-xl  px-12 py-8">
            <div class="grid grid-cols-3 space-x-8">
                <div class="w-96">
                    <img id="mainImage" src="../uploads/<?= htmlspecialchars($kosan['gambar_url']) ?>" alt="Foto Kosan" class="w-full h-80 object-cover rounded-md border-2 border-gray-500 mb-4">
                    <div class="flex space-x-2 mt-4">
                        <?php
                        $gambarTambahan = explode(',', $kosan['gambar_tambahan']); 
                        foreach ($gambarTambahan as $gambar):
                        ?>
                        <img src="../uploads/<?= htmlspecialchars(trim($gambar)) ?>" alt="Thumbnail" class="w-16 h-16 object-cover rounded-md cursor-pointer border-2 border-gray-500 hover:ring-2 hover:ring-orange-500" onclick="changeMainImage(this)">
                        <?php endforeach; ?>
                    </div>
                    <script>
                        function changeMainImage(thumbnail) {
                            const mainImage = document.getElementById('mainImage');
                            mainImage.src = thumbnail.src;
                        }
                    </script>
                </div>
                <div class="flex flex-col w-96 ">
                    <div>
                        <h1 class="text-3xl font-bold "> <?= htmlspecialchars($kosan['nama_kos']) ?></h1>
                    </div>
                    <div>
                        <p class=" font-bold text-lg mt-4">Harga: Rp <?= $kosan['harga'], 0, ',', '.'?> / Tahun</p>
                        <p><span class="font-bold text-gray-500">Dekat Dengan:</span> <?= htmlspecialchars($kosan['universitas']) ?></p>
                        <p class="text-gray-800 font-medium my-4"><?= htmlspecialchars($kosan['deskripsi']) ?></p>
                    </div>
                    <div class="mt-4">
                        <div class="flex flex-row w-full gap-4 justify-evenly px-8 py-2 border-y border-gray-500">
                            <div id="detailTab" class="cursor-pointer">
                                <h2>Detail</h2>
                            </div>
                            <div id="fasilitasTab" class="cursor-pointer">
                                <h2>Fasilitas</h2>
                            </div>
                        </div>
                        <div id="detailkos" class=" mt-4 space-y-[4px]">
                            
                            <p><span class="font-bold text-gray-500">Jenis Kos:</span> <?= htmlspecialchars($kosan['jenis_kos']) ?></p>
                            <p><span class="font-bold text-gray-500">Durasi Sewa:</span> <?= htmlspecialchars($kosan['durasi_sewa']) ?></p>
                            <p><span class="font-bold text-gray-500">Alamat:</span> <?= htmlspecialchars($kosan['alamat']) ?></p>
                            <p><span class="font-bold text-gray-500">Jarak dari Universitas: </span> <?= htmlspecialchars($kosan['jarak']) ?> km</p>
                            <p class="text-sm ">
                                <span class="font-semibold text-gray-800"> Kecamatan:</span> <?= htmlspecialchars($kosan['kecamatan']) ?>, <span class="font-semibold text-gray-800"> Kota: </span><?= htmlspecialchars($kosan['kota']) ?>,<span class="font-semibold text-gray-800"> Provinsi:</span> <?= htmlspecialchars($kosan['provinsi']) ?>
                            </p>
                        </div>
                        <div id="fasilitaskos" class="hidden mt-4">
                            <ul class="">
                                <?php
                                // Ubah string fasilitas menjadi array
                                $fasilitasArray = array_filter(array_map('trim', explode(',', $kosan['fasilitas'])));

                                // Cek apakah fasilitasArray kosong
                                if (!empty($fasilitasArray)) {
                                    // Loop melalui array fasilitas dan tampilkan sebagai list dengan SVG
                                    foreach ($fasilitasArray as $fasilitas) {
                                        echo '<li class="flex items-center mb-2">';
                                        // Tambahkan SVG di sebelah kiri teks
                                        echo '<svg class="w-5 h-5 text-blue-500 mr-2" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <defs>
                                                        <style>
                                                            .cls-1 { fill: none; }
                                                            .cls-2 { fill: #bdeeff; }
                                                            .cls-3 { fill: #02a0e1; }
                                                            .cls-4 { fill: #ffffff; }
                                                        </style>
                                                    </defs>
                                                    <rect class="cls-1" height="32" id="wrapper" width="32" x="0.05"></rect>
                                                    <circle class="cls-2" cx="16.05" cy="15.59" r="13.72"></circle>
                                                    <path class="cls-3" d="M16.05,30.31A14.72,14.72,0,1,1,30.77,15.59,14.74,14.74,0,0,1,16.05,30.31Zm0-27.43A12.72,12.72,0,1,0,28.77,15.59,12.73,12.73,0,0,0,16.05,2.88Z"></path>
                                                    <circle class="cls-4" cx="16.05" cy="15.59" r="9.82"></circle>
                                                    <path class="cls-3" d="M16.05,26.41A10.82,10.82,0,1,1,26.87,15.59,10.83,10.83,0,0,1,16.05,26.41Zm0-19.64a8.82,8.82,0,1,0,8.82,8.82A8.83,8.83,0,0,0,16.05,6.77Z"></path>
                                                    <path class="cls-3" d="M14.43,19.69a1,1,0,0,1-.61-.22l-2.88-2.25a1,1,0,1,1,1.23-1.57l2.18,1.7,5.49-5.56a1,1,0,0,1,1.42,1.41l-6.12,6.19A1,1,0,0,1,14.43,19.69Z"></path>
                                                </g>
                                            </svg>';
                                        // Tampilkan teks fasilitas
                                        echo '<span class="text-gray-700">' . htmlspecialchars($fasilitas) . '</span>';
                                        echo '</li>';
                                    }
                                } else {
                                    echo '<li class="text-gray-500">Tidak ada fasilitas yang tersedia.</li>';
                                }
                                ?>
                            </ul>
                        </div>


                    </div>

                    <script>
                        // Ambil elemen yang diperlukan
                        const detailTab = document.getElementById('detailTab');
                        const fasilitasTab = document.getElementById('fasilitasTab');
                        const detailKos = document.getElementById('detailkos');
                        const fasilitasKos = document.getElementById('fasilitaskos');

                        // Fungsi untuk menampilkan bagian Detail
                        function showDetail() {
                            detailKos.classList.remove('hidden');
                            fasilitasKos.classList.add('hidden');
                            detailTab.classList.add('font-bold', 'text-orange-600');
                            fasilitasTab.classList.remove('font-bold', 'text-orange-600');
                        }

                        // Fungsi untuk menampilkan bagian Fasilitas
                        function showFasilitas() {
                            fasilitasKos.classList.remove('hidden');
                            detailKos.classList.add('hidden');
                            fasilitasTab.classList.add('font-bold', 'text-orange-600');
                            detailTab.classList.remove('font-bold', 'text-orange-600');
                        }

                        // Tambahkan event listener
                        detailTab.addEventListener('click', showDetail);
                        fasilitasTab.addEventListener('click', showFasilitas);

                        // Default: Tampilkan bagian Detail saat pertama kali dimuat
                        showDetail();
                    </script>
                </div>
                
                <div class="w-68 h-96 rounded-xl border-2 border-gray-300 shadow-md bg-white overflow-hidden relative left-[24px] ">
                    <!-- Bagian Atas -->
                    <div class="relative bg-orange-500 h-12 flex items-center justify-center">
                        <p class="absolute   text-white font-bold text-lg">Lokasi Kos</p>
                    </div>
                    <div class="border-2 border-blue-400 m-1 rounded-xl h-48">
                        <div id="map" class="w-full h-full"></div>
                        
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            // Ambil latitude dan longitude dari PHP
                            const latitude = <?= json_encode($kosan['latitude']); ?>;
                            const longitude = <?= json_encode($kosan['longitude']); ?>;

                            // Inisialisasi peta
                            const map = L.map('map').setView([latitude, longitude], 13);

                            // Tambahkan tile layer dari OpenStreetMap
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);

                            // Tambahkan marker pada lokasi
                            L.marker([latitude, longitude]).addTo(map)
                                .bindPopup("Lokasi Kos")
                                .openPopup();
                        });
                    </script>

                    <!-- Konten Tengah -->
                    <div class="p-2">
                        <a href="<?= htmlspecialchars($kosan['google_maps_link']) ?>" target="_blank" class="flex flex-col items-center text-blue-500 font-semibold ">
                            <p class="text-gray-700 text-xs mb-2">
                                Klik untuk melihat lokasi kos di Google Maps.
                            </p>
                            <div class="flex flex-row items-center gap-2 hover:underline">
                                <svg fill="#000000" width="30px" height="30px" viewBox="0 0 24 24" id="maps-location" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path id="secondary" d="M19.32,9.84a1,1,0,0,0-1-.84H15.69A16.41,16.41,0,0,1,12,15,16.41,16.41,0,0,1,8.31,9H5.67a1,1,0,0,0-1,.84L3,19.84A1,1,0,0,0,4,21H20a1,1,0,0,0,1-1.16Z" style="fill: #2ca9bc; stroke-width: 2;"></path><path id="primary" d="M16,9h2.33a1,1,0,0,1,1,.84l1.67,10A1,1,0,0,1,20,21H4a1,1,0,0,1-1-1.16l1.67-10a1,1,0,0,1,1-.84H8" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M16,7A4,4,0,0,0,8,7c0,4,4,8,4,8S16,11,16,7Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></g></svg>
                                Lihat di Google Maps
                            </div>
                            
                        </a>
                    </div>

                    <!-- Separator -->
                    <div class="border-t border-gray-300"></div>

                    <!-- Bagian Bawah -->
                    <div class="p-2 flex flex-col items-center">
                        <button class="w-full py-2 mb-2 bg-green-600 rounded-lg text-white font-semibold shadow hover:bg-green-700 transition">
                            Hubungi Kos
                        </button>
                        
                    </div>
                </div>

                    
            </div>
        </div>
        

    </section >
    <section class=" px-8">
        <div class="bg-gray-200 rounded-xl px-16 py-8 mt-12">
            <h2 class="text-2xl font-bold mb-6">Kosan Lain di Sekitar <?= htmlspecialchars($kosan['universitas']) ?></h2>
            
            <!-- Tombol untuk mengatur urutan -->
            <div class="flex justify-end mb-4">
                <form method="get" class="inline-block">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($kosan['id']) ?>">
                    <input type="hidden" name="order" value="asc">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2 hover:bg-blue-600">Terdekat</button>
                </form>
                <form method="get" class="inline-block">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($kosan['id']) ?>">
                    <input type="hidden" name="order" value="desc">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Terjauh</button>
                </form>
            </div>

            <div id="kosan-list" class="grid grid-cols-3 gap-6">
                <?php
                // Ambil data kosan lain di universitas yang sama
                $universitas = $kosan['universitas'];
                $order = $_GET['order'] ?? ''; // Ambil parameter 'order' dari URL

                $query = "SELECT id, nama_kos, deskripsi, harga, alamat, gambar_url, fasilitas, jarak FROM kosan WHERE universitas = ? AND id != ?";
                if (in_array($order, ['asc', 'desc'])) {
                    $query .= " ORDER BY jarak " . strtoupper($order);
                }

                $stmt = $conn->prepare($query);
                $stmt->bind_param('si', $universitas, $kosan['id']);
                $stmt->execute();
                $result = $stmt->get_result();

                // Tampilkan data kosan
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="w-full bg-white rounded-lg shadow-md p-4">
                        <a href="detail_kos.php?id=<?= $row['id'] ?>">
                            <img src="../uploads/<?= htmlspecialchars($row['gambar_url']) ?>" alt="<?= htmlspecialchars($row['nama_kos']) ?>" class="w-full h-48 object-cover rounded-md mb-4">
                            <h3 class="text-lg font-bold mb-2"><?= htmlspecialchars($row['nama_kos']) ?></h3>
                            <p class="text-gray-700 text-sm mb-2"><?= htmlspecialchars($row['deskripsi']) ?></p>
                            <p class="font-bold text-orange-600">Rp <?= number_format($row['harga'], 0, ',', '.') ?> / Tahun</p>
                            <p class="text-gray-500 text-sm mb-4"><?= htmlspecialchars($row['alamat']) ?></p>
                            <p class="text-sm font-bold text-gray-700">Jarak: <?= htmlspecialchars($row['jarak']) ?> km</p>
                            <div>
                                <h4 class="text-sm font-bold text-gray-600 mb-2">Fasilitas:</h4>
                                <ul class="text-gray-700 text-sm list-disc pl-5">
                                    <?php
                                    // Ubah string fasilitas menjadi array
                                    $fasilitasArray = array_filter(array_map('trim', explode(',', $row['fasilitas'])));
                                    if (!empty($fasilitasArray)) {
                                        foreach ($fasilitasArray as $fasilitas) {
                                            echo '<li>' . htmlspecialchars($fasilitas) . '</li>';
                                        }
                                    } else {
                                        echo '<li>Tidak ada fasilitas yang tersedia.</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </a>
                    </div>
                    <?php
                }

                // Tutup statement
                $stmt->close();
                ?>
            </div>
        </div>
        
    </section>

    


    <hr class="w-4/5 h-1 bg-orange-500 mx-auto mt-10">
    <hr class="w-3/5 h-1 bg-orange-500 mx-auto mt-2 ">

     
    <script>
        // Simpan posisi scroll sebelum reload
        window.addEventListener('beforeunload', function () {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        // Ambil posisi scroll setelah halaman dimuat ulang
        window.addEventListener('load', function () {
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition, 10));
                localStorage.removeItem('scrollPosition'); // Hapus data setelah digunakan
            }
        });
    </script>

      <!-- Footer -->
      <footer class="bg-orange-700 text-white pt-12">
         <div class="container mx-auto px-4 md:px-8">
             <!-- Platform Info Section -->
             <div class="mb-8">
                 <h1 class="text-4xl font-bold text-center mb-4">AWAK KOS</h1>
                 <p class="  leading-relaxed mb-4 text-center">
                     Awak Kos adalah sebuah platform yang menyajikan informasi mengenai properti kos yang disewakan di daerah Kota Lhokseumawe dan Aceh Utara yang berada di sekitaran kampus negeri maupun swasta dilengkapi dengan jarak terdekat harga kos, fasilitas kos dan gambar kos yang diunggah langsung oleh developer. Platform kami memberikan kemudahan bagi kamu yang mencari info kos terdekat di sekitaran kampus yang kamu inginkan.
                 </p>
                 <p class="  leading-relaxed text-center">
                     Informasi kos yang disewakan juga langsung diberikan oleh pemilik, yang pastinya sudah terakurasi kebenarannya oleh developer. Kemudahan juga pastinya diberikan tidak hanya kepada pencari kos, tapi juga kepada pihak pemilik kos-kosan untuk dapat memasang informasi kos yang disewakan. Dengan adanya Awak Kos, transaksi antara pemilik dan penyewa dijamin lebih cepat dan mudah. Kami selalu berusaha dengan baik untuk dapat memberikan informasi mengenai kos-kosan dari seluruh daerah Universitas yang ada di Kota Lhokseumawe dan Aceh Utara.
                 </p>
             </div>

             <!-- Social Links Section -->
             <div class="text-center border-t border-gray-100 pb-4">
                 <p class="text-lg text-gray-200 my-2">Cari Kos Terdekat Cepat & Mudah Kunjungi Awak Kos</p>
                 <div class="flex justify-center space-x-6">
                     <a href="https://www.instagram.com/althoriqamda_" target="_blank" class="text-white hover:text-pink-600 transition-colors">
                         <i class="fab fa-instagram text-3xl"></i>
                     </a>
                     <a href="https://wa.me/6285214970768" target="_blank" class="text-white hover:text-green-500 transition-colors">
                         <i class="fab fa-whatsapp text-3xl"></i>
                     </a>
                     <a href="https://www.tiktok.com/@amda__14?_t=ZS-8rbpaALn9rE&_r=1" target="_blank" class="text-white hover:text-black transition-colors">
                         <i class="fab fa-tiktok text-3xl"></i>
                     </a>
                 </div>
             </div>
         </div>
     </footer>
</body>
</html>
<?php
endif;

 
$conn->close();
?>
