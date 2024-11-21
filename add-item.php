<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_used";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $sql = "INSERT INTO items (name, description, price, status) VALUES ('$name', '$description', '$price', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Barang berhasil ditambahkan!";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
