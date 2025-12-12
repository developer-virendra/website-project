<?php
require_once __DIR__ . '/../includes/config.php';
// very simple admin: no auth; for demo only
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $image_path = 'assets/img-placeholder.png';
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
        $tmp = $_FILES['image']['tmp_name'];
        $fname = basename($_FILES['image']['name']);
        $dst = __DIR__ . '/assets/uploads/';
        if(!is_dir($dst)) mkdir($dst, 0755, true);
        $target = '/assets/uploads/' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\.\-]/','_', $fname);
        move_uploaded_file($tmp, __DIR__ . $target);
        $image_path = $target;
    }
    if(!$name || !$price) $errors[] = 'Name and price required.';
    if(empty($errors)){
        $stmt = $pdo->prepare('INSERT INTO products (name,description,price,image) VALUES (?,?,?,?)');
        $stmt->execute([$name,$desc,$price,$image_path]);
        header('Location: admin.php');
        exit;
    }
}
require_once __DIR__ . '/../includes/header.php';
?>
<section class="form-wrap">
  <h2>Admin - Add Product</h2>
  <?php if($errors): ?><div class="errors">
  <?php echo implode('<br>',$errors); ?></div><?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <label>Product name<input name="name" required></label>
    <label>Description<textarea name="description"></textarea></label>
    <label>Price<input name="price" type="number" step="0.01" required></label>
    <label>Image<input name="image" type="file" accept="image/*"></label>
    <button type="submit">Add Product</button>
  </form>
  <hr>
  <h3>Existing products</h3>
  <ul>
    <?php
    $stmt = $pdo->query('SELECT * FROM products ORDER BY id DESC');
    while($p = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo '<li>' . htmlspecialchars($p['name']) . ' - ₹' . number_format($p['price'],2) . '</li>';
    }
    ?>
  </ul>
</section>
</main>
<script src="/assets/js/main.js""></script>
</body>
</html>
