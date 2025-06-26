<?php
session_start();
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
    <style>
        body {
            background: #f6f8fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .cart-list {
            max-width: 540px;
            margin: 80px auto 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(60,60,100,0.13);
            padding: 36px 28px 28px 28px;
        }
        .cart-list h2 {
            text-align: center;
            color: #2a2a44;
            margin-bottom: 24px;
            font-size: 1.5em;
        }
        .cart-item {
            display: flex;
            align-items: center;
            gap: 18px;
            border-bottom: 1px solid #eee;
            padding: 18px 0;
            transition: background 0.2s;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            background: #f9f9f9;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .cart-item-title {
            font-weight: 600;
            color: #3a3a60;
            font-size: 1.08em;
        }
        .cart-item-meta {
            color: #666;
            font-size: 0.98em;
            margin-bottom: 4px;
        }
        .cart-item-price {
            color: #2d7a2d;
            font-weight: bold;
            font-size: 1.08em;
        }
        .cart-item > form {
            margin-left: auto;
        }
        .remove-btn {
            background: #e63946;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 7px 16px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1em;
            transition: background 0.2s;
        }
        .remove-btn:hover {
            background: #b71c1c;
        }
        .empty {
            text-align: center;
            color: #888;
            margin: 40px 0;
            font-size: 1.1em;
        }
        .back-link {
            display: block;
            margin-top: 32px;
            color: #00abf0;
            text-decoration: underline;
            font-size: 1em;
            text-align: center;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #008bbd;
        }
        @media (max-width: 600px) {
            .cart-list {
                max-width: 98vw;
                padding: 18px 4vw;
                margin-top: 32px;
            }
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                padding: 14px 0;
            }
            .cart-item img {
                width: 54px;
                height: 54px;
            }
            .cart-item > form {
                margin-left: 0;
                margin-top: 8px;
                width: 100%;
            }
            .remove-btn {
                width: 100%;
            }
        }
    </style>
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
