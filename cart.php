<?php
require_once __DIR__ . '/../includes/config.php';
$cart_id = getCartId($pdo);
$stmt = $pdo->prepare('SELECT ci.id as item_id, p.* , ci.quantity FROM cart_items ci JOIN products p ON p.id = ci.product_id WHERE ci.cart_id = ?');
$stmt->execute([$cart_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
require_once __DIR__ . '/../includes/header.php';
?>
<section class="cart">
  <h2>Your Cart</h2>
  <?php if(empty($items)): ?>
    <p>Cart khali hai. <a href="shop.php">Shop now</a></p>
  <?php else: ?>
    <table>
      <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
      <tbody>
        <?php $total=0; foreach($items as $it): ?>
          <?php $sub = $it['price'] * $it['quantity']; $total += $sub; ?>
          <tr>
            <td><?php echo htmlspecialchars($it['name']); ?></td>
            <td>₹<?php echo number_format($it['price'],2); ?></td>
            <td><?php echo $it['quantity']; ?></td>
            <td>₹<?php echo number_format($sub,2); ?></td>
            <td>
              <form method="post" action="/remove_from_cart.php">
                <input type="hidden" name="id" value="<?php echo $it['item_id']; ?>">
                <button type="submit">Remove</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p class="total">Total: ₹<?php echo number_format($total,2); ?></p>
    <a class="btn" href="/checkout.php">Proceed to Checkout</a>
  <?php endif; ?>
</section>
</main>
<script src="/assets/js/main.js"></script>
</body>
</html>
