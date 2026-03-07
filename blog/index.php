<?php
require_once 'config/db.php';
require_once 'includes/functions.php';
include 'includes/header.php';

$page = $_GET['page'] ?? 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Пагинация
$total_posts = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$total_pages = ceil($total_posts / $limit);

// Получаем посты
$stmt = $pdo->prepare("
SELECT posts.*, users.name,
(SELECT COUNT(*) FROM likes WHERE post_id=posts.id) as likes_count
FROM posts
JOIN users ON posts.user_id=users.id
ORDER BY posts.created_at DESC
LIMIT ? OFFSET ?
");
$stmt->bindValue(1,$limit,PDO::PARAM_INT);
$stmt->bindValue(2,$offset,PDO::PARAM_INT);
$stmt->execute();
$posts=$stmt->fetchAll();
?>

<h2 class="section-title">Делюсь мыслями</h2>

<?php foreach($posts as $post): ?>
<div class="post-card">

    <!-- HEADER -->
    <div class="post-header">
        <div class="post-author">
            <?= e($post['name']) ?>
        </div>

        <div class="post-meta">
            <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?>
        </div>
    </div>

    <!-- TITLE -->
    <h3 class="post-title">
        <a href="post.php?id=<?= $post['id'] ?>">
            <?= e($post['title']) ?>
        </a>
    </h3>

    <!-- IMAGE -->
    <?php if($post['image']): ?>
        <img src="<?= e($post['image']) ?>" class="post-image">
    <?php endif; ?>

    <!-- CONTENT -->
    <p class="post-content">
        <?= e(substr($post['content'],0,200)) ?>...
    </p>

    <!-- LIKE -->
    <button class="like-btn" data-id="<?= $post['id'] ?>">
        ❤️ <span><?= $post['likes_count'] ?></span>
    </button>

</div>
<?php endforeach; ?>

<div class="pagination">
    <?php if($page > 1): ?>
        <a href="?page=<?= $page-1 ?>" class="page-arrow">←</a>
    <?php endif; ?>

    <?php for($i=1;$i<=$total_pages;$i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i==$page?'active':'' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if($page < $total_pages): ?>
        <a href="?page=<?= $page+1 ?>" class="page-arrow">→</a>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>