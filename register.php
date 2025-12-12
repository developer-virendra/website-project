<?php
require_once __DIR__ . '/../includes/config.php';
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if(!$name || !$email || !$password) $errors[] = 'Sab fields bharein.';
    if($password !== $password2) $errors[] = 'Passwords match nahi karte.';

    if(empty($errors)){
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if($stmt->fetch()){
            $errors[] = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (name,email,password) VALUES (?,?,?)');
            $stmt->execute([$name,$email,$hash]);
            header('Location: login.php');
            exit;
        }
    }
}
require_once __DIR__ . '/../includes/header.php';
?>
<section class="form-wrap">
  <h2>Register</h2>
  <?php if($errors): ?><div class="errors"><?php echo implode('<br>', $errors); ?></div><?php endif; ?>
  <form method="post">
    <label>Name<input name="name" required></label>
    <label>Email<input name="email" type="email" required></label>
    <label>Password<input name="password" type="password" required></label>
    <label>Confirm Password<input name="password2" type="password" required></label>
    <button type="submit">Register</button>
  </form>
</section>
</main>
<script src="/assets/js/main.js"></script>
</body>
</html>
