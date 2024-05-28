<?php
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

// Check if order_id is set and is a valid integer
if (!isset($_GET['order_id']) || !filter_var($_GET['order_id'], FILTER_VALIDATE_INT)) {
    die("Invalid order ID");
}

$order_id = intval($_GET['order_id']);

// Prepare the SQL statement
$stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameter and execute the statement
$stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    header("Location: manage_orders.php");
    exit();
} else {
    echo "Error executing query: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
