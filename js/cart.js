// cart.js

// Get the cart items from local storage, or initialize an empty cart
let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

// Function to update cart in local storage
function updateCart() {
    localStorage.setItem("cartItems", JSON.stringify(cartItems));
    updateCartDisplay(); // Update the cart display (you'll need to implement this)
}

// Function to add item to cart
function addToCart(productId) {
    const product = getProductDetails(productId); 

    const existingItem = cartItems.find(item => item.productId === productId);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cartItems.push({
            productId: product.id,
            name: product.name,
            price: product.price,
            quantity: 1,
            image: product.image,
        });
    }
    
    updateCart();

    alert("Product added to cart!");
}

// Function to get product details from the page
function getProductDetails(productId) {
    const productCard = document.querySelector(`.product-card[data-product-id="${productId}"]`);
    return {
        id: productId,
        name: productCard.querySelector('h1').innerText,
        price: parseFloat(productCard.querySelector('.product-price').innerText.replace('RM', '')),
        image: productCard.querySelector('img').src, 
    };
}
// Event listener for Add to Cart buttons (using event delegation)
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('add-to-cart')) {
        const productId = event.target.dataset.productId;
        addToCart(productId);
    }
});


// Function to update the cart display (You'll need to implement this based on your UI)
function updateCartDisplay() {
    // Example:
    // const cartCount = document.getElementById("cart-count");
    // cartCount.textContent = cartItems.length;
}

// Call updateCartDisplay on page load to show initial cart count
updateCartDisplay();
