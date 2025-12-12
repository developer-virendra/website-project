<?php
require_once __DIR__ . '/../includes/config.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$p) { header('Location: shop.php'); exit; }
require_once __DIR__ . '/../includes/header.php';
?>
<section class="product-detail">
  <img src="<?php echo htmlspecialchars($p['image']); ?>" style="max-width:320px">
  <h2><?php echo htmlspecialchars($p['name']); ?></h2>
  <p><?php echo nl2br(htmlspecialchars($p['description'])); ?></p>
  <p>₹<?php echo number_format($p['price'],2); ?></p>
  <form method="post" action="/add_to_cart.php">
    <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
    <label>Qty <input type="number" name="quantity" value="1" min="1"></label>
    <button type="submit">Add to cart</button>
  </form>
</section>
</main>
<script src="/assets/js/main.js"></script>
</body>
</html>
