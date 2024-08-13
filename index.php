<?php
include 'includes/db.php';
include 'includes/auth.php';

require_login();

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT posts.* 
    FROM posts
    LEFT JOIN subscriptions 
        ON posts.user_id = subscriptions.subscribed_to 
        AND subscriptions.user_id = ?
    WHERE 
        (subscriptions.user_id IS NOT NULL OR posts.user_id = ?) 
        AND posts.is_private = 0
    ORDER BY posts.created_at DESC
");

$stmt->execute([$user_id, $user_id]);
$posts = $stmt->fetchAll();


foreach ($posts as $post) {
    echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
    echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
    echo "<small>Posted on " . htmlspecialchars($post['created_at']) . "</small><hr>";
    echo "<a href='view_post.php?id=" . htmlspecialchars($post['id']) . "'>Просмотреть</a>";
    if ($post['user_id'] == $user_id) {
        echo " <a href='edit_post.php?id=" . htmlspecialchars($post['id']) . "'>Редактировать</a>";
        echo " <a href='delete_post.php?id=" . htmlspecialchars($post['id']) . "' onclick='return confirm(\"Вы уверены, что хотите удалить этот пост?\");'>Удалить</a>";
    }
    echo "<hr>";
}
?>
