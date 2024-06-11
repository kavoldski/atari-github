document.addEventListener('DOMContentLoaded', () => {
    const cartItems = [];

    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default form submission
            const productId = button.getAttribute('data-product-id');
            addItemToCart(productId);
        });
    });

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
        cartItemsList.innerHTML = '';
        cartItems.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item.name;
            cartItemsList.appendChild(li);
        });
    }
});
