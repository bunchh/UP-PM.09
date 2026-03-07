<?php
require 'config/db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    http_response_code(403);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$pdo->prepare("
INSERT INTO comments(content,user_id,post_id)
VALUES(?,?,?)
")->execute([$data['content'], $_SESSION['user_id'], $data['post_id']]);

// получаем время только что добавленного комментария
$commentId = $pdo->lastInsertId();

$stmt = $pdo->prepare("SELECT created_at FROM comments WHERE id=?");
$stmt->execute([$commentId]);
$created = $stmt->fetchColumn();

echo json_encode([
    "name" => $_SESSION['name'],
    "content" => htmlspecialchars($data['content']),
    "created_at" => date('d.m.Y H:i', strtotime($created))
]);