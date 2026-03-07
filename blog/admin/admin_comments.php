<?php
require '../config/db.php';
require '../includes/functions.php';
session_start();
if(!isAdmin()) die("Нет доступа");

include '../includes/header.php';

// Параметры пагинации
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// Общее количество комментариев
$total_comments = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
$total_pages = ceil($total_comments / $limit);

// Получаем комментарии
$stmt = $pdo->prepare("
    SELECT comments.*, users.name, posts.title AS post_title
    FROM comments
    JOIN users ON comments.user_id = users.id
    JOIN posts ON comments.post_id = posts.id
    ORDER BY comments.created_at DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll();
?>

<h2 class="section-title">Управление комментариями</h2>

<div class="admin-container">
<?php foreach($comments as $c): ?>
<div class="admin-card">
    <div class="comment-header">
        <strong><?= e($c['name']) ?></strong>
        <span><?= date('d.m.Y H:i', strtotime($c['created_at'])) ?></span>
    </div>
    <p><em>Пост: <?= e($c['post_title']) ?></em></p>
    <p><?= e($c['content']) ?></p>
    <div class="admin-actions">
        <a href="delete_comment.php?id=<?= $c['id'] ?>" onclick="return confirm('Удалить этот комментарий?')">Удалить</a>
    </div>
</div>
<?php endforeach; ?>
</div>

<div class="pagination">
    <?php if($page > 1): ?>
        <a href="?page=<?= $page-1 ?>">←</a>
    <?php endif; ?>

    <?php for($i=1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>" <?= $i==$page ? 'class="active"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>

    <?php if($page < $total_pages): ?>
        <a href="?page=<?= $page+1 ?>">→</a>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>