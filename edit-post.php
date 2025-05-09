<!-- edit-post.php -->
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // Fetch the post data
    $stmt = $conn->prepare("SELECT * FROM posts WHERE post_id = :post_id");
    $stmt->execute(['post_id' => $post_id]);
    $post = $stmt->fetch();

    if (!$post) {
        echo "Post not found.";
        exit;
    }
} else {
    header("Location: admin-dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $topic = $_POST['topic'];

    // Handle Image Update
    if (isset($_FILES["post_image"]) && $_FILES["post_image"]["tmp_name"] != "") {
        $target_dir = "assets/img/blog/";
        $image_name = basename($_FILES["post_image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($_FILES["post_image"]["tmp_name"]);
        if ($check !== false && move_uploaded_file($_FILES["post_image"]["tmp_name"], $target_file)) {
            // Update post with new image
            $stmt = $conn->prepare("UPDATE posts SET title = :title, description = :description, category = :category, topic = :topic, image = :image WHERE post_id = :post_id");
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'category' => $category,
                'topic' => $topic,
                'image' => $target_file,
                'post_id' => $post_id
            ]);
        }
    } else {
        // Update post without changing the image
        $stmt = $conn->prepare("UPDATE posts SET title = :title, description = :description, category = :category, topic = :topic WHERE post_id = :post_id");
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'topic' => $topic,
            'post_id' => $post_id
        ]);
    }

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post - KML Group</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Edit Post</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($post['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($post['category']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Topic</label>
            <input type="text" name="topic" class="form-control" value="<?php echo htmlspecialchars($post['topic']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Post Image</label>
            <input type="file" name="post_image" class="form-control">
            <img src="<?php echo $post['image']; ?>" width="200" class="mt-2">
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
    <br><br>
</div>
</body>
</html>
