<?php
require_once __DIR__ . '/../includes/config.php';
$cart_id = getCartId($pdo);
$stmt = $pdo->prepare('SELECT p.price, ci.quantity FROM cart_items ci JOIN products p ON p.id = ci.product_id WHERE ci.cart_id = ?');
$stmt->execute([$cart_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = 0;
foreach($items as $it) $total += $it['price'] * $it['quantity'];
require_once __DIR__ . '/../includes/header.php';
?>
<section class="form-wrap">
  <h2>Checkout</h2>
  <p>Total: ₹<?php echo number_format($total,2); ?></p>
  <p>This is a placeholder checkout. To integrate payments (e.g. Razorpay or Stripe), add server-side order creation and client-side payment JS.</p>
  <p><strong>Razorpay quick hint:</strong> create order on server, then include Razorpay checkout on client and call open() with returned order_id.</p>
  <p>If you want, I can add a working Razorpay example (requires your API keys).</p>
</section>
</main>
<script src="/assets/js/main.js"></script>
</body>
</html>
