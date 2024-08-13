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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];

            $stmt = $pdo->prepare('UPDATE posts SET title = ?, content = ? WHERE id = ?');
            $stmt->execute([$title, $content, $post_id]);
            echo "Пост успешно обновлен!";
        }
    } else {
        echo "Пост не найден или вы не имеете права его редактировать.";
    }
} else {
    echo "Не указан ID поста.";
}
?>

<form method="POST">
    <label>Заголовок:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>">
    <br>
    <label>Содержание:</label>
    <textarea name="content"><?php echo htmlspecialchars($post['content']); ?></textarea>
    <br>
    <button type="submit">Сохранить изменения</button>
</form>
