<?php
session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            header('Location: CRUD/index.php');
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Login</title>
    <link href="./src/output.css" rel="stylesheet">

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function validatePassword() {
            const passwordInput = document.getElementById('password');
            const errorMessage = document.getElementById('error-message');

            // Contoh validasi (ganti dengan logika validasi Anda sendiri)
            if (passwordInput.value !== "12345") { // Password yang benar adalah "12345"
                errorMessage.style.display = "block"; // Tampilkan pesan error
            } else {
                errorMessage.style.display = "none"; // Sembunyikan pesan error
                alert("Login berhasil!");
            }
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.eye-icon i');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</head>
<style>
    /* body * {
            border: 1px solid red;
        } */
</style>

<body>
    <div class=" max-h-screen flex flex-col p-8 justify-center items-center ">
        <img class="w-2/6 shadow-lg rounded-xl m-8" src="src/img/awakkoss.png" alt="awakkos logo">
        <h2 class="text-2xl font-bold text-center m-4">Masuk</h2>

        <form method="POST" action="" autocomplete="off" class="max-w-xl mx-auto   bg-white   ">
            <?php if (isset($error)) echo "<p class='text-red-500 text-sm mb-4'>$error</p>"; ?>

            <!-- Email Input -->
            <div class="relative mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="flex w-96 items-center border-2 rounded-full mt-2 py-2 px-3 focus-within:border-blue-500">
                    <i class="fas fa-envelope text-gray-500 mr-3"></i>
                    <input type="text" name="username" id="email" placeholder="Masukkan Username" required autofocus
                        class="w-full p-2 text-sm text-gray-700 focus:outline-none   ">
                </div>
            </div>

            <!-- Password Input -->
            <div class="relative mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <div class="flex w-96 items-center border-2 rounded-full mt-2 py-2 px-3 focus-within:border-blue-500">
                    <i class="fas fa-lock text-gray-500 mr-3"></i>
                    <input type="password" name="password" id="password" placeholder="Masukkan Kata Sandi" required
                        class="w-full p-2 text-sm text-gray-700 focus:outline-none ">
                    <i class="fas fa-eye text-gray-500 cursor-pointer absolute right-3" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>

            <!-- Forgot Password Link -->
            <div class="mb-4 text-right">
                <a href="forgot_password.php" class="text-sm text-orange-500 hover:underline">Lupa Kata Sandi?</a>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Masuk
                </button>
            </div>
        </form>

        <script>
            function togglePasswordVisibility() {
                const passwordField = document.getElementById('password');
                const eyeIcon = document.querySelector('.eye-icon');
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            }
        </script>

    </div>
</body>

</html>