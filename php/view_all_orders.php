<?php
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

// Fetch orders (consider adding pagination for large datasets)
$orders = [];
$stmt = $conn->prepare("SELECT o.order_id, o.user_id, u.first_name, u.last_name, o.total_price, o.order_date
                        FROM orders o
                        JOIN users u ON o.user_id = u.id 
                        ORDER BY o.order_date DESC"); // Order by date (newest first)
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
    <title>View All Orders - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/all-orders-style.css">
</head>
<body>
    <header>
        <h1>View All Orders</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
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
                    <th>Customer Name</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                        <td>$<?php echo htmlspecialchars($order['total_price']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td>
                            <a href="view_order_details.php?order_id=<?php echo $order['order_id']; ?>">View Details</a>
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
