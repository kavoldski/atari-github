<?php
session_start();
include 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

// Fetch products
$products = [];

// Prepare and check the statement
$stmt = $conn->prepare("SELECT product_id, productName, product_img, description, price, created_at FROM products");

if (!$stmt) { // Check if prepare failed
    die("Error preparing statement: " . $conn->error); 
}

$stmt->execute();
$result = $stmt->get_result(); // Get the result set

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();
$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/manage-product-style.css">
</head>
<body>
    <header>
        <h1>Manage Products</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_orders.php">Manage Orders</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Product List</h2>

            <button onclick="window.location.href = 'add_product.php';">Add New Product</button>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Image</th> <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($product['product_img']); ?>" alt="Product Image" width="50"></td> <td><?php echo htmlspecialchars($product['productName']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td>RM <?php echo htmlspecialchars($product['price']); ?></td>
                        <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                        <td>
                            <a href="edit_product.php?product_id=<?php echo $product['product_id']; ?>">Edit</a>
                            <a href="delete_product.php?product_id=<?php echo $product['product_id']; ?>" 
                               onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
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
