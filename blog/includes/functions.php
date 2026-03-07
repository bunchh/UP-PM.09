<?php
function e($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function isLogged(){
    return isset($_SESSION['user_id']);
}

function isAdmin(){
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
?>