<?php
session_start();
include 'db_connect.php';

// Check if user is logged in AND is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { 
    header("Location: /atari-github/atari-github/php/admin_dashboard.php"); 
    exit();
}

// (Similar user data retrieval as before, but you might want admin-specific info)

// Retrieve summary statistics
$totalOrders = 0;
$totalRevenue = 0;
$recentOrders = [];
$topCustomers = [];

// ... (SQL queries to fetch the data)

// Assuming you fetched recent orders and top customers into the respective arrays
$conn->close();
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
                <li><a href="admin_products.php">Manage Products</a></li>
                <li><a href="admin_users.php">Manage Users</a></li>
                <li><a href="admin_orders.php">View All Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Admin Dashboard</h1>

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
