<?php
session_start();
include('connect.php');
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
    </style>
    <script src="defer.js" defer></script>
</head>
<body>
    <h1>VarCart</h1>
    <a href="logout.php">Logout</a>
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
                    <div class="item-title">${item.name}</div>
                    <div class="item-meta">Category: ${capitalize(item.category)} | Range: ${rangeDisplay[item.range]}</div>
                    <div class="item-price">$${item.salePrice}</div>
                    <img src="${item.thumbnailImage}" style="max-width:120px;display:block;margin:8px 0;">
                    <a href="${item.productUrl}" target="_blank">View on Walmart</a>
                `;
                assignAttributes(div, item.category, item.range, item.salePrice);
                itemsList.appendChild(div);
            });

            // Amazon
            data.amazon.forEach((item, idx) => {
                const div = document.createElement('div');
                div.className = 'item';
                div.innerHTML = `
                    <div class="item-title">${item.title}</div>
                    <div class="item-meta">Category: ${capitalize(item.category)} | Range: ${rangeDisplay[item.range]}</div>
                    <div class="item-price">${item.price}</div>
                    <img src="${item.image}" style="max-width:120px;display:block;margin:8px 0;">
                    <a href="${item.url}" target="_blank">View on Amazon</a>
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
</script>
</body>
</html>

<!-- datagetter.php
-->
