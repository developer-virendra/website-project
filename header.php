<?php
// includes/header.php
// Header intended to be included from files inside the 'public/' folder.
// It uses relative paths to reach assets at ../assets.

if (!isset($pdo)) {
    require_once __DIR__ . '/config.php';
}

$cart_count = 0;
if (isset($_SESSION['cart_id'])) {
    try {
        $stmt = $pdo->prepare('SELECT SUM(quantity) AS total FROM cart_items WHERE cart_id = ?');
        $stmt->execute([$_SESSION['cart_id']]);
        $cart_count = (int)($stmt->fetchColumn() ?? 0);
    } catch (Exception $e) {
        $cart_count = 0;
    }
}

$asset_base = '../assets';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>My Shop</title>
  <link rel="stylesheet" href="<?php echo $asset_base; ?>/css/style.css">
</head>
<body>
<header class="site-header" style="display:flex;justify-content:space-between;align-items:center;padding:16px;background:#fff;">
  <div style="font-weight:700;"><a href="index.php" style="text-decoration:none;color:inherit;">My Shop</a></div>
  <nav>
    <a href="shop.php">Shop</a>
    <a href="cart.php">Cart (<?php echo $cart_count; ?>)</a>
    <?php if(isset($_SESSION['user_id'])): ?>
      <span style="margin-left:8px;">Hi, <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></span>
      <a href="logout.php" style="margin-left:8px;">Logout</a>
    <?php else: ?>
      <a href="login.php" style="margin-left:8px;">Login</a>
      <a href="register.php" style="margin-left:8px;">Register</a>
    <?php endif; ?>
  </nav>
</header>

<main style="padding:20px;">