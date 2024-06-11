<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update the column name to match the actual table structure
    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($admin_id, $hashedPassword);
    $stmt->fetch();

    if ($admin_id && password_verify($password, $hashedPassword)) {
        $_SESSION['admin_id'] = $admin_id;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Invalid username or password!";
    }

    $stmt->close();
    $conn->close();
}
?>
