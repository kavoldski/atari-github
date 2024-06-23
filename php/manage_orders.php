<?php
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

// Fetch orders
$orders = [];
$stmt = $conn->prepare("SELECT order_id, user_id, product_name, order_date FROM orders");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/manage-order-style.css">
</head>
<body>
    <header>
        <h1>Manage Orders</h1>
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
            <h2>Order List</h2>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Product Name</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td>
                            <a href="edit_order.php?order_id=<?php echo $order['order_id']; ?>">Edit</a>
                            <a href="delete_order.php?order_id=<?php echo $order['order_id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                        </td>
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
