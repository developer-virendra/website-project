<?php
require_once __DIR__ . '/../includes/config.php';
if($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: shop.php'); exit; }
$product_id = (int)$_POST['product_id'];
$qty = isset($_POST['quantity']) ? max(1,(int)$_POST['quantity']) : 1;
$cart_id = getCartId($pdo);
$stmt = $pdo->prepare('SELECT id,quantity FROM cart_items WHERE cart_id = ? AND product_id = ? LIMIT 1');
$stmt->execute([$cart_id,$product_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row){
    $newQ = $row['quantity'] + $qty;
    $stmt = $pdo->prepare('UPDATE cart_items SET quantity = ? WHERE id = ?');
    $stmt->execute([$newQ,$row['id']]);
} else {
    $stmt = $pdo->prepare('INSERT INTO cart_items (cart_id,product_id,quantity) VALUES (?,?,?)');
    $stmt->execute([$cart_id,$product_id,$qty]);
}
header('Location: cart.php');
exit;
