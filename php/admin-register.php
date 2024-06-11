<?php
include 'db_connect.php';

// Retrieve form data
$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Validate inputs
if (empty($firstName) || empty($lastName) || empty($email) || empty($username) || empty($password)) {
    die("All fields are required.");
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into the database
$stmt = $conn->prepare("INSERT INTO admin (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $hashedPassword);

if ($stmt->execute()) {
    echo "NEW ADMIN created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
