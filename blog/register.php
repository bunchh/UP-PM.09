<?php
require_once 'config/db.php';
include 'includes/header.php';

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if(strlen($password)<6){
        $error="Минимум 6 символов";
    } elseif($password!==$confirm){
        $error="Пароли не совпадают";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);
        if($stmt->fetch()){
            $error="Email уже существует";
        } else {
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $pdo->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)")
                ->execute([$name,$email,$hash]);
            header("Location: login.php");
            exit;
        }
    }
}
?>

<form method="POST" class="auth-form">

    <h2 class="form-title">Регистрация</h2>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <input name="name" placeholder="Имя" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Пароль" required>
    <input name="confirm" type="password" placeholder="Повторите пароль" required>

    <button type="submit">Зарегистрироваться</button>

</form>

<?php include 'includes/footer.php'; ?>