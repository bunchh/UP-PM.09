<?php
require '../config/db.php';
require '../includes/functions.php';
session_start();

// Проверяем, что пользователь админ
if(!isAdmin()){
    die("Нет доступа");
}

// Получаем ID комментария из GET-параметра
$id = $_GET['id'] ?? null;
if(!$id){
    die("Комментарий не найден");
}

// Удаляем комментарий из БД
$stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
$stmt->execute([$id]);

// После удаления редирект обратно на страницу админа
header('Location: admin_comments.php');
exit;
?>