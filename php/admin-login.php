<?php
session_start();
include 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials against your database (e.g., using prepared statements)
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? AND role = 'admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if ($userId && password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['role'] = 'admin'; // Set admin role in session
        header("Location: admin-dashboard.php");
        exit();
    } else {
        // Handle incorrect credentials (display error message)
        $error_message = "Incorrect username or password.";
    }
}
?>
