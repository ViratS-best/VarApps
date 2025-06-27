<?php
session_start();
if (!isset($_SESSION['cart']) && isset($_COOKIE['cart'])) {
    $_SESSION['cart'] = json_decode($_COOKIE['cart'], true) ?? [];
}
$cart = $_SESSION['cart'] ?? [];
$cart = $_SESSION['cart'] ?? [];
$data = json_decode(file_get_contents('http://localhost/Hotel_Manager/datagetter.php'), true);

function findProduct($id, $data) {
    foreach (['walmart', 'amazon'] as $source) {
        foreach ($data[$source] as $item) {
            if (isset($item['id']) && $item['id'] === $id) return $item;
        }
    }
    return null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart - VarCart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cart-list">
        <h2>Your Cart</h2>
        <?php if (empty($cart)): ?>
            <div class="empty">Your cart is empty.</div>
        <?php else: ?>
            <?php foreach ($cart as $id): 
                $item = findProduct($id, $data);
                if (!$item) continue;
                $title = $item['name'] ?? $item['title'];
                $image = $item['thumbnailImage'] ?? $item['image'];
                $price = $item['salePrice'] ?? $item['price'];
                $category = ucfirst($item['category']);
            ?>
            <div class="cart-item">
                <img src="<?php echo htmlspecialchars($image); ?>" alt="">
                <div>
                    <div class="cart-item-title"><?php echo htmlspecialchars($title); ?></div>
                    <div class="cart-item-meta"><?php echo htmlspecialchars($category); ?></div>
                    <div class="cart-item-price"><?php echo is_numeric($price) ? '$' . $price : $price; ?></div>
                </div>
                <form method="post" style="margin-left:auto;">
                    <input type="hidden" name="remove" value="<?php echo htmlspecialchars($id); ?>">
                    <button type="submit" class="remove-btn">Remove</button>
                </form>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <a class="back-link" href="Dashboard.php">&larr; Back to Dashboard</a>
    </div>
    <script src="theme.js"></script>
    <?php
    // Remove from cart
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
        $_SESSION['cart'] = array_values(array_diff($cart, [$_POST['remove']]));
        echo "<script>window.location.href='cart.php';</script>";
        exit;
    }
    ?>
</body>
</html>
