<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and check the statement (change admin_id to id)
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?"); 

    if (!$stmt) { 
        die("Error preparing statement: " . $conn->error); 
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword); // Still bind to $admin_id
    $stmt->fetch();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['admin_id'] = $admin_id;  // Store id as admin_id in session
        header("Location: /atari-github/atari-github/php/admin_dashboard.php");
        exit();
    } else {
        echo "Invalid username or password!";
    }

    $stmt->close();
    $conn->close();
}
?>
