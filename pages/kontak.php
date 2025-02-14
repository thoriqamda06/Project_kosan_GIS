<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <section class="w-full font-montserrat p-4">
        <nav class="container mx-auto flex flex-wrap items-center justify-between">
            <img src="../src/img/awakkoss.png" alt="awakkos" class="w-32 sm:w-48">
            <ul class="flex flex-wrap gap-4 sm:gap-6 items-center">
                <li class="relative group">
                    <a href="index.php" class="font-semibold text-base duration-500">HOME</a>
                    <div class="absolute left-0 w-0 duration-500 group-hover:w-full h-1 bg-orange-500"></div>
                </li>
                <li class="relative group">
                    <a href="semua_kos.php" class="font-semibold text-base duration-500">CARI KOS</a>
                    <div class="absolute left-0 w-0 duration-500 group-hover:w-full h-1 bg-orange-500"></div>
                </li>
                
                <li class="relative group">
                    <a href="kontak.php" class="font-semibold text-base duration-500">KONTAK</a>
                    <div class="absolute left-0 w-0 duration-500 group-hover:w-full h-1 bg-orange-500"></div>
                </li>
            </ul>
            <a href="../login.php">
                <button class="py-2 px-4 m-2 rounded-full border-2 font-semibold border-blue-300 bg-orange-500 hover:bg-orange-600">Masuk</button>
            </a>
        </nav>
    </section>

    <div class="container mx-auto flex justify-center mt-6">
        <div class="w-full max-w-lg bg-white shadow-xl rounded-2xl p-6 text-center">
            <div class="flex justify-center mb-4">
                <img src="../uploads/contact.jpeg" alt="Profile Picture" class="w-32 h-32 sm:w-40 sm:h-40 rounded-full shadow-md transition-transform duration-300 hover:scale-110 hover:shadow-lg">
            </div>
            <img src="../src/img/awakkoss.png" alt="awakkos" class="w-32 sm:w-48 mx-auto mb-4">
            <p class="text-gray-600 mb-6">Hallo syedara long, meseu na perle informasi jet langsong neu hubungi long secara pribadi.</p>
            <div class="flex flex-col gap-4 max-w-sm mx-auto">
                <a href="https://wa.me/6285214970768" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-2 border-2 border-orange-500 text-orange-500 rounded-lg hover:bg-orange-500 hover:text-white transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" class="w-6 h-6"> WhatsApp
                </a>
                <a href="https://www.instagram.com/althoriqamda_" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-2 border-2 border-orange-500 text-orange-500 rounded-lg hover:bg-orange-500 hover:text-white transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" class="w-6 h-6"> Instagram
                </a>
                <a href="mailto:al-thoriq.200170278@mhs.unimal.ac.id" class="w-full flex items-center justify-center gap-2 px-4 py-2 border-2 border-orange-500 text-orange-500 rounded-lg hover:bg-orange-500 hover:text-white transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Gmail_icon_%282020%29.svg/1280px-Gmail_icon_%282020%29.svg.png" alt="Gmail" class="w-6 h-6"> Gmail
                </a>
            </div>
        </div>
    </div>
</body>
</html>
