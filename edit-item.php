<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    $id = $_POST['id'];
    $sql = "UPDATE items SET status = '$status' WHERE id = $id";
    $conn->query($sql);
    header("Location: index.php");
    exit();
}
?>
