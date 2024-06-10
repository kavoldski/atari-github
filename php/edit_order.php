<?php
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

$order_id = $_GET['order_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['product_name'];
    $orderDate = $_POST['order_date'];

    $stmt = $conn->prepare("UPDATE orders SET product_name = ?, order_date = ? WHERE order_id = ?");
    $stmt->bind_param("ssi", $productName, $orderDate, $order_id);

    if ($stmt->execute()) {
        header("Location: manage_orders.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Fetch order details
    $stmt = $conn->prepare("SELECT product_name, order_date FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($productName, $orderDate);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - Atari Electronic Store</title>
    <link rel="stylesheet" href="atari-github/atari-github/css/admin-style.css">
</head>
<body>
    <header>
        <h1>Edit Order</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Edit Order Details</h2>
            <form action="edit_order.php?order_id=<?php echo $order_id; ?>" method="post">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($productName); ?>"><br>
                <label for="order_date">Order Date:</label>
                <input type="date" id="order_date" name="order_date" value="<?php echo htmlspecialchars($orderDate); ?>"><br>
                <input type="submit" value="Save Changes">
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 ATARI Electronic Store (Retribution Group)</p>
    </footer>
</body>
</html>
