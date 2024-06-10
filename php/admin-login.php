<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials against database
    $stmt = $conn->prepare("SELECT email, password FROM admin WHERE username = ?"); 
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $stmt->bind_result($email, $storedPassword);

    if ($stmt->fetch() && $password == $storedPassword) { 
        $_SESSION['email'] = $email;  
        $_SESSION['role'] = 'admin';
        header("Location:/atari-github/atari-github/php/admin_dashboard.php");
        exit();
    } else {
        $error_message = "Incorrect username or password.";
    }

    $stmt->close(); 
}
?>
