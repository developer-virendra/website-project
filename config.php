<?php
// includes/config.php
session_start();

// Update these with your local DB credentials
$db_host = 'localhost';
$db_name = 'ecommerce';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

function getCartId($pdo) {
    if(isset($_SESSION['cart_id'])) return $_SESSION['cart_id'];
    $session_id = session_id();
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    $stmt = $pdo->prepare('SELECT id FROM carts WHERE session_id = ? LIMIT 1');
    $stmt->execute([$session_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row) {
        $_SESSION['cart_id'] = $row['id'];
        return $row['id'];
    }
    $stmt = $pdo->prepare('INSERT INTO carts (user_id, session_id) VALUES (?, ?)');
    $stmt->execute([$user_id, $session_id]);
    $id = $pdo->lastInsertId();
    $_SESSION['cart_id'] = $id;
    return $id;
}
