<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch all posts
$stmt = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - KML Group</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Admin Dashboard</h2>
    <a href="create-post.php" class="btn btn-success mb-3">Create New Post</a>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td><?php echo htmlspecialchars($post['author']); ?></td>
                    <td><?php echo htmlspecialchars($post['category']); ?></td>
                    <td>
                        <a href="edit-post.php?post_id=<?php echo $post['post_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete-post.php?post_id=<?php echo $post['post_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
