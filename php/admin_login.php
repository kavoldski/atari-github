<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and check the statement
    $stmt = $conn->prepare("SELECT admin_id, first_name, password FROM admin WHERE username = ?"); 

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Bind results to variables
    $stmt->bind_result($admin_id, $firstName, $hashedPassword);
    $stmt->fetch();  

    if (password_verify($password, $hashedPassword)) {
        // Store admin details in session
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['first_name'] = $firstName;
        $_SESSION['role'] = 'admin';
        
        // Redirect to admin dashboard
        header("Location: /atari-github/atari-github/php/admin_dashboard.php");
        exit; 
    } else {
        echo "Invalid username or password!";
    }

    $stmt->close();
    $conn->close();
}
?>
