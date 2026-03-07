<?php
require '../config/db.php';
require '../includes/functions.php';
session_start();
if(!isAdmin()) die("Нет доступа");

$id = $_GET['id'] ?? null;
$post = ['title'=>'','content'=>'','image'=>''];

if($id){
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_path = $post['image'];

    if(!empty($_FILES['image']['name'])){
        $image_path = 'uploads/'.time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../'.$image_path);
    }

    if($id){
        $stmt = $pdo->prepare("UPDATE posts SET title=?, content=?, image=? WHERE id=?");
        $stmt->execute([$title,$content,$image_path,$id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO posts(title,content,user_id,image) VALUES(?,?,?,?)");
        $stmt->execute([$title,$content,$_SESSION['user_id'],$image_path]);
    }

    header('Location: posts.php');
    exit;
}

include '../includes/header.php';
?>

<h2 class="section-title"><?= $id ? 'Редактировать пост' : 'Добавить пост' ?></h2>

<form method="POST" enctype="multipart/form-data" class="admin-form">
    <input name="title" placeholder="Заголовок" value="<?= e($post['title']) ?>" required>
    <textarea name="content" placeholder="Текст" required><?= e($post['content']) ?></textarea>
    <input type="file" name="image">
    <button><?= $id ? 'Сохранить' : 'Добавить' ?></button>
</form>

<?php include '../includes/footer.php'; ?>