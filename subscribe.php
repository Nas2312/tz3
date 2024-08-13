<?php
include 'includes/db.php';
include 'includes/auth.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subscribed_to = $_POST['subscribed_to'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO subscriptions (user_id, subscribed_to) VALUES (?, ?)");
    if ($stmt->execute([$user_id, $subscribed_to])) {
        echo "Subscribed successfully!";
    } else {
        echo "Error subscribing.";
    }
}
?>

<form method="post">
    User ID to subscribe: <input type="text" name="subscribed_to"><br>
    <input type="submit" value="Subscribe">
</form>
