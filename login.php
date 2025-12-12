<?php
require_once __DIR__ . '/../includes/config.php';
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if(!$email || !$password) $errors[] = 'Fields required.';
    if(empty($errors)){
        $stmt = $pdo->prepare('SELECT id,name,password FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            if(isset($_SESSION['cart_id'])){
                $stmt = $pdo->prepare('UPDATE carts SET user_id = ? WHERE id = ?');
                $stmt->execute([$_SESSION['user_id'], $_SESSION['cart_id']]);
            }
            header('Location: shop.php');
            exit;
        } else {
            $errors[] = 'Invalid credentials.';
        }
    }
}
require_once __DIR__ . '/../includes/header.php';
?>
<section class="form-wrap">
  <h2>Login</h2>
  <?php if($errors): ?><div class="errors"><?php echo implode('<br>', $errors); ?></div><?php endif; ?>
  <form method="post">
    <label>Email<input name="email" type="email" required></label>
    <label>Password<input name="password" type="password" required></label>
    <button type="submit">Login</button>
  </form>
</section>
</main>
<script src="/assets/js/main.js"></script>
</body>
</html>
