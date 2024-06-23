<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT admin_id, password FROM admin WHERE username = ?"); // Fetch admin_id
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($admin_id, $hashedPassword); // Bind to both admin_id and password
    $stmt->fetch();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['admin_id'] = $admin_id; 
        header("Location: /atari-github/atari-github/php/admin_dashboard.php");
        exit(); // Ensure script stops after redirect
    } else {
        echo "Invalid username or password!";
    }

    $stmt->close();
    $conn->close();
}
?>
