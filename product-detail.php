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
    <script src="theme.js"></script>
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
    setcookie('cart', json_encode($_SESSION['cart']), time() + 60*60*24*30, '/'); // 30 days
    echo "<script>alert('Added to cart!'); window.location.href='cart.php';</script>";
    exit;
}
?>