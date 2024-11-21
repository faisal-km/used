<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "db_used");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            echo "<p>Password salah.</p>";
        }
    } else {
        echo "<p>Username tidak ditemukan.</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Barang Berfaedah</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Login</h1>
        <a href="index.php" class="back-button">Kembali ke Beranda</a>
    </header>
<br>
<br>
<br>
    <main>
        <form method="POST" action="login.php" id="login-form">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>

            <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        </form>
    </main>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</body>
    <footer>
        <p>&copy; 2024 FKM. Semua Hak Dilindungi.</p>
    </footer>
</html>
