<?php
require '../config/db.php';
require '../includes/functions.php';
session_start();

if(!isAdmin()) die("Нет доступа");

$id = $_GET['id'] ?? null;

if($id){
    $stmt = $pdo->prepare("DELETE FROM comments WHERE post_id=?");
    $stmt->execute([$id]);

    $stmt = $pdo->prepare("DELETE FROM posts WHERE id=?");
    $stmt->execute([$id]);
}

header('Location: posts.php');
exit;