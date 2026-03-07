<?php
require 'config/db.php';
session_start();

if(!isset($_SESSION['user_id'])) exit;

$post_id=$_POST['post_id'];
$user_id=$_SESSION['user_id'];

$stmt=$pdo->prepare("SELECT id FROM likes WHERE user_id=? AND post_id=?");
$stmt->execute([$user_id,$post_id]);

if($stmt->fetch()){
    $pdo->prepare("DELETE FROM likes WHERE user_id=? AND post_id=?")
        ->execute([$user_id,$post_id]);
} else {
    $pdo->prepare("INSERT INTO likes(user_id,post_id) VALUES(?,?)")
        ->execute([$user_id,$post_id]);
}