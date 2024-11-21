<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "db_used");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $item_id = $conn->real_escape_string($_POST['item_id']);
    $status = $conn->real_escape_string($_POST['status']);

    // Validasi status
    if (in_array($status, ['Tersedia', 'Tidak Tersedia'])) {
        $sql = "UPDATE items SET status = '$status' WHERE id = $item_id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['status_message'] = "Status barang berhasil diubah menjadi '$status'.";
            header("Location: item-detail.php?id=$item_id");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Status tidak valid.";
    }

    $conn->close();
} else {
    echo "Metode tidak valid.";
}
?>
