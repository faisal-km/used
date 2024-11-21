<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Berfaedah - Daftar Barang</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Barang Berfaedah</h1>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<p class='welcome-message'>Selamat datang, " . $_SESSION['username'] . "</p>";
                echo "<a href='logout.php' class='auth-link'>Logout</a>";
            } else {
                echo "<a href='login.php' class='auth-link'>Login</a> | ";
                echo "<a href='register.php' class='auth-link'>Daftar</a>";
            }
            ?>
            <a href="add-item.html" class="add-button">Tambah Barang</a> | 
            <a href="https://api.whatsapp.com/send?phone=6285173052468&text=Hallo admin, ini saya dari web Barang Berfaedah, apakah barangnya ready?" class="whatsapp-button" target="_blank">Hubungi</a>
        </div>
    </header>

    <main>
        <h2>Daftar Barang</h2>
        
        <!-- Formulir Pencarian -->
        <form method="GET" action="index.php" class="search-form">
            <input type="text" name="search" placeholder="Cari barang..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Cari</button>
        </form>

        <!-- Daftar Barang -->
        <section id="item-list">
            <?php
            $conn = new mysqli("localhost", "root", "", "db_used");

            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Mendapatkan kata kunci pencarian
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

            // Query pencarian dengan filter kata kunci
            $sql = "SELECT * FROM items WHERE name LIKE '%$search%' ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='item'>";
                    echo "<h3 class='item-name'>" . $row["name"] . "</h3>";
                    echo "<p class='item-description'>" . $row["description"] . "</p>";
                    echo "<p class='item-price'>Harga: " . ($row["price"] ? "Rp " . number_format($row["price"], 0, ',', '.') : "Gratis") . "</p>";
                    echo "<p class='item-status'>Status: " . ucfirst($row["status"]) . "</p>";
                    echo "<a href='item-detail.php?id=" . $row["id"] . "' class='detail-link'>Lihat Detail</a>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-results'>Tidak ada barang yang ditemukan untuk kata kunci: <strong>" . htmlspecialchars($search) . "</strong></p>";
            }

            $conn->close();
            ?>
        </section>
    </main>
</body>
<footer>
    <p>&copy; 2024 FKM. Semua Hak Dilindungi.</p>
</footer>
</html>
