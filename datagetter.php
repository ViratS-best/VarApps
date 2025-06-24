<?php
header('Content-Type: application/json');

// Mock Walmart products
$walmartProducts = [
    [
        'name' => 'Organic Bananas',
        'salePrice' => 2.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Bananas',
        'productUrl' => 'https://www.walmart.com/ip/food1',
        'category' => 'food',
        'range' => 'close'
    ],
    [
        'name' => 'Men\'s T-Shirt',
        'salePrice' => 12.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=T-Shirt',
        'productUrl' => 'https://www.walmart.com/ip/clothing1',
        'category' => 'clothing',
        'range' => 'medium'
    ],
    [
        'name' => 'Bluetooth Speaker',
        'salePrice' => 29.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Speaker',
        'productUrl' => 'https://www.walmart.com/ip/electronics1',
        'category' => 'electronics',
        'range' => 'far'
    ],
    [
        'name' => 'Ceramic Vase',
        'salePrice' => 18.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Vase',
        'productUrl' => 'https://www.walmart.com/ip/home1',
        'category' => 'home',
        'range' => 'close'
    ],
    [
        'name' => 'Building Blocks',
        'salePrice' => 15.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Blocks',
        'productUrl' => 'https://www.walmart.com/ip/toys1',
        'category' => 'toys',
        'range' => 'medium'
    ],
    [
        'name' => 'Children\'s Story Book',
        'salePrice' => 7.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Book',
        'productUrl' => 'https://www.walmart.com/ip/books1',
        'category' => 'books',
        'range' => 'far'
    ],
    [
        'name' => 'Basketball',
        'salePrice' => 19.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Basketball',
        'productUrl' => 'https://www.walmart.com/ip/sports1',
        'category' => 'sports',
        'range' => 'medium'
    ],
    [
        'name' => 'Vitamins C',
        'salePrice' => 8.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Vitamins',
        'productUrl' => 'https://www.walmart.com/ip/health1',
        'category' => 'health',
        'range' => 'close'
    ],
    [
        'name' => 'Face Cream',
        'salePrice' => 14.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Face+Cream',
        'productUrl' => 'https://www.walmart.com/ip/beauty1',
        'category' => 'beauty',
        'range' => 'far'
    ],
    [
        'name' => 'Car Air Freshener',
        'salePrice' => 4.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Air+Freshener',
        'productUrl' => 'https://www.walmart.com/ip/automotive1',
        'category' => 'automotive',
        'range' => 'medium'
    ],
    [
        'name' => 'Garden Hose',
        'salePrice' => 24.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Garden+Hose',
        'productUrl' => 'https://www.walmart.com/ip/garden1',
        'category' => 'garden',
        'range' => 'close'
    ],
    [
        'name' => 'Dog Chew Toy',
        'salePrice' => 6.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Dog+Toy',
        'productUrl' => 'https://www.walmart.com/ip/pets1',
        'category' => 'pets',
        'range' => 'far'
    ],
    [
        'name' => 'Office Chair',
        'salePrice' => 59.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Office+Chair',
        'productUrl' => 'https://www.walmart.com/ip/office1',
        'category' => 'office',
        'range' => 'medium'
    ],
    [
        'name' => 'Acoustic Guitar',
        'salePrice' => 99.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Guitar',
        'productUrl' => 'https://www.walmart.com/ip/music1',
        'category' => 'music',
        'range' => 'far'
    ]
];

// Mock Amazon products
$amazonProducts = [
    [
        'title' => 'Organic Honey',
        'price' => '$11.99',
        'image' => 'https://via.placeholder.com/120x120?text=Honey',
        'url' => 'https://www.amazon.com/dp/food2',
        'category' => 'food',
        'range' => 'medium'
    ],
    [
        'title' => 'Women\'s Jeans',
        'price' => '$34.99',
        'image' => 'https://via.placeholder.com/120x120?text=Jeans',
        'url' => 'https://www.amazon.com/dp/clothing2',
        'category' => 'clothing',
        'range' => 'far'
    ],
    [
        'title' => 'Wireless Mouse',
        'price' => '$17.99',
        'image' => 'https://via.placeholder.com/120x120?text=Mouse',
        'url' => 'https://www.amazon.com/dp/electronics2',
        'category' => 'electronics',
        'range' => 'close'
    ],
    [
        'title' => 'Throw Pillow',
        'price' => '$13.99',
        'image' => 'https://via.placeholder.com/120x120?text=Pillow',
        'url' => 'https://www.amazon.com/dp/home2',
        'category' => 'home',
        'range' => 'medium'
    ],
    [
        'title' => 'RC Car',
        'price' => '$29.99',
        'image' => 'https://via.placeholder.com/120x120?text=RC+Car',
        'url' => 'https://www.amazon.com/dp/toys2',
        'category' => 'toys',
        'range' => 'far'
    ],
    [
        'title' => 'Science Fiction Novel',
        'price' => '$9.99',
        'image' => 'https://via.placeholder.com/120x120?text=Sci-Fi+Book',
        'url' => 'https://www.amazon.com/dp/books2',
        'category' => 'books',
        'range' => 'close'
    ],
    [
        'title' => 'Yoga Mat',
        'price' => '$21.99',
        'image' => 'https://via.placeholder.com/120x120?text=Yoga+Mat',
        'url' => 'https://www.amazon.com/dp/sports2',
        'category' => 'sports',
        'range' => 'medium'
    ],
    [
        'title' => 'Protein Powder',
        'price' => '$27.99',
        'image' => 'https://via.placeholder.com/120x120?text=Protein',
        'url' => 'https://www.amazon.com/dp/health2',
        'category' => 'health',
        'range' => 'far'
    ],
    [
        'title' => 'Lipstick Set',
        'price' => '$15.99',
        'image' => 'https://via.placeholder.com/120x120?text=Lipstick',
        'url' => 'https://www.amazon.com/dp/beauty2',
        'category' => 'beauty',
        'range' => 'close'
    ],
    [
        'title' => 'Car Vacuum Cleaner',
        'price' => '$24.99',
        'image' => 'https://via.placeholder.com/120x120?text=Car+Vacuum',
        'url' => 'https://www.amazon.com/dp/automotive2',
        'category' => 'automotive',
        'range' => 'medium'
    ],
    [
        'title' => 'Garden Gloves',
        'price' => '$8.99',
        'image' => 'https://via.placeholder.com/120x120?text=Gloves',
        'url' => 'https://www.amazon.com/dp/garden2',
        'category' => 'garden',
        'range' => 'far'
    ],
    [
        'title' => 'Cat Scratching Post',
        'price' => '$19.99',
        'image' => 'https://via.placeholder.com/120x120?text=Cat+Post',
        'url' => 'https://www.amazon.com/dp/pets2',
        'category' => 'pets',
        'range' => 'close'
    ],
    [
        'title' => 'Desk Organizer',
        'price' => '$10.99',
        'image' => 'https://via.placeholder.com/120x120?text=Organizer',
        'url' => 'https://www.amazon.com/dp/office2',
        'category' => 'office',
        'range' => 'far'
    ],
    [
        'title' => 'Electric Keyboard',
        'price' => '$79.99',
        'image' => 'https://via.placeholder.com/120x120?text=Keyboard',
        'url' => 'https://www.amazon.com/dp/music2',
        'category' => 'music',
        'range' => 'medium'
    ]
];

echo json_encode([
    'walmart' => $walmartProducts,
    'amazon' => $amazonProducts
]);