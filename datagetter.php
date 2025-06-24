<?php
header('Content-Type: application/json');

// Mock Walmart products
$walmartProducts = [
    [
        'id' => 'walmart1',
        'name' => 'Organic Bananas',
        'salePrice' => 2.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Bananas',
        'productUrl' => 'https://www.walmart.com/ip/food1',
        'category' => 'food',
        'range' => 'close'
    ],
    [
        'id' => 'walmart2',
        'name' => 'Men\'s T-Shirt',
        'salePrice' => 12.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=T-Shirt',
        'productUrl' => 'https://www.walmart.com/ip/clothing1',
        'category' => 'clothing',
        'range' => 'medium'
    ],
    [
        'id' => 'walmart3',
        'name' => 'Bluetooth Speaker',
        'salePrice' => 29.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Speaker',
        'productUrl' => 'https://www.walmart.com/ip/electronics1',
        'category' => 'electronics',
        'range' => 'far'
    ],
    [
        'id' => 'walmart4',
        'name' => 'Ceramic Vase',
        'salePrice' => 18.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Vase',
        'productUrl' => 'https://www.walmart.com/ip/home1',
        'category' => 'home',
        'range' => 'close'
    ],
    [
        'id' => 'walmart5',
        'name' => 'Building Blocks',
        'salePrice' => 15.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Blocks',
        'productUrl' => 'https://www.walmart.com/ip/toys1',
        'category' => 'toys',
        'range' => 'medium'
    ],
    [
        'id' => 'walmart6',
        'name' => 'Children\'s Story Book',
        'salePrice' => 7.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Book',
        'productUrl' => 'https://www.walmart.com/ip/books1',
        'category' => 'books',
        'range' => 'far'
    ],
    [
        'id' => 'walmart7',
        'name' => 'Basketball',
        'salePrice' => 19.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Basketball',
        'productUrl' => 'https://www.walmart.com/ip/sports1',
        'category' => 'sports',
        'range' => 'medium'
    ],
    [
        'id' => 'walmart8',
        'name' => 'Vitamins C',
        'salePrice' => 8.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Vitamins',
        'productUrl' => 'https://www.walmart.com/ip/health1',
        'category' => 'health',
        'range' => 'close'
    ],
    [
        'id' => 'walmart9',
        'name' => 'Face Cream',
        'salePrice' => 14.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Face+Cream',
        'productUrl' => 'https://www.walmart.com/ip/beauty1',
        'category' => 'beauty',
        'range' => 'far'
    ],
    [
        'id' => 'walmart10',
        'name' => 'Car Air Freshener',
        'salePrice' => 4.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Air+Freshener',
        'productUrl' => 'https://www.walmart.com/ip/automotive1',
        'category' => 'automotive',
        'range' => 'medium'
    ],
    [
        'id' => 'walmart11',
        'name' => 'Garden Hose',
        'salePrice' => 24.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Garden+Hose',
        'productUrl' => 'https://www.walmart.com/ip/garden1',
        'category' => 'garden',
        'range' => 'close'
    ],
    [
        'id' => 'walmart12',
        'name' => 'Dog Chew Toy',
        'salePrice' => 6.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Dog+Toy',
        'productUrl' => 'https://www.walmart.com/ip/pets1',
        'category' => 'pets',
        'range' => 'far'
    ],
    [
        'id' => 'walmart13',
        'name' => 'Office Chair',
        'salePrice' => 59.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Office+Chair',
        'productUrl' => 'https://www.walmart.com/ip/office1',
        'category' => 'office',
        'range' => 'medium'
    ],
    [
        'id' => 'walmart14',
        'name' => 'Acoustic Guitar',
        'salePrice' => 99.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Guitar',
        'productUrl' => 'https://www.walmart.com/ip/music1',
        'category' => 'music',
        'range' => 'far'
    ],
    // More Walmart items
    [
        'id' => 'walmart15',
        'name' => 'Apple Juice',
        'salePrice' => 3.49,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Apple+Juice',
        'productUrl' => 'https://www.walmart.com/ip/food2',
        'category' => 'food',
        'range' => 'medium'
    ],
    [
        'id' => 'walmart16',
        'name' => 'Women\'s Dress',
        'salePrice' => 24.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Dress',
        'productUrl' => 'https://www.walmart.com/ip/clothing2',
        'category' => 'clothing',
        'range' => 'far'
    ],
    [
        'id' => 'walmart17',
        'name' => 'Smart TV',
        'salePrice' => 299.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Smart+TV',
        'productUrl' => 'https://www.walmart.com/ip/electronics2',
        'category' => 'electronics',
        'range' => 'close'
    ],
    [
        'id' => 'walmart18',
        'name' => 'Table Lamp',
        'salePrice' => 22.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Lamp',
        'productUrl' => 'https://www.walmart.com/ip/home2',
        'category' => 'home',
        'range' => 'medium'
    ],
    [
        'id' => 'walmart19',
        'name' => 'Puzzle Set',
        'salePrice' => 9.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Puzzle',
        'productUrl' => 'https://www.walmart.com/ip/toys2',
        'category' => 'toys',
        'range' => 'far'
    ]
];

// Mock Amazon products
$amazonProducts = [
    [
        'id' => 'amazon1',
        'title' => 'Organic Honey',
        'price' => '$11.99',
        'image' => 'https://via.placeholder.com/120x120?text=Honey',
        'url' => 'https://www.amazon.com/dp/food2',
        'category' => 'food',
        'range' => 'medium'
    ],
    [
        'id' => 'amazon2',
        'title' => 'Women\'s Jeans',
        'price' => '$34.99',
        'image' => 'https://via.placeholder.com/120x120?text=Jeans',
        'url' => 'https://www.amazon.com/dp/clothing2',
        'category' => 'clothing',
        'range' => 'far'
    ],
    [
        'id' => 'amazon3',
        'title' => 'Wireless Mouse',
        'price' => '$17.99',
        'image' => 'https://via.placeholder.com/120x120?text=Mouse',
        'url' => 'https://www.amazon.com/dp/electronics2',
        'category' => 'electronics',
        'range' => 'close'
    ],
    [
        'id' => 'amazon4',
        'title' => 'Throw Pillow',
        'price' => '$13.99',
        'image' => 'https://via.placeholder.com/120x120?text=Pillow',
        'url' => 'https://www.amazon.com/dp/home2',
        'category' => 'home',
        'range' => 'medium'
    ],
    [
        'id' => 'amazon5',
        'title' => 'RC Car',
        'price' => '$29.99',
        'image' => 'https://via.placeholder.com/120x120?text=RC+Car',
        'url' => 'https://www.amazon.com/dp/toys2',
        'category' => 'toys',
        'range' => 'far'
    ],
    [
        'id' => 'amazon6',
        'title' => 'Science Fiction Novel',
        'price' => '$9.99',
        'image' => 'https://via.placeholder.com/120x120?text=Sci-Fi+Book',
        'url' => 'https://www.amazon.com/dp/books2',
        'category' => 'books',
        'range' => 'close'
    ],
    [
        'id' => 'amazon7',
        'title' => 'Yoga Mat',
        'price' => '$21.99',
        'image' => 'https://via.placeholder.com/120x120?text=Yoga+Mat',
        'url' => 'https://www.amazon.com/dp/sports2',
        'category' => 'sports',
        'range' => 'medium'
    ],
    [
        'id' => 'amazon8',
        'title' => 'Protein Powder',
        'price' => '$27.99',
        'image' => 'https://via.placeholder.com/120x120?text=Protein',
        'url' => 'https://www.amazon.com/dp/health2',
        'category' => 'health',
        'range' => 'far'
    ],
    [
        'id' => 'amazon9',
        'title' => 'Lipstick Set',
        'price' => '$15.99',
        'image' => 'https://via.placeholder.com/120x120?text=Lipstick',
        'url' => 'https://www.amazon.com/dp/beauty2',
        'category' => 'beauty',
        'range' => 'close'
    ],
    [
        'id' => 'amazon10',
        'title' => 'Car Vacuum Cleaner',
        'price' => '$24.99',
        'image' => 'https://via.placeholder.com/120x120?text=Car+Vacuum',
        'url' => 'https://www.amazon.com/dp/automotive2',
        'category' => 'automotive',
        'range' => 'medium'
    ],
    [
        'id' => 'amazon11',
        'title' => 'Garden Gloves',
        'price' => '$8.99',
        'image' => 'https://via.placeholder.com/120x120?text=Gloves',
        'url' => 'https://www.amazon.com/dp/garden2',
        'category' => 'garden',
        'range' => 'far'
    ],
    [
        'id' => 'amazon12',
        'title' => 'Cat Scratching Post',
        'price' => '$19.99',
        'image' => 'https://via.placeholder.com/120x120?text=Cat+Post',
        'url' => 'https://www.amazon.com/dp/pets2',
        'category' => 'pets',
        'range' => 'close'
    ],
    [
        'id' => 'amazon13',
        'title' => 'Desk Organizer',
        'price' => '$10.99',
        'image' => 'https://via.placeholder.com/120x120?text=Organizer',
        'url' => 'https://www.amazon.com/dp/office2',
        'category' => 'office',
        'range' => 'far'
    ],
    [
        'id' => 'amazon14',
        'title' => 'Electric Keyboard',
        'price' => '$79.99',
        'image' => 'https://via.placeholder.com/120x120?text=Keyboard',
        'url' => 'https://www.amazon.com/dp/music2',
        'category' => 'music',
        'range' => 'medium'
    ],
    // More Amazon items
    [
        'id' => 'amazon15',
        'title' => 'Granola Bars',
        'price' => '$6.49',
        'image' => 'https://via.placeholder.com/120x120?text=Granola+Bars',
        'url' => 'https://www.amazon.com/dp/food3',
        'category' => 'food',
        'range' => 'far'
    ],
    [
        'id' => 'amazon16',
        'title' => 'Men\'s Hoodie',
        'price' => '$27.99',
        'image' => 'https://via.placeholder.com/120x120?text=Hoodie',
        'url' => 'https://www.amazon.com/dp/clothing3',
        'category' => 'clothing',
        'range' => 'close'
    ],
    [
        'id' => 'amazon17',
        'title' => 'Bluetooth Earbuds',
        'price' => '$39.99',
        'image' => 'https://via.placeholder.com/120x120?text=Earbuds',
        'url' => 'https://www.amazon.com/dp/electronics3',
        'category' => 'electronics',
        'range' => 'medium'
    ],
    [
        'id' => 'amazon18',
        'title' => 'Wall Clock',
        'price' => '$14.99',
        'image' => 'https://via.placeholder.com/120x120?text=Clock',
        'url' => 'https://www.amazon.com/dp/home3',
        'category' => 'home',
        'range' => 'far'
    ],
    [
        'id' => 'amazon19',
        'title' => 'Plush Teddy Bear',
        'price' => '$12.99',
        'image' => 'https://via.placeholder.com/120x120?text=Teddy+Bear',
        'url' => 'https://www.amazon.com/dp/toys3',
        'category' => 'toys',
        'range' => 'close'
    ]
];

echo json_encode([
    'walmart' => $walmartProducts,
    'amazon' => $amazonProducts
]);