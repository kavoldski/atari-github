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

//Retrieve orders from database
$stmt = $conn->prepare("SELECT order_id, product_name, order_date FROM orders WHERE id = ?");
$stmt->bind_result($order_id, $product_name, $order_date);
$orders = array();
while ($stmt->fetch()){
    $orders[] = array(
        'order_id' => $order_id,
        'product_name' => $product_name,
        'order_date' => $order_date
    );
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/dashboard-style.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($firstName); ?>!</h1>
        <nav>
            <ul>
                <li><a href="/atari-github/atari-github/html/index.html">Home</a></li>
                <li><a href="/atari-github/atari-github/php/product.php">Products</a></li>
                <li><a href="#about-us">About</a></li>
                <li><a href="#contact-us">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="dashboard">
            <h1>Welcome, <?php echo ($firstName . ' ' . $lastName); ?>!</h1>
            <p>Your Email: <?php echo ($email); ?></p>
            <h2>Your Orders</h2>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Order Date</th>
                </tr>
                 <?php foreach ($orders as $order):?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 ATARI Electronic Store (Retribution Group)</p>
    </footer>
</body>
</html>
