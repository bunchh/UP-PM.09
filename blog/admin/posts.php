<?php
require '../config/db.php';
require '../includes/functions.php';
session_start();
if(!isAdmin()) die("Нет доступа");

include '../includes/header.php';

$posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll();
?>

<h2 class="section-title">Управление постами</h2>
<div class="admin-buttons">
    <a href="/blog/admin/post_form.php" class="btn">Добавить пост</a>
    <a href="/blog/admin/admin_comments.php" class="btn">Комментарии</a>
</div>

<div class="admin-container">
<?php foreach($posts as $p): ?>
<div class="admin-card">
    <h3><?= e($p['title']) ?></h3>
    <p>Автор ID: <?= e($p['user_id']) ?> | <?= $p['created_at'] ?></p>
    <div class="admin-actions">
        <a href="/blog/admin/post_form.php?id=<?= $p['id'] ?>">Редактировать</a>
        <a href="/blog/admin/delete_post.php?id=<?= $p['id'] ?>">Удалить</a>
    </div>
</div>
<?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>