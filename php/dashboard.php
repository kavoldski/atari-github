<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.html");
    exit();
}

$user_id = $_SESSION['user_id'];

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Atari Electronic Store</title>
    <link rel="stylesheet" href="atari-github/atari-github/css/dashboard-style.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($firstName); ?>!</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about-us">About</a></li>
                <li><a href="#contact-us">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="payment">
            <h2>Make a Payment</h2>
            <form action="process_payment.php" method="POST">
                <label for="order-id">Order ID:</label>
                <input type="text" id="order-id" name="order_id" required><br>
                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" required><br>
                <input type="submit" value="Pay">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 ATARI Electronic Store (Retribution Group)</p>
    </footer>
</body>
</html>
