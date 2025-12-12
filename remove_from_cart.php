<?php
require_once __DIR__ . '/../includes/config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $id = (int)$_POST['id'];
  $stmt = $pdo->prepare('DELETE FROM cart_items WHERE id = ?');
  $stmt->execute([$id]);
}
header('Location: cart.php');
