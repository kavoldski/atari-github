<?php
session_start();
include 'db_connect.php';

//Fetching the products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/product-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <ul class="nav-list">
                <li><a href="/atari-github/atari-github/html/index.html">Home</a></li>
                <li><a href="/atari-github/atari-github/php/product.php">Product</a></li>
                <li><a href="/atari-github/atari-github/html/sign-in.html">Sign In</a></li>
                <li><a href="/atari-github/atari-github/html/sign-up.html">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="product-carousel">
            <div class="product-card-container" data-product-name="headphone" style="position:fixed, right :0;">
            <?php  
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="product-image">';
                            echo '<img src="/atari-github/atari-github/img/headphone.jpg" alt="headphone">';
                        echo '</div>';
                        echo '<div class="product-details">';
                            echo '<h1>' . $row["productName"] . '<h1>';
                            echo '<p class="product-description">' . $row["description"] . '</p>';
                            echo '<p class="product-price">RM' . $row["price"] . '</p>';
                            echo '<button class="add-to-cart" data-product-id="1">Add to Cart</button>';
                        echo '</div>';  
                    }
                } else {
                    echo "No Products available at the moment.";
                }
            $conn->close();
            ?>    
                
            </div>
            <br>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 ATARI Electronic Store (Retribution Group)</p>
    </footer>

    <script src="/atari-github/atari-github/js/cart.js"></script>

</body>
</html>
