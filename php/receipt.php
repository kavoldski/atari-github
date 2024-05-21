<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['order_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email);
$stmt->fetch();
$stmt->close();

// Fetch order details
$stmt = $conn->prepare("SELECT product_name, order_date FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->bind_result($productName, $orderDate);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt - Atari Electronic Store</title>
    <link rel="stylesheet" href="/css/receipt-style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about-us">About</a></li>
                <li><a href="#contact-us">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="receipt">
            <h1>Payment Receipt</h1>
            <p>Order ID: <?php echo htmlspecialchars($order_id); ?></p>
            <p>Name: <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></p>
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
            <p>Product: <?php echo htmlspecialchars($productName); ?></p>
            <p>Order Date: <?php echo htmlspecialchars($orderDate); ?></p>
            <form action="generate_pdf.php" method="post">
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                <input type="submit" value="Download PDF">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 ATARI Electronic Store (Retribution Group)</p>
    </footer>
</body>
</html>
