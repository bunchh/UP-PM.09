<?php
require_once 'config/db.php';
include 'includes/header.php';

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])){
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Неверные данные";
    }
}
?>

<form method="POST" class="auth-form">

    <h2 class="form-title">Вход</h2>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Пароль" required>

    <button type="submit">Войти</button>

</form>

<?php include 'includes/footer.php'; ?>