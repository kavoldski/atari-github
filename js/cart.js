document.addEventListener('DOMContentLoaded', () => {
    const cartItems = [];

    // Simulate a user login status check (for demonstration purposes)
    const isLoggedIn = () => {
        // This function should check actual login status, e.g., sessionStorage, cookies, etc.
        // For demo purposes, let's assume the user is not logged in
        return false; 
    };

    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-product-id');
            addItemToCart(productId);
        });
    });

    // Checkout button functionality
    document.getElementById('checkout-button').addEventListener('click', () => {
        if (isLoggedIn()) {
            window.location.href = '/atari-github/atari-github/html/checkout.html';
        } else {
            window.location.href = '/atari-github/atari-github/html/sign-in.html';
        }
    });

    // Function to add item to cart
    function addItemToCart(productId) {
        const product = {
            id: productId,
            name: `Product ${productId}`
        };
        cartItems.push(product);
        showCartMessage();
        updateCartUI();
    }

    // Function to show cart message
    function showCartMessage() {
        const cartMessage = document.getElementById('cart-message');
        cartMessage.textContent = 'Your item has been added to the cart.';
        cartMessage.style.display = 'block';
        setTimeout(() => {
            cartMessage.style.display = 'none';
        }, 2000);
    }

    // Function to update cart UI
    function updateCartUI() {
        const cartItemsList = document.getElementById('cart-items');
        cartItemsList.innerHTML = '';
        cartItems.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item.name;
            cartItemsList.appendChild(li);
        });
    }
});
