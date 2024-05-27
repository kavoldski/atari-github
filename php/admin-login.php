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
```**Key Changes:**

- **Removed `password_verify`:** Since your passwords are not hashed, the `password_verify` function is not needed. The code now directly compares the user's input password (`$password`) with the password stored in the database (`$storedPassword`).


**Important Security Note:**

Storing passwords in plain text is extremely insecure.  I **strongly** recommend you implement password hashing immediately. Here's how you would do it with the `password_hash` and `password_verify` functions:

1. **Hashing Passwords (When Creating/Updating Admin Users):**
   ```php
   $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Use a strong algorithm
   // ... then store $hashedPassword in your database
