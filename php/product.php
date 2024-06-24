<?php
session_start();
include 'db_connect.php';

// Fetch all products
$sql = "SELECT * FROM products";

// Search functionality (if search term exists)
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql = "SELECT * FROM products WHERE productName LIKE '%$search_term%' OR description LIKE '%$search_term%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/product-style.css"> </head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li><a href="/atari-github/atari-github/html/index.html">Home</a></li>
                <li><a href="product.php">Product</a></li>
                <li><a href="/atari-github/atari-github/html/sign-in.html">Sign In</a></li>
                <li><a href="/atari-github/atari-github/html/sign-up.html">Sign Up</a></li>
            </ul>
            
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="search" placeholder="Search products...">
                <button type="submit">Search</button>
            </form>
        </nav>
    </header>

    <main>
        <section class="product-carousel">
            <div class="product-card-container">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="product-card">';
                        echo '<div class="product-image">';
                        // Display the product image from the database
                        if (!empty($row["product_img"])) {
                            echo '<img src="' . htmlspecialchars($row["product_img"]) . '" alt="' . htmlspecialchars($row["productName"]) . '">'; 
                        } else {
                            echo '<img src="path/to/default/image.jpg" alt="Default Image">'; // Display a default image if none found
                        }
                        echo '</div>';
                        
                        //details of the products
                        echo '<div class="product-details">';
                        echo '<h1>' . htmlspecialchars($row["productName"]) . '</h1>';
                        echo '<p class="product-description">' . htmlspecialchars($row["description"]) . '</p>';
                        echo '<p class="product-price">RM' . htmlspecialchars($row["price"]) . '</p>';
                        echo '<button class="add-to-cart" data-product-id="' . $row["product_id"] . '">Add to Cart</button>'; // Use product_id
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No products found matching your search.";
                }
                $conn->close();
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 ATARI Electronic Store (Retribution Group)</p>
    </footer>
    <script src="js/cart.js"></script>
</body>
</html>
