<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Input sanitization and validation
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Password validation (strength checks, etc. - you can add more here)
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long!";
        exit(); 
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT username, email FROM admin WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Username or email already exists!";
        exit();
    }
    $stmt->close();

    // Insert new admin user
    $stmt = $conn->prepare("INSERT INTO admin (first_name, last_name, email, username, password, created_at) 
                            VALUES (?, ?, ?, ?, ?, NOW())"); // NOW() for current timestamp
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $hashedPassword);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        echo "Admin user registered successfully!";
        header("Location: /atari-github/atari-github/html/admin_login.html");

        exit();
    } else {
        echo "Error registering admin user!";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Registration</title>
</head>
<body>

<h2>Register as Admin</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="first_name">First Name:</label><br>
    <input type="text" id="first_name" name="first_name" required><br>
    
    <label for="last_name">Last Name:</label><br>
    <input type="text" id="last_name" name="last_name" required><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Register">
</form>

</body>
</html>
