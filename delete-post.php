<!-- delete-post.php -->
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // Delete the post
    $stmt = $conn->prepare("DELETE FROM posts WHERE post_id = :post_id");
    $stmt->execute(['post_id' => $post_id]);
}

header("Location: dashboard.php");
exit;
?>
