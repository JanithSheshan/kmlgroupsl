<?php
include 'db_config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM blogs WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $author = $_POST['author'];
    $image = $_POST['image'];
    $title = $_POST['title'];
    $link = $_POST['link'];

    $sql = "UPDATE blogs SET category='$category', date='$date', author='$author', image='$image', title='$title', link='$link' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Blog</title>
</head>
<body>
    <form method="post" action="edit_blog.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label>Category:</label>
        <input type="text" name="category" value="<?php echo $row['category']; ?>"><br>
        <label>Date:</label>
        <input type="text" name="date" value="<?php echo $row['date']; ?>"><br>
        <label>Author:</label>
        <input type="text" name="author" value="<?php echo $row['author']; ?>"><br>
        <label>Image:</label>
        <input type="text" name="image" value="<?php echo $row['image']; ?>"><br>
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo $row['title']; ?>"><br>
        <label>Link:</label>
        <input type="text" name="link" value="<?php echo $row['link']; ?>"><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
