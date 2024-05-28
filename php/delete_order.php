<?php
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

$order_id = $_GET['order_id'];

$stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    header("Location: manage_orders.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
