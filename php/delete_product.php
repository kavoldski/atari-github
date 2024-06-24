<?php
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: /atari-github/atari-github/html/admin_login.html");
    exit();
}

// Check if product_id is provided
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Prepare and execute delete statement using a prepared statement
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        // Success - redirect back to manage_products.php
        header("Location: manage_products.php");
        exit();
    } else {
        // Error - handle deletion error
        echo "Error deleting product: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Handle missing product_id (you might want to redirect or display an error)
    echo "Product ID not provided.";
}

$conn->close();
?>
