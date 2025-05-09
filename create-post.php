<!-- create-post.php -->
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $topic = $_POST['topic'];
    $author = $_SESSION['username'];

    // Get author image from users table
    $stmt = $conn->prepare("SELECT author_image FROM users WHERE username = :username");
    $stmt->execute(['username' => $author]);
    $author_image = $stmt->fetchColumn();

    // Handle Image Upload
    $target_dir = "assets/img/blog/";
    $image_name = basename($_FILES["post_image"]["name"]);
    $target_file = $target_dir . $image_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    if (isset($_FILES["post_image"]) && $_FILES["post_image"]["tmp_name"] != "") {
        $check = getimagesize($_FILES["post_image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["post_image"]["tmp_name"], $target_file)) {
                // Save the post
                $stmt = $conn->prepare("INSERT INTO posts (title, description, category, topic, image, author, author_image) VALUES (:title, :description, :category, :topic, :image, :author, :author_image)");
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'category' => $category,
                    'topic' => $topic,
                    'image' => $target_file,
                    'author' => $author,
                    'author_image' => $author_image
                ]);
                header("Location: dashboard.php");
                exit;
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error_message = "File is not an image.";
        }
    } else {
        $error_message = "Please upload a valid image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Post - KML Group</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

</head>
<body>
<div class="container">
    <h2 class="mt-4">Create New Post</h2>
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Topic</label>
            <input type="text" name="topic" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Post Image</label>
            <input type="file" name="post_image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
