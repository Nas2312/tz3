<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? null;
    $content = $_POST['content'] ?? null;

    if ($post_id && $content) {
        // Получаем ID пользователя
        $user_id = $_SESSION['user_id'];
    
        // Вставляем комментарий в базу данных
        $stmt = $pdo->prepare('INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$post_id, $user_id, $content]);

        // Перенаправляем обратно на страницу поста
        header("Location: view_post.php?id=" . $post_id);
        exit;
    } else {
        echo "<p>Ошибка: некорректные данные.</p>";
    }
} else {
    echo "<p>Неверный метод запроса.</p>";
}
