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
<<<<<<< HEAD
    <link rel="stylesheet" href="/atari-github/atari-github/style/dashboard-style.css">
=======
    <link rel="stylesheet" href="atari-github/atari-github/css/dashboard-style.css">
>>>>>>> 63299fe6abdd209c89daff3f9e93b39ea9f77323
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($firstName); ?>!</h1>
        <nav>
            <ul>
                <li><a href="/atari-github/atari-github/html/index.html">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about-us">About</a></li>
                <li><a href="#contact-us">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
<<<<<<< HEAD
        <section class="dashboard">
            <h1>Welcome, <?php echo ($firstName); ?>!</h1>
            <p>Your Email: <?php echo ($email); ?></p>
            <h2>Your Orders</h2>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Order Date</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
=======
        <section class="payment">
            <h2>Make a Payment</h2>
            <form action="process_payment.php" method="POST">
                <label for="order-id">Order ID:</label>
                <input type="text" id="order-id" name="order_id" required><br>
                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" required><br>
                <input type="submit" value="Pay">
            </form>
>>>>>>> 63299fe6abdd209c89daff3f9e93b39ea9f77323
        </section>
    </main>
    <footer>
        <p>&copy; 2024 ATARI Electronic Store (Retribution Group)</p>
    </footer>
</body>
</html>
