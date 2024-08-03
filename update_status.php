<?php
$servername = "localhost";
$username = "root";
$password = ""; // default XAMPP MySQL password is empty
$dbname = "shipments";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);
$status = $_GET['status'];

$sql = "UPDATE shipments SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    header("Location: index.php?message=Status updated successfully");
} else {
    header("Location: index.php?message=Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
