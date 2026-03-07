<?php
require 'config/db.php';
require 'includes/functions.php';
include 'includes/header.php';

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("
SELECT posts.*, users.name
FROM posts
JOIN users ON posts.user_id=users.id
WHERE posts.id=?
");
$stmt->execute([$id]);
$post = $stmt->fetch();

$stmt = $pdo->prepare("
SELECT comments.*, users.name
FROM comments
JOIN users ON comments.user_id=users.id
WHERE post_id=?
ORDER BY created_at DESC
");
$stmt->execute([$id]);
$comments = $stmt->fetchAll();
?>

<div class="post-container">
    <div class="post-card-single">
        <div class="post-header">
            <div class="post-author"><?= e($post['name']) ?></div>
            <div class="post-meta"><?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></div>
        </div>

        <h2 class="post-title"><?= e($post['title']) ?></h2>

        <?php if($post['image']): ?>
            <img src="<?= e($post['image']) ?>" class="post-image">
        <?php endif; ?>

        <p class="post-content"><?= nl2br(e($post['content'])) ?></p>
    </div>

    <h3 class="section-title">Комментарии</h3>

    <div id="commentsList">
        <?php foreach($comments as $c): ?>
            <div class="comment-card">
                <div class="comment-header">
                    <strong><?= e($c['name']) ?></strong>
                    <span class="comment-date">
                        <?= date('d.m.Y H:i', strtotime($c['created_at'])) ?>
                    </span>
                </div>
                <p><?= e($c['content']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if(isLogged()): ?>
        <form id="commentForm" data-post="<?= $id ?>" class="comment-form">
            <textarea id="content" placeholder="Напишите комментарий..." required></textarea>
            <button>Отправить</button>
        </form>
    <?php else: ?>
        <p>Чтобы оставить комментарий, войдите</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>