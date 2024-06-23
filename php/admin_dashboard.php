<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /atari-github/atari-github/php/admin_login.php");
    exit;
}

// Welcome the admin
$adminName = $_SESSION['first_name'];

// Fetch summary statistics (replace with your actual SQL queries)
$totalOrdersQuery = "SELECT COUNT(*) as total FROM orders";
$totalRevenueQuery = "SELECT SUM(total_price) as total FROM orders";
$recentOrdersQuery = "SELECT * FROM orders ORDER BY order_date DESC LIMIT 5";
$topCustomersQuery = "SELECT customer_id, COUNT(*) as order_count FROM orders GROUP BY customer_id ORDER BY order_count DESC LIMIT 5";

$totalOrdersResult = $conn->query($totalOrdersQuery);
$totalRevenueResult = $conn->query($totalRevenueQuery);
$recentOrdersResult = $conn->query($recentOrdersQuery);
$topCustomersResult = $conn->query($topCustomersQuery);

$totalOrders = $totalOrdersResult->fetch_assoc()['total'];
$totalRevenue = $totalRevenueResult->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/admin-dashboard-style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/atari-github/atari-github/php/manage_products.php">Manage Products</a></li>
                <li><a href="/atari-github/atari-github/php/manage_users.php">Manage Users</a></li>
                <li><a href="/atari-github/atari-github/php/view_all_orders.php">View All Orders</a></li>
                <li><a href="/atari-github/atari-github/php/admin_logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Admin Dashboard</h1>
        <h2>Welcome, <?php echo $adminName; ?>!</h2>

        <section class="overview">
            <h2>Overview</h2>
            <div class="summary">
                <div>
                    <h3>Total Orders</h3>
                    <p><?php echo $totalOrders; ?></p>
                </div>
                <div>
                    <h3>Total Revenue</h3>
                    <p>$<?php echo $totalRevenue; ?></p>
                </div>
            </div>
        </section>

        <section class="recent-orders">
            <h2>Recent Orders</h2>
            <table>
                </table>
        </section>

        <section class="top-customers">
            <h2>Top Customers</h2>
            <table>
                </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 ATARI Electronic Store (Retribution Group)</p>
    </footer>
</body>
</html>
