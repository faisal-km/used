<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "db_used");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registrasi berhasil. Silakan login.'); window.location.href = 'login.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Barang Berfaedah</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Daftar Akun</h1>
        <a href="index.php" class="back-button">Kembali ke Beranda</a>
    </header>
<br>
<br>
<br>
    <main>
        <form method="POST" action="register.php" id="register-form">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Daftar</button>

            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </form>
    </main>
<br>
<br>
<br>
</body>
    <footer>
        <p>&copy; 2024 FKM. Semua Hak Dilindungi.</p>
    </footer>
</html>
