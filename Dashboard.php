<?php
session_start();
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
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f7f7fa;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #3a3a60;
            text-align: center;
            margin-top: 32px;
            margin-bottom: 8px;
            letter-spacing: 2px;
        }
        .filters {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin: 24px 0 8px 0;
        }
        .filters label {
            font-weight: 500;
            color: #444;
            margin-right: 6px;
        }
        select {
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #bdbddd;
            background: #fff;
            font-size: 1em;
            transition: border 0.2s;
        }
        select:focus {
            border: 1.5px solid #6a6ad6;
            outline: none;
        }
        #currentRange {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #444;
            font-size: 1.1em;
        }
        .items-list {
            max-width: 600px;
            margin: 0 auto;
        }
        .item {
            background: #fff;
            border: 1.5px solid #d1d1e0;
            border-radius: 10px;
            margin: 18px 0;
            padding: 18px 22px 12px 22px;
            box-shadow: 0 2px 8px 0 rgba(60,60,100,0.06);
            transition: box-shadow 0.2s, border 0.2s;
            position: relative;
        }
        .item:hover {
            border: 1.5px solid #6a6ad6;
            box-shadow: 0 4px 16px 0 rgba(60,60,100,0.13);
        }
        .item-title {
            font-size: 1.13em;
            font-weight: 600;
            color: #3a3a60;
            margin-bottom: 6px;
        }
        .item-meta {
            font-size: 0.98em;
            color: #666;
            margin-bottom: 4px;
        }
        .item-price {
            font-size: 1.08em;
            color: #2d7a2d;
            font-weight: 500;
            position: absolute;
            right: 22px;
            top: 18px;
        }
        @media (max-width: 700px) {
            .items-list { max-width: 98vw; }
            .item { padding: 14px 8vw 10px 8vw; }
            .filters { flex-direction: column; align-items: center; gap: 10px; }
        }
        .hide {
            display: none;
        }
        .search-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 18px 0 8px 0;
            gap: 10px;
        }

        .search-wrapper label {
            font-weight: 500;
            color: #444;
            margin-right: 6px;
            font-size: 1.05em;
        }

        #search {
            padding: 8px 16px;
            border-radius: 8px;
            border: 1.5px solid #bdbddd;
            background: #fff;
            font-size: 1em;
            transition: border 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(106, 106, 214, 0.06);
            width: 220px;
        }

        #search:focus {
            border: 1.5px solid #6a6ad6;
            outline: none;
            box-shadow: 0 4px 16px rgba(106, 106, 214, 0.13);
        }

        /* Navigation styles */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 12px 24px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav a {
            text-decoration: none;
            color: #3a3a60;
            font-weight: 500;
            margin-right: 16px;
        }

        nav a.cart-icon {
            position: relative;
        }

        nav a.cart-icon .cart-item-count {
            position: absolute;
            top: -6px;
            right: -10px;
            background: #e63946;
            color: #fff;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 0.8em;
        }

        /* Navigation toggle for mobile */
        .nav-toggle {
            display: none;
        }

        .nav-toggle-label {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .nav-toggle-label span {
            height: 3px;
            width: 25px;
            background: #3a3a60;
            margin-bottom: 4px;
            transition: all 0.3s;
        }

        #nav-toggle:checked + .nav-toggle-label span {
            background: transparent;
        }

        #nav-toggle:checked + .nav-toggle-label span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        #nav-toggle:checked + .nav-toggle-label span:nth-child(2) {
            opacity: 0;
        }

        #nav-toggle:checked + .nav-toggle-label span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        @media (max-width: 700px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            nav a {
                margin: 8px 0;
            }

            .nav-toggle {
                display: block;
            }

            .nav-toggle-label {
                display: flex;
            }
        }
    </style>
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
</body>
</html>
<!-- main dashboard
This file serves as the main dashboard for VarCart, allowing users to filter and search for items based on distance, category, and price. It dynamically fetches data from `datagetter.php` and displays it in a user-friendly format. The filters and search functionality enhance the user experience by allowing easy navigation through available products.
It includes a responsive design that adapts to different screen sizes, ensuring accessibility on both desktop and mobile devices. The use of modern CSS styles provides a clean and visually appealing interface, while JavaScript handles the dynamic aspects of filtering and displaying items based on user selections.
This file is essential for the core functionality of VarCart, providing a seamless shopping experience for users. It integrates with the backend to fetch real-time data and presents it in an organized manner, making it easy for users to find and view products they are interested in. 
-->