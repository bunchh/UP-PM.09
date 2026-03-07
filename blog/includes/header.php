<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blog</title>
<link rel="stylesheet" href="/blog/assets/css/style.css?v=3">
</head>
<body>

<header class="header">
    <div class="logo"><a href="/blog/index.php">Blog</a></div>

    <div class="burger" id="burger">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <nav class="nav" id="nav">
        <a href="/blog/index.php">Главная</a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <?php if(isAdmin()): ?>
                <a href="/blog/admin/posts.php">Админ</a>
            <?php endif; ?>
            <a href="/blog/logout.php">Выйти</a>
        <?php else: ?>
            <a href="/blog/login.php">Войти</a>
            <a href="/blog/register.php">Регистрация</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">