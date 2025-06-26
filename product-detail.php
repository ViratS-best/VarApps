<?php
// filepath: /opt/lampp/htdocs/Hotel_Manager/product-detail.php
// Fetch product data from datagetter.php
$id = $_GET['id'] ?? '';
$data = json_decode(file_get_contents('http://localhost/Hotel_Manager/datagetter.php'), true);

$product = null;
foreach (['walmart', 'amazon'] as $source) {
    foreach ($data[$source] as $item) {
        if (
            (isset($item['id']) && $item['id'] === $id)
        ) {
            $product = $item;
            break 2;
        }
    }
}

if (!$product) {
    echo "<h2>Product not found.</h2>";
    exit;
}

// For Amazon, use 'title' and 'image'; for Walmart, use 'name' and 'thumbnailImage'
$title = $product['name'] ?? $product['title'];
$image = $product['thumbnailImage'] ?? $product['image'];
$price = $product['salePrice'] ?? $product['price'];
$link = $product['productUrl'] ?? $product['url'];
$desc = $product['description'] ?? 'No description available.';
$category = ucfirst($product['category']);
$range = $product['range'];
$source = strpos($id, 'amazon') === 0 ? 'Amazon' : 'Walmart';
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($title); ?> - VarCart</title>
    <link rel="stylesheet" href="styles.css">
    <style>
body {
    background: #f6f8fa;
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0;
    padding: 0;
}
.product-detail {
    max-width: 420px;
    margin: 80px auto 0 auto;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(60,60,100,0.13);
    padding: 36px 28px 28px 28px;
    text-align: center;
}
.product-detail img {
    max-width: 220px;
    margin-bottom: 18px;
    border-radius: 10px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    background: #f9f9f9;
}
.product-detail h2 {
    color: #2a2a44;
    margin-bottom: 10px;
    font-size: 1.5em;
}
.product-detail .meta {
    color: #666;
    font-size: 1em;
    margin-bottom: 12px;
}
.product-detail .price {
    color: #2d7a2d;
    font-size: 1.3em;
    font-weight: bold;
    margin-bottom: 18px;
}
.product-detail .desc {
    color: #444;
    font-size: 1.08em;
    margin-bottom: 18px;
}
.product-detail .external-link {
    display: inline-block;
    margin-top: 12px;
    padding: 10px 24px;
    background: #00abf0;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.2s;
    box-shadow: 0 2px 8px rgba(0,171,240,0.08);
}
.product-detail .external-link:hover {
    background: #008bbd;
}
.product-detail .back-link {
    display: block;
    margin-top: 24px;
    color: #00abf0;
    text-decoration: underline;
    font-size: 1em;
    transition: color 0.2s;
}
.product-detail .back-link:hover {
    color: #008bbd;
}
@media (max-width: 600px) {
    .product-detail {
        max-width: 98vw;
        padding: 18px 4vw;
        margin-top: 32px;
    }
    .product-detail img {
        max-width: 90vw;
    }
}
</style>
</head>
<body>
    <div class="product-detail">
        <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($title); ?>">
        <h2><?php echo htmlspecialchars($title); ?></h2>
        <div class="meta">
            Source: <?php echo $source; ?> |
            Category: <?php echo htmlspecialchars($category); ?> |
            Range: <?php echo htmlspecialchars($range); ?>
        </div>
        <div class="price"><?php echo is_numeric($price) ? '$' . $price : $price; ?></div>
        <div class="desc"><?php echo htmlspecialchars($desc); ?></div>
        <a class="external-link" href="<?php echo htmlspecialchars($link); ?>" target="_blank">
            View on <?php echo $source; ?>
        </a>
        <a class="back-link" href="Dashboard.php">&larr; Back to Dashboard</a>
        <form method="post" style="margin-top:18px;">
            <input type="hidden" name="add_to_cart" value="<?php echo htmlspecialchars($id); ?>">
            <button type="submit" class="external-link" style="background:#2d7a2d;margin-bottom:8px;">Add to Cart</button>
        </form>
    </div>
</body>
</html>
<?php
// Handle Add to Cart
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    // Prevent duplicates
    if (!in_array($id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $id;
    }
    echo "<script>alert('Added to cart!'); window.location.href='cart.php';</script>";
    exit;
}
?>