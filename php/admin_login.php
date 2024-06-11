<?php
session_start();
include 'db_connect.php';

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];

//Validate inputs
if (empty($username) || empty($password)) {
    die("Username and password are required.");
}

//Retrieved admin data from the database based on username
$stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashedPassword);

if ($stmt->num_rows == 1) {
    $stmt->fetch();

    //Verifying password
    if (password_verify($password, $hashedPassword)) {
        $_SESSION['admin_username'] = $username;
        header("Location: /atari-github/atari-github/php/admin_dashboard.php");
        exit();
    }
    else {
        echo "Incorrect password.";
    }
} else {
    echo "Username not found.";
}

$stmt->close();
$conn->close();

?>
