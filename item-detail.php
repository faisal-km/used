<?php
session_start();
if (isset($_SESSION['status_message'])) {
    echo "<p class='notification'>" . $_SESSION['status_message'] . "</p>";
    unset($_SESSION['status_message']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang - Barang Berfaedah</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Detail Barang</h1>
        <a href="index.php" class="back-button">Kembali ke Daftar Barang</a>
    </header>
<br>
<br>
<br>
    <main>
        <?php
        $conn = new mysqli("localhost", "root", "", "db_used");

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $id = $_GET['id'];
        $sql = "SELECT * FROM items WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='item-detail'>";
            echo "<h2 class='item-name'>" . $row["name"] . "</h2>";
            echo "<p class='item-description'>" . $row["description"] . "</p>";
            echo "<p class='item-price'>Harga: " . ($row["price"] ? "Rp. " . number_format($row["price"], 0, ',', '.') : "Gratis") . "</p>";
            echo "<p class='item-status'>Status: " . ucfirst($row["status"]) . "</p>";
            echo "<p class='item-date'>Tanggal Ditambahkan: " . date("d M Y", strtotime($row["created_at"])) . "</p>";

            // Tombol Pengaturan Status
            echo "<form method='POST' action='update-status.php' class='status-form' onsubmit='return confirmStatusChange(event)'>";
            echo "<input type='hidden' name='item_id' value='" . $row["id"] . "'>";
            if ($row["status"] !== 'Tersedia') {
                echo "<button type='submit' name='status' value='Tersedia' class='status-btn available'>Tandai Tersedia</button>";
            }
            if ($row["status"] !== 'Tidak Tersedia') {
                echo "<button type='submit' name='status' value='Tidak Tersedia' class='status-btn unavailable'>Tandai Tidak Tersedia</button>";
            }
            echo "</form>";

            echo "</div>";
        } else {
            echo "<p>Barang tidak ditemukan.</p>";
        }

        $conn->close();
        ?>
    </main>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
    <footer>
        <p>&copy; 2024 FKM. Semua Hak Dilindungi.</p>
    </footer>

    <script>
    function confirmStatusChange(event) {
        const status = event.submitter.value;
        const confirmMessage = status === 'Tidak Tersedia' ? 
            'Apakah Anda yakin ingin menandai barang ini sebagai Tidak Tersedia?' :
            'Apakah Anda yakin ingin menandai barang ini sebagai Tersedia?' ;

        return confirm(confirmMessage);
    }
    </script>

</body>
</html>
