// Initialize cart array
let cart = [];

// Function to add item to cart
function addToCart(productId, productName, productPrice) {
    // Check if item is already in cart
    let existingItem = cart.find(item => item.productId === productId);
    
    if (existingItem) {
        // If item is already in cart, increase quantity
        existingItem.quantity++;
    } else {
        // If item is not in cart, add it
        cart.push({
            productId: productId,
            name: productName,
            price: productPrice,
            quantity: 1
        });
    }
    
    // Update UI or perform any other necessary action (e.g., display cart count)
}

// Event listener for Add to Cart buttons
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        let productId = parseInt(this.getAttribute('data-product-id'));
        let productName = this.parentNode.querySelector('h1').innerText;
        let productPrice = parseFloat(this.parentNode.querySelector('.product-price').innerText.replace('$', ''));
        
        addToCart(productId, productName, productPrice);
    });
});

// Event listener for Checkout button
document.getElementById('checkout-button').addEventListener('click', function() {
    // Redirect user to member login page
    window.location.href = "/atari-github/atari-github/html/sign-in.html";
});
