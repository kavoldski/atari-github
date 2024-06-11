document.addEventListener('DOMContentLoaded', () => {
    const cartItems = [];

    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-product-id');
            addItemToCart(productId);
        });
    });

    // Checkout button functionality
    const checkoutButton = document.getElementById('checkout-button');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', () => {
            if (cartItems.length === 0) {
                alert('Your cart is empty');
            } else {
                // Redirect to member login page
                window.location.href = '/atari-github/atari-github/html/sign-in.html';
            }
        });
    } else {
        console.error('Checkout button not found');
    }

    // Function to add item to cart
    function addItemToCart(productId) {
        const product = {
            id: productId,
            name: `Product ${productId}`
        };
        cartItems.push(product);
        updateCartUI();
    }

    // Function to update cart UI
    function updateCartUI() {
        const cartItemsList = document.getElementById('cart-items');
        if (cartItemsList) {
            cartItemsList.innerHTML = '';
            cartItems.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item.name;
                cartItemsList.appendChild(li);
            });
        } else {
            console.error('Cart items list not found');
        }
    }

    // Function to filter products based on search query
    function filterProducts(query) {
        document.querySelectorAll('.product-section').forEach(product => {
            const title = product.querySelector('.product-details h1').textContent.toLowerCase();
            if (title.includes(query)) {
                product.style.display = '';
            } else {
                product.style.display = 'none';
            }
        });
    }
});
