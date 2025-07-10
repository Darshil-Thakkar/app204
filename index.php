<?php
session_start();

// Define products
$products = [
    1 => ['name' => 'T-shirt', 'price' => 200],
    2 => ['name' => 'Jeans', 'price' => 400],
    3 => ['name' => 'Sneakers', 'price' => 600],
];

// Add to cart
if (isset($_POST['product_id'])) {
    $id = $_POST['product_id'];
    if (isset($products[$id])) {
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 0;
        }
        $_SESSION['cart'][$id]++;
    }
}

// Clear cart
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple PHP Shopping Site</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .product, .cart { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
        .product { background: #f9f9f9; }
        .cart { background: #eef; }
        .btn { padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>

<h1>Simple Shopping Website</h1>

<h2>Products</h2>
<?php foreach ($products as $id => $product): ?>
    <div class="product">
        <strong><?= htmlspecialchars($product['name']) ?></strong><br>
        Price: $<?= number_format($product['price'], 2) ?><br>
        <form method="POST" style="margin-top: 5px;">
            <input type="hidden" name="product_id" value="<?= $id ?>">
            <button class="btn" type="submit">Add to Cart</button>
        </form>
    </div>
<?php endforeach; ?>

<h2>Shopping Cart</h2>
<div class="cart">
    <?php if (!empty($_SESSION['cart'])): ?>
        <ul>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $qty):
                $product = $products[$id];
                $subtotal = $product['price'] * $qty;
                $total += $subtotal;
            ?>
                <li><?= htmlspecialchars($product['name']) ?> x <?= $qty ?> = $<?= number_format($subtotal, 2) ?></li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Total: $<?= number_format($total, 2) ?></strong></p>
        <form method="POST">
            <input type="hidden" name="clear_cart" value="1">
            <button class="btn" type="submit">Clear Cart</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

</body>
</html>
