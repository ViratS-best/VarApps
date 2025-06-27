<?php
session_start();
if (!isset($_SESSION['cart']) && isset($_COOKIE['cart'])) {
    $_SESSION['cart'] = json_decode($_COOKIE['cart'], true) ?? [];
}
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include('connect.php');
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VarCart</title>
    <link rel="stylesheet" href="styles.css">
    <script src="defer.js" defer></script>
    <link rel="stylesheet" href="cart.css">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>
</head>
<body>
    <nav class="navbar">
        <a href="Dashboard.php" class="logo">VarCart</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="Dashboard.php">Shop</a>
            <button id="theme-toggle" class="theme-toggle">🌙 Dark/Light</button>
            <a href="cart.php" class="cart-icon">
                <i class="ri-shopping-bag-line"></i>
                <span class="cart-icon-count"><?php echo $cart_count; ?></span>
            </a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>
    <div class="main-content">
        <div class="filters">
            <label for="Distance">Range</label>
            <select id="Distance">
                <option value="close">0-5 miles</option>
                <option value="medium">5-15 miles</option>
                <option value="far">15+</option>
                <option value="all">All</option>
            </select>
            <label for="Category">Category</label>
            <select id="Category">
                <option value="all">All</option>
                <option value="food">Food</option>
                <option value="clothing">Clothing</option>
                <option value="electronics">Electronics</option>
                <option value="home">Home</option>
                <option value="toys">Toys</option>
                <option value="books">Books</option>
                <option value="sports">Sports</option>
                <option value="health">Health</option>
                <option value="beauty">Beauty</option>
                <option value="automotive">Automotive</option>
                <option value="garden">Garden</option>
                <option value="pets">Pets</option>
                <option value="office">Office</option>
                <option value="music">Music</option>
            </select>
            <label for="Price">Price</label>
            <select id="Price">
                <option value="low">Low to High</option>
                <option value="high">High to Low</option>
                <option value="all">All</option>
            </select>
        </div>
        <div class="search-wrapper">
            <label for="search">Search:</label>
            <input type="search" id="search">
        </div>
        <div id="currentRange"></div>
        <div class="items-list" data-search></div>
    </div>
    <script>
const rangeDisplay = {
    close: "0-5 miles",
    medium: "5-15 miles",
    far: "15+ miles",
    all: "All"
};

function filterItems() {
    const selectedRange = document.getElementById('Distance').value;
    const selectedCategory = document.getElementById('Category').value;
    const selectedPrice = document.getElementById('Price').value;

    const items = Array.from(document.querySelectorAll('.item'));

    let filtered = items.filter(p => {
        const matchRange = (selectedRange === 'all' || p.dataset.range === selectedRange);
        const matchCategory = (selectedCategory === 'all' || p.dataset.category === selectedCategory);
        return matchRange && matchCategory;
    });

    if (selectedPrice === 'low') {
        filtered.sort((a, b) => Number(a.dataset.priceValue) - Number(b.dataset.priceValue));
    } else if (selectedPrice === 'high') {
        filtered.sort((a, b) => Number(b.dataset.priceValue) - Number(a.dataset.priceValue));
    }

    items.forEach(p => p.style.display = 'none');
    const parent = document.querySelector('.items-list');
    filtered.forEach(p => {
        p.style.display = '';
        parent.appendChild(p);
    });

    document.getElementById('currentRange').textContent =
        "Current Range: " + rangeDisplay[selectedRange] +
        " | Category: " + (selectedCategory === 'all' ? "All" : selectedCategory.charAt(0).toUpperCase() + selectedCategory.slice(1)) +
        " | Price: " + (selectedPrice === 'all' ? "All" : (selectedPrice === 'low' ? "Low to High" : "High to Low"));
}

// Fetch and display items from datagetter.php
document.addEventListener('DOMContentLoaded', function() {
    fetch('datagetter.php')
        .then(res => res.json())
        .then(data => {
            const itemsList = document.querySelector('.items-list');
            itemsList.innerHTML = ''; // Clear any existing items

            // Helper to assign categories/ranges/prices for mock data
            function assignAttributes(div, category, range, price) {
                div.dataset.category = category;
                div.dataset.range = range;
                div.dataset.priceValue = price;
            }

            // Walmart
            data.walmart.forEach((item, idx) => {
                const div = document.createElement('div');
                div.className = 'item';
                div.innerHTML = `
                    <a href="product-detail.php?id=${item.id}" style="text-decoration:none;color:inherit;">
                        <div class="item-title">${item.name}</div>
                        <div class="item-meta">Category: ${capitalize(item.category)} | Range: ${rangeDisplay[item.range]}</div>
                        <div class="item-price">$${item.salePrice}</div>
                        <img src="${item.thumbnailImage}" style="max-width:120px;display:block;margin:8px 0;">
                        <div style="color:#00abf0;font-size:0.95em;">View Details</div>
                    </a>
                `;
                assignAttributes(div, item.category, item.range, item.salePrice);
                itemsList.appendChild(div);
            });

            // Amazon
            data.amazon.forEach((item, idx) => {
                const div = document.createElement('div');
                div.className = 'item';
                div.innerHTML = `
                    <a href="product-detail.php?id=${item.id}" style="text-decoration:none;color:inherit;">
                        <div class="item-title">${item.title}</div>
                        <div class="item-meta">Category: ${capitalize(item.category)} | Range: ${rangeDisplay[item.range]}</div>
                        <div class="item-price">${item.price}</div>
                        <img src="${item.image}" style="max-width:120px;display:block;margin:8px 0;">
                        <div style="color:#00abf0;font-size:0.95em;">View Details</div>
                    </a>
                `;
                let priceValue = Number(item.price.replace(/[^0-9.]/g, '')) || 0;
                assignAttributes(div, item.category, item.range, priceValue);
                itemsList.appendChild(div);
            });

            filterItems(); // Apply filters on load
        });

    document.getElementById('Distance').addEventListener('change', filterItems);
    document.getElementById('Category').addEventListener('change', filterItems);
    document.getElementById('Price').addEventListener('change', filterItems);
});

// Helper function to capitalize category
function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

window.addEventListener('pageshow', function(event) {
    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
        window.location.reload(true);
    }
});
</script>
<script src="theme.js"></script>

</body>
</html>
<!-- main dashboard
This file serves as the main dashboard for VarCart, allowing users to filter and search for items based on distance, category, and price. It dynamically fetches data from `datagetter.php` and displays it in a user-friendly format. The filters and search functionality enhance the user experience by allowing easy navigation through available products.
It includes a responsive design that adapts to different screen sizes, ensuring accessibility on both desktop and mobile devices. The use of modern CSS styles provides a clean and visually appealing interface, while JavaScript handles the dynamic aspects of filtering and displaying items based on user selections.
This file is essential for the core functionality of VarCart, providing a seamless shopping experience for users. It integrates with the backend to fetch real-time data and presents it in an organized manner, making it easy for users to find and view products they are interested in. 
-->