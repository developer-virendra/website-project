<?php
require_once __DIR__ . '/../includes/config.php';
$stmt = $pdo->query('SELECT * FROM products ORDER BY created_at DESC');
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
require_once __DIR__ . '/../includes/header.php';
?>
<section class="product-grid">
  <?php foreach($products as $p): ?>
    <article class="card">
      <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="" style="max-width:100%;height:140px;object-fit:cover">
      <h3><?php echo htmlspecialchars($p['name']); ?></h3>
      <p>₹<?php echo number_format($p['price'],2); ?></p>
      <a href="/product.php?id=<?php echo $p['id']; ?>">View</a>
      <form method="post" action="/add_to_cart.php">
        <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
        <button type="submit">Add to cart</button>
      </form>
    </article>
  <?php endforeach; ?>
</section>
</main>
<script src="/assets/js/main.js"></script>
</body>
</html>
