// cart.js

// Get cart items from local storage
let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

// Function to update cart in local storage and display
function updateCart() {
    localStorage.setItem("cartItems", JSON.stringify(cartItems));
    updateCartDisplay();
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
            image: product.image
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

// Function to remove an item from the cart
function removeFromCart(productId) {
    cartItems = cartItems.filter(item => item.productId !== productId);
    updateCart();
    alert("Product removed from cart!");
}

// Function to update the quantity of an item in the cart
function updateQuantity(productId, newQuantity) {
    const item = cartItems.find(item => item.productId === productId);
    if (item) {
        item.quantity = newQuantity;
        updateCart();
    }
}

// Function to calculate the total price of the cart
function calculateTotalPrice() {
    return cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
}


// Function to update the cart display (implementation based on your view_cart.php structure)
function updateCartDisplay() {
    const cartTable = document.getElementById("cart-table"); // Assuming you have a table with this ID in your HTML
    
    // Clear existing table rows
    while (cartTable.rows.length > 1) {
        cartTable.deleteRow(1);
    }

    let total = 0; // Initialize total price
    cartItems.forEach(item => {
        const row = cartTable.insertRow();
        row.insertCell().innerHTML = `<img src="${item.image}" alt="${item.name}" width="50">`;
        row.insertCell().textContent = item.name;
        row.insertCell().textContent = `RM ${item.price.toFixed(2)}`; // Format the price
        
        // Quantity cell with input for updating
        const quantityCell = row.insertCell();
        quantityCell.innerHTML = `
            <input type="number" min="1" value="${item.quantity}" 
                   onchange="updateQuantity(${item.productId}, this.value)">
        `;
        
        const totalPriceCell = row.insertCell();
        const itemTotal = item.price * item.quantity;
        totalPriceCell.textContent = `RM ${itemTotal.toFixed(2)}`;
        total += itemTotal; // Calculate running total
    });

    // Add a row for the total price
    const totalRow = cartTable.insertRow();
    totalRow.insertCell().colSpan = 3; // Merge 3 cells
    totalRow.insertCell().textContent = "Total:";
    totalRow.insertCell().textContent = `RM ${total.toFixed(2)}`;
}

// Event listener for Add to Cart buttons (using event delegation)
// ... (unchanged from before)
