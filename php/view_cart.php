<?php
session_start();

// Check if the user is logged in
$loggedIn = isset($_SESSION['user_id']);

// Get cart items from local storage
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Cart - Atari Electronic Store</title>
    <link rel="stylesheet" href="/atari-github/atari-github/style/view-cart-style.css"> </head>
<body>
    <header>
        </header>
    <main>
        <h2>Your Cart</h2>
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table id="cart-table">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <?php 
                    $totalPrice = 0;
                    foreach ($cartItems as $item): 
                        $totalItemPrice = $item['price'] * $item['quantity'];
                        $totalPrice += $totalItemPrice;
                ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="50">
                        <?php echo htmlspecialchars($item['name']); ?>
                    </td>
                    <td>RM <?php echo htmlspecialchars($item['price']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>RM <?php echo htmlspecialchars($totalItemPrice); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Grand Total:</strong></td>
                    <td>RM <?php echo htmlspecialchars($totalPrice); ?></td>
                </tr>
            </table>
        <?php endif; ?>
    </main>

    <footer>
    </footer>
</body>
</html>
