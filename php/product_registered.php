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

// Check if the user is logged in
$loggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/product-registered-style.css">
</head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li><a href="index.html">Home</a></li>
                <li><a href="product_registered.php">Product</a></li>
                <?php if ($loggedIn): ?>
                    <li><a href="view_cart.php">View Cart</a></li> 
                    <li><a href="my_account.php">My Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="sign-in.html">Sign In</a></li>
                    <li><a href="sign-up.html">Sign Up</a></li>
                <?php endif; ?>
            </ul>
            
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="search" placeholder="Search products...">
                <button type="submit">Search</button>
            </form>
        </nav>
    </header>

    <main>
        <section class="product-carousel">
            <div class="product-card-container" id="product-container">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="product-card" data-product-id="' . $row["product_id"] . '">'; // Add data-product-id
                        echo '<div class="product-image">';
                        
                        // Display the product image from the database
                        if (!empty($row["product_img"])) {
                            echo '<img src="' . htmlspecialchars($row["product_img"]) . '" alt="' . htmlspecialchars($row["productName"]) . '">'; 
                        } else {
                            echo '<img src="path/to/default/image.jpg" alt="Default Image">'; // Display a default image if none found
                        }
                        echo '</div>';

                        // Product details
                        echo '<div class="product-details">';
                        echo '<h1>' . htmlspecialchars($row["productName"]) . '</h1>';
                        echo '<p class="product-description">' . htmlspecialchars($row["description"]) . '</p>';
                        echo '<p class="product-price">RM' . htmlspecialchars($row["price"]) . '</p>';
                        
                        // Add to Cart button for registered users
                        if ($loggedIn) {
                            echo '<button class="add-to-cart">Add to Cart</button>'; 
                        } else {
                            echo '<p><a href="sign-in.html">Sign in to add to cart</a></p>';
                        }
                        echo '</div>';
                        echo '</div>'; // Close product-card
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
    <script>
        // JavaScript Code (combined PHP and JS):

        // Fetch product data (already available from PHP)
        const products = <?php echo json_encode($products); ?>;
        
        // Get the product container
        const productContainer = document.getElementById("product-container");

        // Function to render a single product card
        function createProductCard(product) {
            return `
                <div class="product-card" data-product-id="${product.product_id}">
                    <div class="product-image">
                        <img src="${product.product_img}" alt="${product.productName}">
                    </div>
                    <div class="product-details">
                        <h1>${product.productName}</h1>
                        <p class="product-description">${product.description}</p>
                        <p class="product-price">RM ${product.price}</p>
                        <button class="add-to-cart">Add to Cart</button>
                    </div>
                </div>
            `;
        }

        // Render product cards
        products.forEach(product => {
            productContainer.innerHTML += createProductCard(product);
        });

        // Event listener for Add to Cart buttons (using event delegation)
        productContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('add-to-cart')) {
                const productId = event.target.closest('.product-card').dataset.productId; // Find the closest parent with the data attribute
                addToCart(productId);
            }
        });

        // ... (your other cart.js functions: addToCart, updateCartDisplay, etc.) 
    </script>
    <script src="js/cart.js"></script>
</body>
</html>
