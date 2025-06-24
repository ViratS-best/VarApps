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
    </style>
</head>
<body>
    <h1>VarCart</h1>
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
    <div id="currentRange"></div>
    <div class="items-list">
        <div class="item" id="4" data-range="close" data-category="food" data-price-value="25">
            <div class="item-title">Fresh Apples</div>
            <div class="item-meta">Category: Food | Range: 0-5 miles</div>
            <div class="item-price">$25</div>
            Locally grown apples, crisp and sweet.
        </div>
        <div class="item" id="7" data-range="medium" data-category="electronics" data-price-value="80">
            <div class="item-title">Bluetooth Headphones</div>
            <div class="item-meta">Category: Electronics | Range: 5-15 miles</div>
            <div class="item-price">$80</div>
            Wireless headphones with noise cancellation.
        </div>
        <div class="item" id="17" data-range="far" data-category="clothing" data-price-value="40">
            <div class="item-title">Denim Jacket</div>
            <div class="item-meta">Category: Clothing | Range: 15+ miles</div>
            <div class="item-price">$40</div>
            Stylish denim jacket for all seasons.
        </div>
        <div class="item" id="6" data-range="medium" data-category="home" data-price-value="60">
            <div class="item-title">Table Lamp</div>
            <div class="item-meta">Category: Home | Range: 5-15 miles</div>
            <div class="item-price">$60</div>
            Modern LED table lamp with adjustable brightness.
        </div>
        <div class="item" id="3" data-range="close" data-category="toys" data-price-value="15">
            <div class="item-title">Building Blocks Set</div>
            <div class="item-meta">Category: Toys | Range: 0-5 miles</div>
            <div class="item-price">$15</div>
            Creative building blocks for kids aged 3+.
        </div>
        <div class="item" id="10" data-range="medium" data-category="books" data-price-value="22">
            <div class="item-title">Mystery Novel</div>
            <div class="item-meta">Category: Books | Range: 5-15 miles</div>
            <div class="item-price">$22</div>
            A thrilling mystery novel by a bestselling author.
        </div>
        <div class="item" id="11" data-range="far" data-category="sports" data-price-value="55">
            <div class="item-title">Yoga Mat</div>
            <div class="item-meta">Category: Sports | Range: 15+ miles</div>
            <div class="item-price">$55</div>
            Non-slip yoga mat for all fitness levels.
        </div>
        <a href="logout.php">Logout</a>
    </div>
    <script>
        // Mapping of value to display text
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

            // Get all items as array
            const items = Array.from(document.querySelectorAll('.item'));

            // Filter items
            let filtered = items.filter(p => {
                const matchRange = (selectedRange === 'all' || p.dataset.range === selectedRange);
                const matchCategory = (selectedCategory === 'all' || p.dataset.category === selectedCategory);
                return matchRange && matchCategory;
            });

            // Sort items if needed
            if (selectedPrice === 'low') {
                filtered.sort((a, b) => Number(a.dataset.priceValue) - Number(b.dataset.priceValue));
            } else if (selectedPrice === 'high') {
                filtered.sort((a, b) => Number(b.dataset.priceValue) - Number(a.dataset.priceValue));
            }

            // Hide all items first
            items.forEach(p => p.style.display = 'none');

            // Show filtered and sorted items in order
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

        document.getElementById('Distance').addEventListener('change', filterItems);
        document.getElementById('Category').addEventListener('change', filterItems);
        document.getElementById('Price').addEventListener('change', filterItems);

        // Filter on page load
        filterItems();
    </script>
</body>
</html>