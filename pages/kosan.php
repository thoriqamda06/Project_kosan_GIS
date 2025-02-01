<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Kosan</title>
    <link href="../src/output.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body class="">
    <section class="w-full  font-montserrat">
        <nav class="w-full  flex justify-between ">
            <img src="../src/img/awakkoss.png" alt="awakkos" class="w-48">
                <ul class="flex flex-row justify-items-start gap-6 items-center">
                                    <li href="javascript:void(0)" class="relative group">
                                        <a href="index.php" class="font-semibold text-base duration-500">
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
    <section id="filtered-kosan-section" class="p-8 w-11/12 mx-auto hidden bg-gray-200 rounded-xl">
      <!-- Judul -->
      <h2 id="filtered-universitas-title" class="text-3xl font-bold text-gray-800 mb-6">
          Kosan di Sekitar <span id="filtered-universitas-name"></span>
      </h2>

      <!-- Container untuk daftar kosan -->
      <div id="filtered-kosan-list" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"></div>
      <script>
        // Fungsi untuk mendapatkan parameter dari URL
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Ambil parameter universitas dari URL
        const universitasFromUrl = getUrlParameter('universitas');

        // Jika parameter universitas ditemukan, tampilkan data yang difilter
        if (universitasFromUrl) {
            const filteredSection = document.getElementById('filtered-kosan-section');
            const filteredTitle = document.getElementById('filtered-universitas-title');
            const filteredUniversitasName = document.getElementById('filtered-universitas-name');
            const filteredKosanListContainer = document.getElementById('filtered-kosan-list');

            // Tampilkan nama universitas di judul
            filteredUniversitasName.textContent = universitasFromUrl;

            // Tampilkan section
            filteredSection.classList.remove('hidden');

            // Fetch data kosan berdasarkan universitas
            fetch('../data_kos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `universitas=${encodeURIComponent(universitasFromUrl)}`,
            })
                .then(response => response.json())
                .then(data => {
                    filteredKosanListContainer.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(kosan => {
                            filteredKosanListContainer.innerHTML += `
                                <a href="detail_kos.php?id=${kosan.id}" 
                                class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                    <img src="${kosan.gambar_url}" alt="${kosan.nama_kos}" class="w-full h-40 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold mb-2">${kosan.nama_kos}</h3>
                                        <p class="text-sm text-gray-500">${kosan.deskripsi}</p>
                                        <p class="mt-2 text-sm"><strong>Harga:</strong> Rp${new Intl.NumberFormat('id-ID').format(kosan.harga)}</p>
                                        <p class="text-sm"><strong>Alamat:</strong> ${kosan.alamat}</p>
                                        <p class="text-sm"><strong>Telepon:</strong> ${kosan.no_telepon}</p>
                                    </div>
                                </a>
                            `;
                        });
                    } else {
                        filteredKosanListContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Tidak ada data kosan untuk universitas ini.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    filteredKosanListContainer.innerHTML = '<p class="col-span-full text-center text-red-500">Terjadi kesalahan saat memuat data kosan.</p>';
                });
        }

      </script>
    </section>

    <section class="p-8 w-11/12 mt-2 mx-auto bg-gray-200 rounded-xl">
        <!-- Judul -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">
            Cari Kos Lainnya di Sekitar Kampusmu
        </h2>

        <div class="flex flex-row items-start gap-4 items-end ml-20">
            <!-- Box Filter: Universitas -->
            <div class="flex flex-col w-1/4">
                <label for="universitas" class="text-sm font-medium text-gray-700 mb-1">Universitas</label>
                <select id="universitas" class="border border-gray-300 rounded p-2 text-sm">
                    <option value="">Pilih Universitas</option>
                    <option value="UNIVERSITAS MALIKUSSALEH">UNIMAL</option>
                    <option value="POLTEK">POLTEK</option>
                    <option value="UNSYIAH">UNSYIAH</option>
                </select>
            </div>
            
            <!-- Tombol Terdekat -->
            <button id="terdekatButton" class=" border border-gray-300  w-24   px-4 py-2 rounded font-medium ">
                Terdekat
            </button>

            <!-- Tombol Terjauh -->
            <button id="terjauhButton" class=" border border-gray-300 w-24  px-4 py-2 rounded font-medium ">
                Terjauh
            </button>

            <!-- Box Filter: Jarak -->
            <div class="flex flex-col w-1/4">
                <label for="jarak" class="text-sm font-medium text-gray-700 mb-1">Jarak (km)</label>
                <input type="number" id="jarak" class="border border-gray-300 rounded p-2 text-sm" placeholder="Masukkan jarak">
            </div>

            <!-- Box Filter: Harga -->
            <div class="flex flex-col w-1/4">
                <label for="harga" class="text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                <input type="number" id="harga" class="border border-gray-300 rounded p-2 text-sm" placeholder="Masukkan harga">
            </div>

            <!-- Box Filter: Fasilitas -->
            <div class="flex flex-col w-1/4 relative">
                <label id="fasilitasLabel" class="text-sm font-medium text-gray-700 cursor-pointer">
                    Fasilitas
                    <div class="w-24 bg-white border border-gray-300 rounded-md h-9"></div>
                </label>
                <!-- Box dengan Checkbox -->
                <div id="fasilitasBox" class="hidden absolute top-6 left-0 bg-white flex flex-col gap-2 border-x border-b border-gray-300 rounded p-2 shadow-lg z-10 w-24">
                    <!-- Checkbox Wi-Fi -->
                    <label class="flex items-center">
                        <input type="checkbox" value="wifi" class="mr-2 fasilitas-checkbox">
                        Wi-Fi
                    </label>
                    <!-- Checkbox AC -->
                    <label class="flex items-center">
                        <input type="checkbox" value="ac" class="mr-2 fasilitas-checkbox">
                        AC
                    </label>
                    <!-- Checkbox Parkir -->
                    <label class="flex items-center">
                        <input type="checkbox" value="parkir" class="mr-2 fasilitas-checkbox">
                        Parkir
                    </label>
                </div>
            </div>

            <!-- Tombol Cari -->
            <button id="cariButton" class="bg-orange-500 w-24 text-white px-4 py-2 rounded font-medium hover:bg-orange-600">
                Cari
            </button>

            <!-- Tombol Reset -->
            <button id="resetButton" class="bg-gray-400 w-24 text-white px-4 py-2 rounded font-medium hover:bg-gray-500">
                Reset
            </button>
        </div>

        <div id="kosan-list" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-6"></div>

        <script>
            const fasilitasLabel = document.getElementById('fasilitasLabel');
            const fasilitasBox = document.getElementById('fasilitasBox');
            const cariButton = document.getElementById('cariButton');
            const resetButton = document.getElementById('resetButton');
            const terdekatButton = document.getElementById('terdekatButton');
            const terjauhButton = document.getElementById('terjauhButton');
            const kosanListContainer = document.getElementById('kosan-list');
            const universitasDropdown = document.getElementById('universitas');

            // Toggle fasilitas box
            fasilitasLabel.addEventListener('click', () => {
                fasilitasBox.classList.toggle('hidden');
            });

            // Fungsi untuk memastikan tombol "Terdekat" dan "Terjauh" hanya aktif jika universitas dipilih
            const updateButtonState = () => {
                const universitasSelected = universitasDropdown.value !== '';
                terdekatButton.disabled = !universitasSelected;
                terjauhButton.disabled = !universitasSelected;

                if (universitasSelected) {
                    terdekatButton.classList.remove('bg-gray-300', 'cursor-not-allowed');
                    terdekatButton.classList.add('bg-white', 'hover:bg-gray-300');
                    terjauhButton.classList.remove('bg-gray-300', 'cursor-not-allowed');
                    terjauhButton.classList.add('bg-white', 'hover:bg-gray-300');
                } else {
                    terdekatButton.classList.add('bg-gray-300', 'cursor-not-allowed');
                    terdekatButton.classList.remove('bg-green-500', 'hover:bg-green-600');
                    terjauhButton.classList.add('bg-gray-300', 'cursor-not-allowed');
                    terjauhButton.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                }
            };

            // Perbarui status tombol saat dropdown universitas berubah
            universitasDropdown.addEventListener('change', updateButtonState);

            // Fetch data berdasarkan filter
            cariButton.addEventListener('click', () => {
                const universitas = document.getElementById('universitas').value;
                const jarak = document.getElementById('jarak').value;
                const harga = document.getElementById('harga').value;

                // Ambil fasilitas yang dipilih
                const fasilitasCheckboxes = document.querySelectorAll('.fasilitas-checkbox:checked');
                const fasilitas = Array.from(fasilitasCheckboxes).map(checkbox => checkbox.value);

                // Jika tidak ada filter yang dipilih
                if (!universitas && !jarak && !harga && fasilitas.length === 0) {
                    kosanListContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Silakan pilih minimal satu filter untuk mencari kosan.</p>';
                    return;
                }

                // Kirim request ke server
                fetch('../get_filter_kos_univ.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `universitas=${encodeURIComponent(universitas)}&jarak=${encodeURIComponent(jarak)}&harga=${encodeURIComponent(harga)}&fasilitas=${encodeURIComponent(fasilitas.join(','))}`,
                })
                    .then(response => response.json())
                    .then(data => {
                        kosanListContainer.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(kosan => {
                                kosanListContainer.innerHTML += `
                                    <a href="detail_kos.php?id=${kosan.id}" 
                                    class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                        <img src="${kosan.gambar_url}" alt="${kosan.nama_kos}" class="w-full h-40 object-cover">
                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold mb-2">${kosan.nama_kos}</h3>
                                            <p class="text-sm text-gray-500">${kosan.deskripsi}</p>
                                            <p class="mt-2 text-sm"><strong>Harga:</strong> Rp${new Intl.NumberFormat('id-ID').format(kosan.harga)}</p>
                                            <p class="text-sm"><strong>Alamat:</strong> ${kosan.alamat}</p>
                                            <p class="text-sm"><strong>Telepon:</strong> ${kosan.no_telepon}</p>
                                        </div>
                                    </a>
                                `;
                            });
                        } else {
                            kosanListContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Tidak ada data kosan sesuai filter.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        kosanListContainer.innerHTML = '<p class="col-span-full text-center text-red-500">Terjadi kesalahan saat memuat data kosan.</p>';
                    });
            });

            // Fungsi untuk mendapatkan data kosan berdasarkan urutan jarak
            const fetchKosanByDistance = (order) => {
                const universitas = universitasDropdown.value;

                // Kirim request ke server
                fetch('../get_filter_kos_univ.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `universitas=${encodeURIComponent(universitas)}&order=${encodeURIComponent(order)}`,
                })
                    .then(response => response.json())
                    .then(data => {
                        kosanListContainer.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(kosan => {
                                kosanListContainer.innerHTML += `
                                    <a href="detail_kos.php?id=${kosan.id}" 
                                    class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                        <img src="${kosan.gambar_url}" alt="${kosan.nama_kos}" class="w-full h-40 object-cover">
                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold mb-2">${kosan.nama_kos}</h3>
                                            <p class="text-sm text-gray-500">${kosan.deskripsi}</p>
                                            <p class="mt-2 text-sm"><strong>Harga:</strong> Rp${new Intl.NumberFormat('id-ID').format(kosan.harga)}</p>
                                            <p class="text-sm"><strong>Alamat:</strong> ${kosan.alamat}</p>
                                            <p class="text-sm"><strong>Telepon:</strong> ${kosan.no_telepon}</p>
                                        </div>
                                    </a>
                                `;
                            });
                        } else {
                            kosanListContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Tidak ada data kosan sesuai filter.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        kosanListContainer.innerHTML = '<p class="col-span-full text-center text-red-500">Terjadi kesalahan saat memuat data kosan.</p>';
                    });
            };

            // Event listener untuk tombol "Terdekat"
            terdekatButton.addEventListener('click', () => {
                if (!terdekatButton.disabled) {
                    fetchKosanByDistance('asc'); // Kirim order = 'asc' untuk urutan terdekat
                }
            });

            // Event listener untuk tombol "Terjauh"
            terjauhButton.addEventListener('click', () => {
                if (!terjauhButton.disabled) {
                    fetchKosanByDistance('desc'); // Kirim order = 'desc' untuk urutan terjauh
                }
            });

            // Reset filter
            resetButton.addEventListener('click', () => {
                document.getElementById('universitas').value = '';
                document.getElementById('jarak').value = '';
                document.getElementById('harga').value = '';
                document.querySelectorAll('.fasilitas-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });
                kosanListContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Silakan pilih filter untuk melihat kosan.</p>';
                updateButtonState(); // Perbarui status tombol setelah reset
            });

            // Inisialisasi awal tombol
            updateButtonState();
        </script>



    </section>


     
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
