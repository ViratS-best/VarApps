<?php
header('Content-Type: application/json');

// Walmart products
$walmartProducts = [
    [
        'id' => 'walmart1',
        'name' => 'Organic Bananas',
        'salePrice' => 0.28,
        'thumbnailImage' => 'https://i5.walmartimages.com/asr/4b15d1c6-03e7-489b-96cb-7d4b1edeb927.042464e5bc52fa0421f255d04ec525a4.jpeg?odnHeight=768&odnWidth=768&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Fresh-Banana-Each/44390948?classType=REGULAR&from=/search',
        'category' => 'food',
        'range' => 'close',
        'description' => 'Fresh organic bananas, perfect for a healthy snack or smoothie. Sourced from local farms for maximum freshness.'
    ],
    [
        'id' => 'walmart2',
        'name' => 'Men\'s T-Shirt',
        'salePrice' => 12.16,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Russell-Athletic-Men-s-and-Big-Men-s-Long-Sleeve-Performance-T-Shirt_fe209946-5871-4901-a610-2aecce09ffad_1.0d36d374e216d44c5b0aa66254e0d5bd.jpeg',
        'productUrl' => 'https://www.walmart.com/ip/Russell-Athletic-Men-s-and-Big-Men-s-Long-Sleeve-Performance-T-Shirt/445531455',
        'category' => 'clothing',
        'range' => 'medium',
        'description' => 'Comfortable and stylish men\'s t-shirt made from 100% cotton. Available in multiple colors and sizes.'
    ],
    [
        'id' => 'walmart3',
        'name' => 'Bluetooth Speaker',
        'salePrice' => 129.00,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/onn-Large-Party-Speaker-Gen-2-with-LED-Lighting_a2541e11-2e8b-4859-a256-c49cee8b9a7d.68f6a512f4b40115e9b02088a0d8c3c1.jpeg?odnHeight=640&odnWidth=640&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/onn-Large-Party-Speaker-Gen-2-with-LED-Lighting/1212999628?classType=REGULAR&from=/search',
        'category' => 'electronics',
        'range' => 'far',
        'description' => 'Portable Bluetooth speaker with high-quality sound and long battery life. Perfect for parties and outdoor activities.'
    ],
    [
        'id' => 'walmart4',
        'name' => 'Ceramic Vase',
        'salePrice' => 19.97,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Home-Decor-Collection-8-White-Matte-Textured-Ceramic-Stoneware-Vase-with-Handles_0e9eb454-5471-487d-8124-9ae54149b273.cb3e90220f12587441b8634c1fcf96d8.jpeg?odnHeight=640&odnWidth=640&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Home-Decor-Collection-8-White-Matte-Textured-Ceramic-Stoneware-Vase-with-Handles/9253803692?classType=REGULAR&athbdg=L1103&from=/search',
        'category' => 'home',
        'range' => 'close',
        'description' => 'Elegant ceramic vase ideal for fresh flowers or as a decorative piece in your living room or dining area.'
    ],
    [
        'id' => 'walmart5',
        'name' => 'Building Blocks',
        'salePrice' => 38.89,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/MAGNA-TILES-Arctic-Animals-25pc-Set-Ages-3_f6b568cb-d2e5-4ded-854f-605fd18034c8.ee8481dca335f985d3645ce949275f01.png?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/MAGNA-TILES-Arctic-Animals-25pc-Set-Ages-3/335542736?classType=VARIANT&from=/search',
        'category' => 'toys',
        'range' => 'medium',
        'description' => 'Colorful building blocks set for kids. Encourages creativity and improves motor skills. Safe and durable.'
    ],
    [
        'id' => 'walmart6',
        'name' => 'Children\'s Story Book',
        'salePrice' => 8.02,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Disney-Bedtime-Favorites-Storybook-Collection-Walmart-Exclusive-Hardcover-9781368071215_c7b950af-9598-4367-9ffc-c99444e230ee.e3516937f5214c36c417ccbe34ec2c6e.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Disney-Bedtime-Favorites-Storybook-Collection-Walmart-Exclusive-Hardcover-9781368071215/108210249?classType=REGULAR&from=/search',
        'category' => 'books',
        'range' => 'far',
        'description' => 'A delightful story book for children, filled with colorful illustrations and engaging tales.'
    ],
    [
        'id' => 'walmart7',
        'name' => 'Basketball',
        'salePrice' => 9.97,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Spalding-Fast-Break-All-Surface-Blue-Silver-Basketball-Size-7-29-5_f5544668-8be4-43b6-8420-5640c9def267.5a295ffaa3643423d1a60179e10fab7a.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Spalding-Fast-Break-All-Surface-Blue-Silver-Basketball-Size-7-29-5/601116740?classType=VARIANT&from=/search',
        'category' => 'sports',
        'range' => 'medium',
        'description' => 'Official size basketball suitable for indoor and outdoor play. Durable rubber cover for better grip.'
    ],
    [
        'id' => 'walmart8',
        'name' => 'Vitamins C',
        'salePrice' => 5.43,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Spring-Valley-Vitamin-C-Supplement-with-Rose-Hips-Tablets-500-mg-100-Count_0e209c2f-3174-4aad-96cf-a29faf153561.7af7571fa2935007884b3cc5e25bc1f8.jpeg?odnHeight=640&odnWidth=640&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Spring-Valley-Vitamin-C-Supplement-with-Rose-Hips-Tablets-500-mg-100-Count/6139509340?classType=REGULAR&athbdg=L1200&from=/search',
        'category' => 'health',
        'range' => 'close',
        'description' => 'Vitamin C tablets to support your immune system. 100 tablets per bottle, easy to swallow.'
    ],
    [
        'id' => 'walmart9',
        'name' => 'Face Cream',
        'salePrice' => 4.88,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Equate-Collagen-Moisturizer-Day-Night-Cream-1-7-oz_df96d1cf-1b7e-4662-8aec-bd3018c2fe3d.9c63920e9f0647b3d37eb2a3ab1655bc.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Equate-Collagen-Moisturizer-Day-Night-Cream-1-7-oz/1634119464?classType=VARIANT&athbdg=L1200&from=/search',
        'category' => 'beauty',
        'range' => 'far',
        'description' => 'Hydrating face cream for all skin types. Provides 24-hour moisture and a radiant glow.'
    ],
    [
        'id' => 'walmart10',
        'name' => 'Car Air Freshener',
        'salePrice' => 6.44,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Febreze-Air-Freshener-Car-Japan-Cherry-Blossom_b6b1aff0-85eb-405e-ba42-4a247f3e5eb6.96c72fea9843b9d0b0312ed76aedc6e6.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Febreze-Air-Freshener-Car-Japan-Cherry-Blossom/14980613525?classType=REGULAR&from=/search',
        'category' => 'automotive',
        'range' => 'medium',
        'description' => 'Long-lasting car air freshener with a refreshing scent. Easy to hang and replace.'
    ],
    [
        'id' => 'walmart11',
        'name' => 'Garden Hose',
        'salePrice' => 19.89,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/AmazingForLess-Expandable-Water-Hose-25ft-Upgraded-Leakproof-Lightweight-No-Kink-Garden-Hose-Flexible-Expanding-Water-Hose-Black_2b53d5ea-abfe-423e-9ddb-a7ab9b0403b3.1becd8877fb40f6d73ca3f5619d1e626.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/AmazingForLess-Expandable-Water-Hose-25ft-Upgraded-Leakproof-Lightweight-No-Kink-Garden-Hose-Flexible-Expanding-Water-Hose-Black/3661780878?classType=VARIANT&from=/search',
        'category' => 'garden',
        'range' => 'close',
        'description' => 'Flexible and durable garden hose, 50 feet long. Perfect for watering plants and cleaning outdoors.'
    ],
    [
        'id' => 'walmart12',
        'name' => 'Dog Chew Toy',
        'salePrice' => 4.23,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Arm-Hammer-Barkies-8-Real-Wood-Mix-Tree-Branch-Durable-Dental-Dog-Chew-Toy-Bacon-Flavor_c24ea382-fae4-43a9-ab21-1f01d916ddfd.6f438e3a379d539c896abcefa1efe66f.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Arm-Hammer-Barkies-8-Real-Wood-Mix-Tree-Branch-Durable-Dental-Dog-Chew-Toy-Bacon-Flavor/1982202162?classType=REGULAR&from=/search',
        'category' => 'pets',
        'range' => 'far',
        'description' => 'Durable chew toy for dogs. Helps clean teeth and keeps your pet entertained for hours.'
    ],
    [
        'id' => 'walmart13',
        'name' => 'Office Chair',
        'salePrice' => 898.39,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/ACME-Indra-Executive-Office-Chair-with-Lift-in-Vintage-Chocolate_d880cb1b-234c-42e6-8461-0a5359bb3e78.718fa4d7c17ef93be1fdb697196f09e9.jpeg?odnHeight=640&odnWidth=640&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/ACME-Indra-Executive-Office-Chair-with-Lift-in-Vintage-Chocolate/383217382?classType=VARIANT&from=/search',
        'category' => 'office',
        'range' => 'medium',
        'description' => 'Ergonomic office chair with adjustable height and lumbar support. Comfortable for long working hours.'
    ],
    [
        'id' => 'walmart14',
        'name' => 'Acoustic Guitar',
        'salePrice' => 169.99,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Yamaha-F335-6-Strings-Acoustic-Guitar-83-2-oz-40_79ecd00e-cc4f-4a51-b070-ae94aec40071_1.b2bb8a9b4061c446ac7b38492e508eee.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Yamaha-F335-6-Strings-Acoustic-Guitar-83-2-oz-40/24192601?classType=VARIANT&athbdg=L1600&from=/search',
        'category' => 'music',
        'range' => 'far',
        'description' => 'Full-size acoustic guitar with a rich, warm sound. Great for beginners and experienced players.'
    ],
    [
        'id' => 'walmart15',
        'name' => 'Apple Juice',
        'salePrice' => 3.24,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/Great-Value-100-Apple-Juice-96-fl-oz_34a4bc66-9cdb-404c-8665-b6435742ed45.3402c97169db76e6c3784d67cc1ad581.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/Great-Value-100-Apple-Juice-96-fl-oz/10415325?classType=VARIANT&athbdg=L1200&from=/search',
        'category' => 'food',
        'range' => 'medium',
        'description' => 'Refreshing apple juice made from real apples. No added sugar or preservatives.'
    ],
    [
        'id' => 'walmart16',
        'name' => 'Women\'s Dress',
        'salePrice' => 38.99,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/PRETTYGARDEN-Women-s-Summer-Floral-Midi-Dress-Cap-Sleeve-V-Neck-Ruffle-Long-Flowy-Boho-Casual-Beach-Vacation-Dresses_63ab0b3d-e65c-4996-b35b-eae0c59929ad.de666ceb6cb34064c3dee8e2af15ca88.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/PRETTYGARDEN-Women-s-Summer-Floral-Midi-Dress-Cap-Sleeve-V-Neck-Ruffle-Long-Flowy-Boho-Casual-Beach-Vacation-Dresses/15335667119?classType=VARIANT&from=/search',
        'category' => 'clothing',
        'range' => 'far',
        'description' => 'Elegant women\'s dress suitable for both casual and formal occasions. Soft and breathable fabric.'
    ],
    [
        'id' => 'walmart17',
        'name' => 'Smart TV',
        'salePrice' => 9979.00,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/SAMSUNG-98-Class-QN90D-Neo-QLED-4K-Smart-TV-QN98QN90DAFXZA-2024_a28f3fe2-f39d-411f-b5a8-6e3b189ad9d5.2ae44690fcb50f240fc38763b081ee69.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/SAMSUNG-98-Class-QN90D-Neo-QLED-4K-Smart-TV-QN98QN90DAFXZA-2024/5369461008?classType=REGULAR&from=/search',
        'category' => 'electronics',
        'range' => 'close',
        'description' => 'High-definition smart TV with built-in streaming apps. Crisp visuals and vibrant colors.'
    ],
    [
        'id' => 'walmart18',
        'name' => 'Table Lamp',
        'salePrice' => 89.99,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/360-Lighting-Marshall-Modern-Table-Lamp-30-Tall-Gold-Open-Base-Oatmeal-Rectangular-Shade-Bedroom-Living-Room-Bedside-Nightstand-Office-House-Home_ab66e94d-491b-4989-8515-3f9e0e2b5128.a776de69c485ffb3bdce2167cb95529a.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/360-Lighting-Marshall-Modern-Table-Lamp-30-Tall-Gold-Open-Base-Oatmeal-Rectangular-Shade-Bedroom-Living-Room-Bedside-Nightstand-Office-House-Home/676320746?classType=REGULAR&from=/search',
        'category' => 'home',
        'range' => 'medium',
        'description' => 'Modern table lamp with adjustable brightness. Perfect for your bedside or study desk.'
    ],
    [
        'id' => 'walmart19',
        'name' => 'Puzzle Set',
        'salePrice' => 29.95,
        'thumbnailImage' => 'https://i5.walmartimages.com/seo/MasterPieces-Jigsaw-Puzzle-12-Pack-Bundle-Set-Artist-Gallery-Collection-Landscape-and-Animal-Puzzles-Family-Fun-for-Adults-and-Kids_72ec7974-1d88-4f12-adb7-84b7930d5a0e.a88ea2da51a6d24ce0977cc59a915324.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF',
        'productUrl' => 'https://www.walmart.com/ip/MasterPieces-Jigsaw-Puzzle-12-Pack-Bundle-Set-Artist-Gallery-Collection-Landscape-and-Animal-Puzzles-Family-Fun-for-Adults-and-Kids/356853843?classType=VARIANT&from=/search',
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
        'price' => '$16.97',
        'image' => 'https://m.media-amazon.com/images/I/611dddkZDFL._SX679_.jpg',
        'url' => 'https://www.amazon.com/Nature-Nates-Unfiltered-Brazilian-Wholesome/dp/B01IR6IZZA/ref=sr_1_5?crid=3DSB46CLSP3NI&dib=eyJ2IjoiMSJ9.kCsP_mm4lX-ZpahJHGcvQqsbJIgm14ypKboyVMwP6b5lGbaaVuBSNv-dBZQKr7GBVSjyN8ApcVw-kFswlmnnNtLYHUun32-DfrbVGgScpd3KnhHlhHdGFXBWjzX9D8ZnI72XsRM6MiMvAupkfLvNlG5BkPMKmdluzzuDqMICr5CP3cEZzV9MtYJUpVjtQUIyyszh6uWL0d-ewChOZSqIu1cEZ_I70ARnz7_E-cxGlf0AXTuWdyCJm_eHBPvkWiAP7swjBrzPzxPiajU-xhxR0hQczcngVV6PemfyN-mHfjo.zF12yOhYUAFSYPVggMArFZRB8Ukgdqs6wHkWBrcgEaE&dib_tag=se&keywords=Organic%2BHoney&qid=1753404922&sprefix=organic%2Bhoney%2Caps%2C117&sr=8-5&th=1',
        'category' => 'food',
        'range' => 'medium',
        'description' => 'Pure organic honey, perfect for sweetening tea or spreading on toast. No artificial additives.'
    ],
    [
        'id' => 'amazon2',
        'title' => 'Women\'s Jeans',
        'price' => '$27.60',
        'image' => 'https://m.media-amazon.com/images/I/61Fej2rPSwL._AC_SY550_.jpg',
        'url' => 'https://www.amazon.com/LEE-Womens-Regular-Bootcut-Renegade/dp/B07B6GMMKF/ref=sr_1_5?crid=22CARGWXODY4W&dib=eyJ2IjoiMSJ9.IbGczbnE636-1CaT2OD6bb9pZhjQ9paFjlElHriz0hmyKe3-LhLkdjhYU1D-Dwlgs9RAIvPBr4kI0Y0sZhhZLRPBanBF3_Nt1zd1-4iRCr8_aPLYlbCMANisYO1i19VkC-RHTel_awnoXVvuIBRUXJkCjmT_IR2AQ8t17Nd34sX7SEoxzYIxMazSFCxeGGvlwBYycWmTPocgKqe5SQRpTiDevUoUpazdCv8YE8qwl5Iro-tkp-DHcf6ckZJcx4p-WOxmmUURwFEhvbJd4NXLpEHFpsF2IiZv5HzW0jsWtZU.DUipuIapBmcR47StVuFzwfQYHsLM2VWd28wrYrcU-eM&dib_tag=se&keywords=Womens+jeans&qid=1753404962&sprefix=womens+jea%2Caps%2C157&sr=8-5',
        'category' => 'clothing',
        'range' => 'far',
        'description' => 'Classic fit women\'s jeans with a comfortable stretch. Durable and stylish for everyday wear.'
    ],
    [
        'id' => 'amazon3',
        'title' => 'Wireless Mouse',
        'price' => '$13.99',
        'image' => 'https://m.media-amazon.com/images/I/61v0F70qBqL._AC_SX466_.jpg',
        'url' => 'https://www.amazon.com/Logitech-Wireless-Mouse-M185-Swift/dp/B004YAVF8I/ref=sr_1_3?crid=1FS3SS48JLAEO&dib=eyJ2IjoiMSJ9.q0cfVk5pIDwp96MY0_ssCb95MkDiesObF3GhvA-vKWhzvLB69o4mQZ6a3-oPG3TFn_WDyL-3t6UlhQI_3MYYl5_9jGsNC8xap7UxXgZZ8LA5GsiUlj7zeE-mcvIrUhCkPLAp8IPHScQF7WcmFqFSThnhMmPsG9tExFKp19Mpipq7bFpS4W4pXsQUY84NIHUSH8ruO-KNsCVS6ehkv7ImjHsDM9vDlMz7f2cuLZCbUjo.TvXtopXf1Y60cDgEpOp26hoA41LGR2NqVEbtcpoguJ0&dib_tag=se&keywords=wireless%2Bmouse&qid=1753405004&sprefix=wirless%2Bm%2Caps%2C107&sr=8-3&th=1',
        'category' => 'electronics',
        'range' => 'close',
        'description' => 'Ergonomic wireless mouse with adjustable DPI settings. Smooth tracking and long battery life.'
    ],
    [
        'id' => 'amazon4',
        'title' => 'Throw Pillow',
        'price' => '$16.06',
        'image' => 'https://m.media-amazon.com/images/I/81x0t0axsML._AC_SX679_.jpg',
        'url' => 'https://www.amazon.com/MIULEE-Corduroy-Decorative-Striped-Farmhouse/dp/B0CVVVNB9L/ref=sr_1_9?crid=38ZMSZMQM3TKJ&dib=eyJ2IjoiMSJ9.0cp-OrtA_8n7Ve6oOf1glT43F-Vwc3mQ_oYF7KXKYUcRNFpQoHoqKRMQN_T0v208-u8686wEMwhxmJj8XJMj8wMQBqSa29l596D0RjnM6JaoiT1dM1FdfSZ1LDgCaimtdKwA-QIuyY0_EFltpuXU8VlBnsWiyv0h7DbWUXKRahkjz1hXw6aVHKfmHmn4_OwAI8f5l2gvzYzzGb9AjNL4f1aL2VRNLcXhHtsEYJ53mCZRYeG3vRWFXTBsaLjzPfJ0eQI9-EtsMVWGcj6eQsFwDkIzjLWB528TKrla8S3DLsA.E-a-KZoVX3zX5gI8A0CQkmgF-CtlbnvutQq_w_MXG5I&dib_tag=se&keywords=throw+pillows&qid=1753405040&sprefix=Thro%2Caps%2C126&sr=8-9',
        'category' => 'home',
        'range' => 'medium',
        'description' => 'Soft and decorative throw pillow. Adds comfort and style to your sofa or bed.'
    ],
    [
        'id' => 'amazon5',
        'title' => 'RC Car',
        'price' => '$7,119.04',
        'image' => 'https://m.media-amazon.com/images/I/5146xIBzUrL._AC_SX679_.jpg',
        'url' => 'https://www.amazon.com/Brushless-Monster-Terrain-Off-Road-Control/dp/B0CQ52B8N2/ref=sr_1_2?crid=3NT7869WSF6HJ&dib=eyJ2IjoiMSJ9.Y2KrUNzOpYgwKY2qBZQTbjINKVoyVa2qmJIXEHwYUkgtMc7ORhULNpi5Z2bXLLA1DKrO9KnuZ3L1iCbgpCLLqw1mjlzowGes3pJf8Y5o6REtx560xRvfv7c-hYc1qs78nIuMh35ijTNX8S40F0kE65nC6YbQwhj_8SpfpZ_l2PXpxqzhTzUzTaIXUV8BnDKJFkdLb4ICPFLPMJmoZHOByrBfgPfwfYqQKYieQWy2-PVPmkoBLiJo6fJOAhGmHjyKnPGG9Xn94f0P6sde8pHWEbCunLsYtFlff6ELxGpJ7eI.QrjMQgAwfyF47b4bnoVUedSNatak7jg9-0zoQDCuNhk&dib_tag=se&keywords=RC+car&qid=1753405116&sprefix=rc+car%2Caps%2C195&sr=8-2',
        'category' => 'toys',
        'range' => 'far',
        'description' => 'High-speed remote control car with rechargeable battery. Fun for kids and adults alike.'
    ],
    [
        'id' => 'amazon6',
        'title' => 'Science Fiction Novel',
        'price' => '$16.74',
        'image' => 'https://m.media-amazon.com/images/I/714TwqoYi2L._SY466_.jpg',
        'url' => 'https://www.amazon.com/Dark-Matter-Novel-Blake-Crouch/dp/1101904224/ref=tmm_hrd_swatch_0?_encoding=UTF8&dib_tag=se&dib=eyJ2IjoiMSJ9.mP9ZMP_RBBP0YfQkvUFQhSxpO6mBkofqyJRVg758m6CDSVeccYYQDMl8kVu1fS1OqjtsptPirVICINCE4fMYLzk87kRHTzWpaBQMmhpqCUyKraCYY7lbLUlwZBrGErf7at3Td-tWeILI_p1u1HnyKYViyuRCGlk7IOG2s2ZrwS9fkE0yiPpKeb4IXcOPprv7_BhkQp3i_Hqn7idYUTfZJe6aP78v_HFoYl90WxD4Ooelc56GK2fdzym4LVfEDpg90MFlr5WjI8iZV_HoVBY4upfz6UfljJg25ZKdLrF7R5M.yodIw6egWevuPASSCQp6E2JLGLJPzzRXWzPZxHm06IY&qid=1753405229&sr=8-6',
        'category' => 'books',
        'range' => 'close',
        'description' => 'Bestselling science fiction novel with an exciting plot and unforgettable characters.'
    ],
    [
        'id' => 'amazon7',
        'title' => 'Yoga Mat',
        'price' => '$14.43',
        'image' => 'https://m.media-amazon.com/images/I/715di42jxvL.__AC_SX300_SY300_QL70_FMwebp_.jpg',
        'url' => 'https://www.amazon.com/Gaiam-Classic-Exercise-Exercises-Marrakesh/dp/B01MY5MZSQ/ref=sr_1_6?crid=1LY1BFKGODURK&dib=eyJ2IjoiMSJ9.QqM6HCH-nqQd4ZOGeHK2vsWKw2Ragik2PifBt5dshmSJIrNwMGHW6NpLqWvXHL1MBQzI9FC6aq4yahiqfDw-0TncfOeQwIjkoiZXkyh_4yYIlCwXf7aeWmNVuEX7JQWAGf4iRO02lNfB1lCcJyyNMuZoST5IA6akQAZpRknXPAdr2A8AB-NUxFxu0eRY3PwgxaCObBIi4EislhC5rHwCHU3CUeJUfnyPcLr5Qx47FZTgLb55WfW8zF6_qV6mz2VL_J__OBAbU4DZKksipyNenDcmetzHUnHv5g5BTbCaK4c.GANjJ5oL-PanCOyWPD7703TXEh-XzGBghHoRqvK-klY&dib_tag=se&keywords=yoga%2Bmat&qid=1753405284&sprefix=Yoga%2Caps%2C94&sr=8-6&th=1',
        'category' => 'sports',
        'range' => 'medium',
        'description' => 'Non-slip yoga mat with extra cushioning. Ideal for yoga, pilates, and stretching exercises.'
    ],
    [
        'id' => 'amazon8',
        'title' => 'Protein Powder',
        'price' => '$39.99',
        'image' => 'https://m.media-amazon.com/images/I/71OsEAdPuZL._AC_SX679_.jpg',
        'url' => 'https://www.amazon.com/Optimum-Nutrition-Delicious-Strawberry-Packaging/dp/B002DYIZH6/ref=sr_1_5?crid=2MTY8UQT4F1LU&dib=eyJ2IjoiMSJ9.IGwn7P5E3Y8jOQ3IAqDw2WLbyxRL0yU8G1cMZ4GhNgoHH8ir7-129hHplu-qB-y5B1w4qqhSzJ8sMQOxRC73b5ZDbCv3dwYaaMCM0aWKiTlgi2mCAXaz6b2jvFVRsBX0PhVzCJxe9vd0p_ykmqn-3tGB6ooqixV3DhNkov010Ce2vhq7gWs78tLn2sNePxEPCrtMpWzeGtLvPrXe9BEAIlVeQWILcgawjEJSblX5jZf6gXACJJ_AVedeTWKkEc9xV5If7uWGoOlkB2YOQScdvxe6lfytpWFE7ypBMYLtMb8.lQOcqMRfy1_eOcjLrmKCbHC9sYNVM2Jz93vC99Ui_FY&dib_tag=se&keywords=protein%2Bpowder&qid=1753405323&sprefix=Prote%2Caps%2C106&sr=8-5&th=1',
        'category' => 'health',
        'range' => 'far',
        'description' => 'High-quality protein powder for muscle recovery and growth. Great taste and easy to mix.'
    ],
    [
        'id' => 'amazon9',
        'title' => 'Lipstick Set',
        'price' => '$29.37',
        'image' => 'https://m.media-amazon.com/images/I/91s4Z3Ca2xL._SX466_.jpg',
        'url' => 'https://www.amazon.com/REVLON-Lustrous-Lipstick-Multi-finish-Lipcolor/dp/B08QYF6698/ref=sr_1_6?crid=16KFYJF4255XQ&dib=eyJ2IjoiMSJ9.MIItt-WoHRz3fGmDB3BT38mBNTBds5x2iqCtBxEpf8H92HryL4c7cYzBDA7ISKkLxNsq2DPp_HFmE5TXu39cmuULnrAG8wCtXs_6oqcKoEdTI-8o-7wm4yIrTkMSsWqTgtMOdlOWbQKdGOorp8vquCLYOS2f7bUNbfNck8VD6Nue9Khltupo_LNGmastJ9mCn-KnlJ30lMpbU3E0h0dYhc6i61cQd_DZfHcoDpP_M6ysdbCRrZywcthnyYwnynkkygTs_96x2mjnAc_WToXEDk1oG8GvnKd8s7biVwKVzYo.bhrI2IfAcbPtZxlkkku_KjzjWv3NZIhR87dQWsF3Cz8&dib_tag=se&keywords=Lipstick%2Bset&qid=1753405369&sprefix=lipstick%2Bset%2Caps%2C128&sr=8-6&th=1',
        'category' => 'beauty',
        'range' => 'close',
        'description' => 'Vibrant lipstick set with multiple shades. Long-lasting and moisturizing formula.'
    ],
    [
        'id' => 'amazon10',
        'title' => 'Car Vacuum Cleaner',
        'price' => '$37.99',
        'image' => 'https://m.media-amazon.com/images/I/717XO6AXgFL._AC_SX679_.jpg',
        'url' => 'https://www.amazon.com/Cordless-Lightweight-Handheld-Upgraded-BlackBlue/dp/B0F9P5XLW9/ref=sr_1_5?crid=398C47UUJE64M&dib=eyJ2IjoiMSJ9.ive5o-yzISDUa2AunZsCHLAGCw_vyeCTCvPlebxqVAEbuSZZ_qJSqspnWqkOkNcDU4HFWWKbdePkNqq917rmSN6i_vroFPde2xYI6SEDlURLFfV22Rj51NvpsAAXwW9D40qNjwl29rSg2_sBns1BzFFCoRC8RDouiZXCTCmN2cNHUvJzcn31e9Ntw_jHFbwCrKzLWijf7OOWaZYIgBv6qpPYjnGN5DDpBFbL66UmxRlLAIsGjbV5Zs-PPz_bCpG6lidCWCqbE6q4LwED4cdAc0zc98qdrk3IuDb1E4_amhA.nxdWHtbLQPSFJQowfDlUCmacsdHgkD1-lZaknxve8A8&dib_tag=se&keywords=car%2Bvacuum%2Bcleaner%2Bhigh%2Bpower&qid=1753405412&sprefix=Car%2BVacum%2Bcl%2Caps%2C97&sr=8-5&th=1',
        'category' => 'automotive',
        'range' => 'medium',
        'description' => 'Portable car vacuum cleaner with powerful suction. Includes multiple attachments for thorough cleaning.'
    ],
    [
        'id' => 'amazon11',
        'title' => 'Garden Gloves',
        'price' => '$7.79',
        'image' => 'https://m.media-amazon.com/images/I/81dQkEpvWUL._AC_SX679_PIbundle-3,TopRight,0,0_SH20_.jpg',
        'url' => 'https://www.amazon.com/Wells-Lamont-Womens-Gardening-413MF/dp/B09VQMMR1C/ref=sr_1_6?crid=15DOV62B5ZH9X&dib=eyJ2IjoiMSJ9.K8HYTcbBtwWQ4M8eS9UryPNA7EEipWu57NYGXj_VaT4FBlymqfIolycFY0N4CB6Gn7usWRa_Qx4yRP_FO7bTeaxKjeVPtdn6_QWeFj5vL7KjNLxgRapFjf-4IZmSuCNKbjZ4_wDtNIh_dGqRc8soNjx22JrMU-1sagl8GDHm6lLJ8intMghEguaPRrs_0gIHgWInm1Fp5g76vSzPot-TVqhlo_66Vl6azADBolOi86C6LxFeoKGlnbZMAKp5LplSmiv96Obt07LzXh0e9TBL6LWG8v44FX0vW2oR6r2kQJ0.fAnDxY6hlyZUP9Nk1URw-tXc8F7qrJPbzaAybZ2MfKc&dib_tag=se&keywords=Garden+gloves&qid=1753405455&sprefix=garden+gloves%2Caps%2C102&sr=8-6',
        'category' => 'garden',
        'range' => 'far',
        'description' => 'Durable garden gloves with non-slip grip. Protects your hands while gardening or landscaping.'
    ],
    [
        'id' => 'amazon12',
        'title' => 'Cat Scratching Post',
        'price' => '$6,645.42',
        'image' => 'https://m.media-amazon.com/images/I/61GqiNveRCL._AC_SX679_.jpg',
        'url' => 'https://www.amazon.com/Climbing-Scratching-Platform-Space-Saving-Resting/dp/B0FDG8M4H5/ref=sr_1_1?crid=3L5YNJG5WH7BM&dib=eyJ2IjoiMSJ9.VgAZJDie7VnnBQ6vE4z8eAdGhbR-DwPbq7YOZOn75qxH_nsHH9GmjHW0-sDAhm_yyyzaKS-pIYi0HgAgwPzDvQmE2-2oyE5tbL3aQOLJx3_bbD6wGlC8DlTEQCYC59nAgGkeTqTQXo4iMwmhZHJahcoIhCpAAtjeJl3zBNNCIxD9fZoiwt4vY8EZYQ14Av2vXkHpK5iOmgOJ5lafhNpUEMcja4vrBIqOQ-dABhfDpjsxXl379J6argPEV-BrP9sWAmQt3aQi2WexSguDDjDFQmf2dScpuKXitFEHP9QhN8g.gvth8u_6BzbI7UOvvvbpPC6hmHsMX1P6jdlHDe_3neg&dib_tag=se&keywords=cat+scratching+post&qid=1753405505&sprefix=cat+sc%2Caps%2C99&sr=8-1',
        'category' => 'pets',
        'range' => 'close',
        'description' => 'Sturdy cat scratching post to keep your cat entertained and your furniture safe.'
    ],
    [
        'id' => 'amazon13',
        'title' => 'Desk Organizer',
        'price' => '$20.89',
        'image' => 'https://m.media-amazon.com/images/I/81MeUftFm8L._AC_SX466_.jpg',
        'url' => 'https://www.amazon.com/OPNICE-Organizers-Accessories-Organizer-Workspace/dp/B0DB8F7GDN/ref=sr_1_5?crid=248Z29BT2MKKT&dib=eyJ2IjoiMSJ9.6yg0POE7vl6muItDFbK84vpKLYrfXurk0g57JTA3puPXJmNKVMwKwt_7RuFJ6PkeBXFfxWBA3y6IyP57_XsDgZGnZBgPnQWqGcw_XlhwmgTIF-m8qBMpO6RVn_tczsHuDLU3pZ3NA7m0AmMFgzRsqFO2jMYq8XUg3Hnmec217cWZBmem_elAxP-J5gGjKStzZj-L7W7kl92VWbl44sJhIcp_nDgfx18yODeRdFQbvcloRVr5af00cYRxfB3qvXGXYWeyrBsQ8N3LBBx_ESRzhRlkEixrKePJC-1XKRTRjwQ.Edc7DKU-ZByDRmLvvL_u7-_gZkDuAIQnrL3R5pO5KIQ&dib_tag=se&keywords=desk+organizer&qid=1753405549&sprefix=Desk+Or%2Caps%2C180&sr=8-5',
        'category' => 'office',
        'range' => 'far',
        'description' => 'Multi-compartment desk organizer to keep your workspace tidy and efficient.'
    ],
    [
        'id' => 'amazon14',
        'title' => 'Electric Keyboard',
        'price' => '$4,105.09',
        'image' => 'https://m.media-amazon.com/images/I/51yCIz-HijL._AC_SX679_.jpg',
        'url' => 'https://www.amazon.com/Electric-Practice-Electronic-Instrument-Keyboards/dp/B0CNG4ZMNQ/ref=sr_1_3?crid=V6Z5OBGVF4B&dib=eyJ2IjoiMSJ9.Y1qUDvHgyPOY1wt7xzYm5hToTHJUeGhNc7WPc93fSmjsO9q8xJmxVDP9qxNNRZwW_PPCKPqdw02OKdvmqgPbLO-kUdpcNMndQxjOgOsG1iuMfVi4vtb-jWIy8NBZvtZXD1OdgNkM4naKp-8paK8IMwT1VuTGIJsUaZnK4FZedvl5O5OLG--xJzd5hVrIXpuKlJ4ejBhzWiD7cQ9-l3Pp9U2sN5SYQs8kIs5_E_kZv7ks6REfeLJgxh4ym4Xbs5K8mmzk5qUMexo1-nzEualQw6CwfGyOi5ANoNB_wiUDVcU.gkiUHQYgDRpoavDF1K7IaoRFd3aci5csB5WoRB8pGE0&dib_tag=se&keywords=electric%2Bkeyboard&qid=1753405599&sprefix=electric%2Bkeyboar%2Caps%2C124&sr=8-3&th=1',
        'category' => 'music',
        'range' => 'medium',
        'description' => '88-key electric keyboard with built-in speakers. Perfect for music enthusiasts.'
    ],
    [
        'id' => 'amazon15',
        'title' => 'Granola Bars',
        'price' => '$10.98',
        'image' => 'https://m.media-amazon.com/images/I/81QwI5TydvL._SX679_.jpg',
        'url' => 'https://www.amazon.com/Natures-Valley-granola-Crunchy-Honey/dp/B0025W9A5C/ref=sr_1_5?crid=2B5WU05LULM8B&dib=eyJ2IjoiMSJ9.PYhE1NlPioDg244LB4yfSozHW0LgPHELkOYJF1h4EI256sfsH44T6EPr1oS3ENRVZphrZxtcX2923LSe9VjIy9R3uGXDPUAjHvMDpy-6cypXIPm04lMRX43w2bqDTNXKGvkzeyTrV-KxwbEQ2RUsmYCqLeA9Idu0Agh9CFAuHJ6ppMNxa1qDHkf3waNIEpY-Fg-2x1SKMCZWpSZqx7OvnMgIRxjF_zovekqIR0UgXu_d5kmeECg4UK1mkYQ4FjyTslEIIEj82us1j33_ItHvaoPLCwb-tHCxTh_2OOGscas.OI_6Gc8kwUSSdQ3Yc9djDosf7TEqygKd6WIzdXALYUo&dib_tag=se&keywords=granola%2Bbars&qid=1753405663&sprefix=Granola%2Caps%2C99&sr=8-5&th=1',
        'category' => 'food',
        'range' => 'far',
        'description' => 'Healthy granola bars packed with oats and nuts. Great for on-the-go snacking.'
    ],
    [
        'id' => 'amazon16',
        'title' => 'Men\'s Hoodie',
        'price' => '$14.36',
        'image' => 'https://m.media-amazon.com/images/I/81yRxDXDD1L._AC_SY550_.jpg',
        'url' => 'https://www.amazon.com/Fruit-Loom-Eversoft-Sweatshirts-Pullover-Grey/dp/B08YGQB8M5/ref=sr_1_6?crid=SMVRAS7TNZBT&dib=eyJ2IjoiMSJ9.OcH6Y4P2ZR-cC1FXZp5IgOvZ8UpxQRrjJdlLyicmYyjwJ6gm4jkAlhE1UJUMOVs9FxxSxpb5wYf59SrLrY7RcOBYaZGR6tErU3qvgifZKj4rqDjrO9XdqZO9BG_cs0f25UaQx7ic59pwxXZwXWIz68N087zyQV13v23jIepu7pXVEeMdEebC1mO5f5-GtyxjLpcMxcvUZCuzovNNOjvOcxVYuaKuPrdDIREBzffSj-vCEjbpbDsbi24NAWLn0PtyfXyKEXDdXHgxFKNn0mPx_hfo8lqQDTWLYzzMbOuph6Y.kkOgpgzLNll5refZQhDiQ6R9JDGts06bJVv6KTOLAoI&dib_tag=se&keywords=Mens+hoodie&qid=1753405705&sprefix=mens+hoodie%2Caps%2C164&sr=8-6',
        'category' => 'clothing',
        'range' => 'close',
        'description' => 'Warm and cozy men\'s hoodie with a front pocket. Ideal for casual wear and outdoor activities.'
    ],
    [
        'id' => 'amazon17',
        'title' => 'Bluetooth Earbuds',
        'price' => '$49.95',
        'image' => 'https://m.media-amazon.com/images/I/41+1Csr1pSL._AC_SY300_SX300_.jpg',
        'url' => 'https://www.amazon.com/JBL-Vibe-Beam-Wireless-Headphones/dp/B0BQPNMXQV/ref=sr_1_1?crid=29VXLGI8JE7UU&dib=eyJ2IjoiMSJ9.B3tgZc2EfQPUWJ5qVjH_ncA7dVd4vIlX3EwAF5EixJ6Aqlxp9qazl1NhgGvktvCsNnyPllVHsp49BCscYTWdEnIFnQXo1uL8_y8WQguw74HPk8XFkHwJIN3L5tAt36ODsfaurwj2VJm-Z8yhS3yp3YBmVxOmKXHCKdZF75ON8vzAQ-9eOvjzQPy7Ur65CDL-sKJz2_14t7EmbBUuufYUtijlUUNRX8ZP-Ndkba-KvIU.WxtKpujdvJ6dcANlriaJYIoRWVuX9k12LKpBsRf4D2U&dib_tag=se&keywords=bluetooth%2Bearbuds%2Bjbl&qid=1753405762&sprefix=Blue%2Btoothe%2Bearb%2Caps%2C188&sr=8-1&th=1',
        'category' => 'electronics',
        'range' => 'medium',
        'description' => 'Wireless Bluetooth earbuds with noise cancellation. Compact charging case included.'
    ],
    [
        'id' => 'amazon18',
        'title' => 'Wall Clock',
        'price' => '$25,430.68',
        'image' => 'https://m.media-amazon.com/images/I/71VFyBSG5sL._AC_SX679_.jpg',
        'url' => 'https://www.amazon.com/Quartz-Cuckoo-Control-Rabbit-Pastoral/dp/B0DDGXNC2R/ref=sr_1_1?crid=JT289MYAD85U&dib=eyJ2IjoiMSJ9.teB_9boVIBLs9uPAJbBRfyctW_iFShC-3YNQMTB3T2lRN5n9M8PV3ybhCDULamUZyUbFFjfjiuJVYljjrpN1CzarHQ6BfaJ6aO_6vNBJZ0PS0qiapuir3VZf0QjxhAyet2Rdfgg1Yn-fC7rhqh0RBrNJqnU38U0DLfwUqcCuqP9qjw3W7Y74phM7ZmFpNlfDTHsvaqYcykS8xEdg4Fro15uI8gNDQ4rVFe3ORtxWgYOKmWQRNB7-gTy-eemBCJqWjblp4CDexh1xzyyngV8Cns19eNEycuqcOg-056STI88.HP8TuqTyMc0PaPDTKxay4PZs_C5cSI8FrVZ3uLgPxXQ&dib_tag=se&keywords=wall+clock&qid=1753405806&sprefix=wall+clcok%2Caps%2C126&sr=8-1',
        'category' => 'home',
        'range' => 'far',
        'description' => 'Modern wall clock with a silent sweep movement. Stylish addition to any room.'
    ],
    [
        'id' => 'amazon19',
        'title' => 'Plush Teddy Bear',
        'price' => '$875.00',
        'image' => 'https://m.media-amazon.com/images/I/412LCHfPqfL._AC_.jpg',
        'url' => 'https://www.amazon.com/Big-Plush-American-Giant-Inches/dp/B01DBCUC10/ref=sr_1_2?crid=DM7GO615MW8Q&dib=eyJ2IjoiMSJ9.P1LaKplEZFXGOAxI-lEvfg8rxh6JNOPYyCQXopwRJJ3WaH8-AAIj8VtdQh09ZkD8KCrN_ZpfF9LaiN3y3Geud1UP05xOGpPbMz4-KpTsUtSI5FXaQoq5l4LQBl4PECqjyxnbZ0IRJGIwswMCdWD5_QXzUXekkim-WF2dYs5N0hAlxF_KFv7ip107MjNzIrbpAjerZU0wGqzHHCvYUxNHWWDCvBRh7dk97IQ7isBTE8GVaOO55sb-czTQnjBBsU5cDKaKSUKVcgRPUKt3OXrMdC7lYG6YqLI0Tn-veyXZ2Yg.BdlFkGu8k9JClAMgJzIQkV1vb9WPCDvDwxAZHypj0DA&dib_tag=se&keywords=plush+teddy+bear&qid=1753405853&sprefix=Plush+tedd%2Caps%2C100&sr=8-2',
        'category' => 'toys',
        'range' => 'close',
        'description' => 'Soft and cuddly plush teddy bear. A perfect gift for children and loved ones.'
    ]
];

echo json_encode([
    'walmart' => $walmartProducts,
    'amazon' => $amazonProducts
]);