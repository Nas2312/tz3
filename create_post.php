<?php
include 'includes/db.php';
include 'includes/auth.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $is_private = isset($_POST['is_private']) ? 1 : 0;
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content, is_private) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $title, $content, $is_private])) {
        echo "Post created successfully!";
    } else {
        echo "Error creating post.";
    }
}
?>

<form method="post">
    Title: <input type="text" name="title"><br>
    Content: <textarea name="content"></textarea><br>
    Private: <input type="checkbox" name="is_private"><br>
    <input type="submit" value="Create Post">
</form>
