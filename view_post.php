<?php
session_start();
require 'includes/db.php';
require 'includes/auth.php';

require_login();

$post_id = $_GET['id'] ?? null;

if ($post_id) {
    $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
    $stmt->execute([$post_id]);
    $post = $stmt->fetch();

    if ($post) {
        echo "<h1>" . htmlspecialchars($post['title']) . "</h1>";
        echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";

        $stmt = $pdo->prepare('SELECT * FROM comments WHERE post_id = ? ORDER BY created_at ASC');
        $stmt->execute([$post_id]);
        $comments = $stmt->fetchAll();

        echo "<h2>Комментарии:</h2>";
        foreach ($comments as $comment) {
            echo "<p><strong>" . htmlspecialchars($comment['user_id']) . ":</strong> " . htmlspecialchars($comment['content']) . "</p>";
        }

        if (isset($_SESSION['user_id'])) {
            echo '<h3>Добавить комментарий:</h3>';
            echo '<form action="comment.php" method="post">';
            echo '<input type="hidden" name="post_id" value="' . htmlspecialchars($post_id) . '">';
            echo '<textarea name="content" required></textarea><br>';
            echo '<button type="submit">Отправить</button>';
            echo '</form>';
        } else {
            echo '<p><a href="login.php">Войдите</a>, чтобы оставить комментарий.</p>';
        }

    } else {
        echo "<p>Пост не найден.</p>";
    }
} else {
    echo "<p>Неверный запрос.</p>";
}
