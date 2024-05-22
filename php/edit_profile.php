<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Validate inputs
    if (empty($firstName) || empty($lastName) || empty($email)) {
        die("First name, last name, and email are required.");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Update user data
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $firstName, $lastName, $email, $hashedPassword, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sssi", $firstName, $lastName, $email, $user_id);
    }

    if ($stmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Retrieve user information
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/profile-style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/atari-github/atari-github/php/dashboard.php">Dashboard</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about-us">About</a></li>
                <li><a href="#contact-us">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="edit-profile">
            <h1>Edit Profile</h1>
            <form action="/atari-github/atari-github/php/edit_profile.php" method="post">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name" value="<?php echo htmlspecialchars($firstName); ?>" required><br>
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last-name" value="<?php echo htmlspecialchars($lastName); ?>" required><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
                <label for="password">New Password (leave blank to keep current password):</label>
                <input type="password" id="password" name="password"><br>
                <label for="confirm-password">Confirm New Password:</label>
                <input type="password" id="confirm-password" name="confirm-password"><br><br>
                <input type="submit" value="Update Profile">
            </form>

            <form action="/atari-github/atari-github/php/delete_account.php" method="POST">
                <input type="submit" value="Delete Account">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 ATARI Electronic Store (Retribution Group)</p>
    </footer>
</body>
</html>
