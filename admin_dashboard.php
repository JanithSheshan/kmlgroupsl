<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit();
}

include 'db_config.php';

$sql = "SELECT id, category, date, author, image, title, link FROM blogs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <a href="logout.php">Logout</a>
    <table border="1">
        <tr>
            <th>Category</th>
            <th>Date</th>
            <th>Author</th>
            <th>Image</th>
            <th>Title</th>
            <th>Link</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["category"] . '</td>';
                echo '<td>' . $row["date"] . '</td>';
                echo '<td>' . $row["author"] . '</td>';
                echo '<td><img src="' . $row["image"] . '" width="50"></td>';
                echo '<td>' . $row["title"] . '</td>';
                echo '<td>' . $row["link"] . '</td>';
                echo '<td>';
                echo '<a href="edit_blog.php?id=' . $row["id"] . '">Edit</a> ';
                echo '<a href="delete_blog.php?id=' . $row["id"] . '">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="7">No blogs found.</td></tr>';
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
