<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';

require_login();

$post_id = $_GET['id'] ?? null;

if ($post_id) {
    $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ? AND user_id = ?');
    $stmt->execute([$post_id, $_SESSION['user_id']]);
    $post = $stmt->fetch();

    if ($post) {
        $stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
        $stmt->execute([$post_id]);
        echo "Пост успешно удален!";
    } else {
        echo "Пост не найден или вы не имеете права его удалить.";
    }
} else {
    echo "Не указан ID поста.";
}
?>
