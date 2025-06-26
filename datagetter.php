<?php
header('Content-Type: application/json');

// Walmart products
$walmartProducts = [
    [
        'id' => 'walmart1',
        'name' => 'Organic Bananas',
        'salePrice' => 2.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Bananas',
        'productUrl' => 'https://www.walmart.com/ip/food1',
        'category' => 'food',
        'range' => 'close',
        'description' => 'Fresh organic bananas, perfect for a healthy snack or smoothie. Sourced from local farms for maximum freshness.'
    ],
    [
        'id' => 'walmart2',
        'name' => 'Men\'s T-Shirt',
        'salePrice' => 12.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=T-Shirt',
        'productUrl' => 'https://www.walmart.com/ip/clothing1',
        'category' => 'clothing',
        'range' => 'medium',
        'description' => 'Comfortable and stylish men\'s t-shirt made from 100% cotton. Available in multiple colors and sizes.'
    ],
    [
        'id' => 'walmart3',
        'name' => 'Bluetooth Speaker',
        'salePrice' => 29.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Speaker',
        'productUrl' => 'https://www.walmart.com/ip/electronics1',
        'category' => 'electronics',
        'range' => 'far',
        'description' => 'Portable Bluetooth speaker with high-quality sound and long battery life. Perfect for parties and outdoor activities.'
    ],
    [
        'id' => 'walmart4',
        'name' => 'Ceramic Vase',
        'salePrice' => 18.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Vase',
        'productUrl' => 'https://www.walmart.com/ip/home1',
        'category' => 'home',
        'range' => 'close',
        'description' => 'Elegant ceramic vase ideal for fresh flowers or as a decorative piece in your living room or dining area.'
    ],
    [
        'id' => 'walmart5',
        'name' => 'Building Blocks',
        'salePrice' => 15.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Blocks',
        'productUrl' => 'https://www.walmart.com/ip/toys1',
        'category' => 'toys',
        'range' => 'medium',
        'description' => 'Colorful building blocks set for kids. Encourages creativity and improves motor skills. Safe and durable.'
    ],
    [
        'id' => 'walmart6',
        'name' => 'Children\'s Story Book',
        'salePrice' => 7.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Book',
        'productUrl' => 'https://www.walmart.com/ip/books1',
        'category' => 'books',
        'range' => 'far',
        'description' => 'A delightful story book for children, filled with colorful illustrations and engaging tales.'
    ],
    [
        'id' => 'walmart7',
        'name' => 'Basketball',
        'salePrice' => 19.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Basketball',
        'productUrl' => 'https://www.walmart.com/ip/sports1',
        'category' => 'sports',
        'range' => 'medium',
        'description' => 'Official size basketball suitable for indoor and outdoor play. Durable rubber cover for better grip.'
    ],
    [
        'id' => 'walmart8',
        'name' => 'Vitamins C',
        'salePrice' => 8.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Vitamins',
        'productUrl' => 'https://www.walmart.com/ip/health1',
        'category' => 'health',
        'range' => 'close',
        'description' => 'Vitamin C tablets to support your immune system. 100 tablets per bottle, easy to swallow.'
    ],
    [
        'id' => 'walmart9',
        'name' => 'Face Cream',
        'salePrice' => 14.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Face+Cream',
        'productUrl' => 'https://www.walmart.com/ip/beauty1',
        'category' => 'beauty',
        'range' => 'far',
        'description' => 'Hydrating face cream for all skin types. Provides 24-hour moisture and a radiant glow.'
    ],
    [
        'id' => 'walmart10',
        'name' => 'Car Air Freshener',
        'salePrice' => 4.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Air+Freshener',
        'productUrl' => 'https://www.walmart.com/ip/automotive1',
        'category' => 'automotive',
        'range' => 'medium',
        'description' => 'Long-lasting car air freshener with a refreshing scent. Easy to hang and replace.'
    ],
    [
        'id' => 'walmart11',
        'name' => 'Garden Hose',
        'salePrice' => 24.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Garden+Hose',
        'productUrl' => 'https://www.walmart.com/ip/garden1',
        'category' => 'garden',
        'range' => 'close',
        'description' => 'Flexible and durable garden hose, 50 feet long. Perfect for watering plants and cleaning outdoors.'
    ],
    [
        'id' => 'walmart12',
        'name' => 'Dog Chew Toy',
        'salePrice' => 6.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Dog+Toy',
        'productUrl' => 'https://www.walmart.com/ip/pets1',
        'category' => 'pets',
        'range' => 'far',
        'description' => 'Durable chew toy for dogs. Helps clean teeth and keeps your pet entertained for hours.'
    ],
    [
        'id' => 'walmart13',
        'name' => 'Office Chair',
        'salePrice' => 59.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Office+Chair',
        'productUrl' => 'https://www.walmart.com/ip/office1',
        'category' => 'office',
        'range' => 'medium',
        'description' => 'Ergonomic office chair with adjustable height and lumbar support. Comfortable for long working hours.'
    ],
    [
        'id' => 'walmart14',
        'name' => 'Acoustic Guitar',
        'salePrice' => 99.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Guitar',
        'productUrl' => 'https://www.walmart.com/ip/music1',
        'category' => 'music',
        'range' => 'far',
        'description' => 'Full-size acoustic guitar with a rich, warm sound. Great for beginners and experienced players.'
    ],
    [
        'id' => 'walmart15',
        'name' => 'Apple Juice',
        'salePrice' => 3.49,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Apple+Juice',
        'productUrl' => 'https://www.walmart.com/ip/food2',
        'category' => 'food',
        'range' => 'medium',
        'description' => 'Refreshing apple juice made from real apples. No added sugar or preservatives.'
    ],
    [
        'id' => 'walmart16',
        'name' => 'Women\'s Dress',
        'salePrice' => 24.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Dress',
        'productUrl' => 'https://www.walmart.com/ip/clothing2',
        'category' => 'clothing',
        'range' => 'far',
        'description' => 'Elegant women\'s dress suitable for both casual and formal occasions. Soft and breathable fabric.'
    ],
    [
        'id' => 'walmart17',
        'name' => 'Smart TV',
        'salePrice' => 299.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Smart+TV',
        'productUrl' => 'https://www.walmart.com/ip/electronics2',
        'category' => 'electronics',
        'range' => 'close',
        'description' => 'High-definition smart TV with built-in streaming apps. Crisp visuals and vibrant colors.'
    ],
    [
        'id' => 'walmart18',
        'name' => 'Table Lamp',
        'salePrice' => 22.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Lamp',
        'productUrl' => 'https://www.walmart.com/ip/home2',
        'category' => 'home',
        'range' => 'medium',
        'description' => 'Modern table lamp with adjustable brightness. Perfect for your bedside or study desk.'
    ],
    [
        'id' => 'walmart19',
        'name' => 'Puzzle Set',
        'salePrice' => 9.99,
        'thumbnailImage' => 'https://via.placeholder.com/120x120?text=Puzzle',
        'productUrl' => 'https://www.walmart.com/ip/toys2',
        'category' => 'toys',
        'range' => 'far',
        'description' => 'Challenging puzzle set for kids and adults. Improves problem-solving skills and patience.'
    ]
];

// Amazon products
$amazonProducts = [
    [
        'id' => 'amazon1',
        'title' => 'Organic Honey',
        'price' => '$11.99',
        'image' => 'https://via.placeholder.com/120x120?text=Honey',
        'url' => 'https://www.amazon.com/dp/food2',
        'category' => 'food',
        'range' => 'medium',
        'description' => 'Pure organic honey, perfect for sweetening tea or spreading on toast. No artificial additives.'
    ],
    [
        'id' => 'amazon2',
        'title' => 'Women\'s Jeans',
        'price' => '$34.99',
        'image' => 'https://via.placeholder.com/120x120?text=Jeans',
        'url' => 'https://www.amazon.com/dp/clothing2',
        'category' => 'clothing',
        'range' => 'far',
        'description' => 'Classic fit women\'s jeans with a comfortable stretch. Durable and stylish for everyday wear.'
    ],
    [
        'id' => 'amazon3',
        'title' => 'Wireless Mouse',
        'price' => '$17.99',
        'image' => 'https://via.placeholder.com/120x120?text=Mouse',
        'url' => 'https://www.amazon.com/dp/electronics2',
        'category' => 'electronics',
        'range' => 'close',
        'description' => 'Ergonomic wireless mouse with adjustable DPI settings. Smooth tracking and long battery life.'
    ],
    [
        'id' => 'amazon4',
        'title' => 'Throw Pillow',
        'price' => '$13.99',
        'image' => 'https://via.placeholder.com/120x120?text=Pillow',
        'url' => 'https://www.amazon.com/dp/home2',
        'category' => 'home',
        'range' => 'medium',
        'description' => 'Soft and decorative throw pillow. Adds comfort and style to your sofa or bed.'
    ],
    [
        'id' => 'amazon5',
        'title' => 'RC Car',
        'price' => '$29.99',
        'image' => 'https://via.placeholder.com/120x120?text=RC+Car',
        'url' => 'https://www.amazon.com/dp/toys2',
        'category' => 'toys',
        'range' => 'far',
        'description' => 'High-speed remote control car with rechargeable battery. Fun for kids and adults alike.'
    ],
    [
        'id' => 'amazon6',
        'title' => 'Science Fiction Novel',
        'price' => '$9.99',
        'image' => 'https://via.placeholder.com/120x120?text=Sci-Fi+Book',
        'url' => 'https://www.amazon.com/dp/books2',
        'category' => 'books',
        'range' => 'close',
        'description' => 'Bestselling science fiction novel with an exciting plot and unforgettable characters.'
    ],
    [
        'id' => 'amazon7',
        'title' => 'Yoga Mat',
        'price' => '$21.99',
        'image' => 'https://via.placeholder.com/120x120?text=Yoga+Mat',
        'url' => 'https://www.amazon.com/dp/sports2',
        'category' => 'sports',
        'range' => 'medium',
        'description' => 'Non-slip yoga mat with extra cushioning. Ideal for yoga, pilates, and stretching exercises.'
    ],
    [
        'id' => 'amazon8',
        'title' => 'Protein Powder',
        'price' => '$27.99',
        'image' => 'https://via.placeholder.com/120x120?text=Protein',
        'url' => 'https://www.amazon.com/dp/health2',
        'category' => 'health',
        'range' => 'far',
        'description' => 'High-quality protein powder for muscle recovery and growth. Great taste and easy to mix.'
    ],
    [
        'id' => 'amazon9',
        'title' => 'Lipstick Set',
        'price' => '$15.99',
        'image' => 'https://via.placeholder.com/120x120?text=Lipstick',
        'url' => 'https://www.amazon.com/dp/beauty2',
        'category' => 'beauty',
        'range' => 'close',
        'description' => 'Vibrant lipstick set with multiple shades. Long-lasting and moisturizing formula.'
    ],
    [
        'id' => 'amazon10',
        'title' => 'Car Vacuum Cleaner',
        'price' => '$24.99',
        'image' => 'https://via.placeholder.com/120x120?text=Car+Vacuum',
        'url' => 'https://www.amazon.com/dp/automotive2',
        'category' => 'automotive',
        'range' => 'medium',
        'description' => 'Portable car vacuum cleaner with powerful suction. Includes multiple attachments for thorough cleaning.'
    ],
    [
        'id' => 'amazon11',
        'title' => 'Garden Gloves',
        'price' => '$8.99',
        'image' => 'https://via.placeholder.com/120x120?text=Gloves',
        'url' => 'https://www.amazon.com/dp/garden2',
        'category' => 'garden',
        'range' => 'far',
        'description' => 'Durable garden gloves with non-slip grip. Protects your hands while gardening or landscaping.'
    ],
    [
        'id' => 'amazon12',
        'title' => 'Cat Scratching Post',
        'price' => '$19.99',
        'image' => 'https://via.placeholder.com/120x120?text=Cat+Post',
        'url' => 'https://www.amazon.com/dp/pets2',
        'category' => 'pets',
        'range' => 'close',
        'description' => 'Sturdy cat scratching post to keep your cat entertained and your furniture safe.'
    ],
    [
        'id' => 'amazon13',
        'title' => 'Desk Organizer',
        'price' => '$10.99',
        'image' => 'https://via.placeholder.com/120x120?text=Organizer',
        'url' => 'https://www.amazon.com/dp/office2',
        'category' => 'office',
        'range' => 'far',
        'description' => 'Multi-compartment desk organizer to keep your workspace tidy and efficient.'
    ],
    [
        'id' => 'amazon14',
        'title' => 'Electric Keyboard',
        'price' => '$79.99',
        'image' => 'https://via.placeholder.com/120x120?text=Keyboard',
        'url' => 'https://www.amazon.com/dp/music2',
        'category' => 'music',
        'range' => 'medium',
        'description' => '61-key electric keyboard with built-in speakers. Perfect for beginners and music enthusiasts.'
    ],
    [
        'id' => 'amazon15',
        'title' => 'Granola Bars',
        'price' => '$6.49',
        'image' => 'https://via.placeholder.com/120x120?text=Granola+Bars',
        'url' => 'https://www.amazon.com/dp/food3',
        'category' => 'food',
        'range' => 'far',
        'description' => 'Healthy granola bars packed with oats and nuts. Great for on-the-go snacking.'
    ],
    [
        'id' => 'amazon16',
        'title' => 'Men\'s Hoodie',
        'price' => '$27.99',
        'image' => 'https://via.placeholder.com/120x120?text=Hoodie',
        'url' => 'https://www.amazon.com/dp/clothing3',
        'category' => 'clothing',
        'range' => 'close',
        'description' => 'Warm and cozy men\'s hoodie with a front pocket. Ideal for casual wear and outdoor activities.'
    ],
    [
        'id' => 'amazon17',
        'title' => 'Bluetooth Earbuds',
        'price' => '$39.99',
        'image' => 'https://via.placeholder.com/120x120?text=Earbuds',
        'url' => 'https://www.amazon.com/dp/electronics3',
        'category' => 'electronics',
        'range' => 'medium',
        'description' => 'Wireless Bluetooth earbuds with noise cancellation. Compact charging case included.'
    ],
    [
        'id' => 'amazon18',
        'title' => 'Wall Clock',
        'price' => '$14.99',
        'image' => 'https://via.placeholder.com/120x120?text=Clock',
        'url' => 'https://www.amazon.com/dp/home3',
        'category' => 'home',
        'range' => 'far',
        'description' => 'Modern wall clock with a silent sweep movement. Stylish addition to any room.'
    ],
    [
        'id' => 'amazon19',
        'title' => 'Plush Teddy Bear',
        'price' => '$12.99',
        'image' => 'https://via.placeholder.com/120x120?text=Teddy+Bear',
        'url' => 'https://www.amazon.com/dp/toys3',
        'category' => 'toys',
        'range' => 'close',
        'description' => 'Soft and cuddly plush teddy bear. A perfect gift for children and loved ones.'
    ]
];

echo json_encode([
    'walmart' => $walmartProducts,
    'amazon' => $amazonProducts
]);