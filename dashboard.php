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

$user_type = $_SESSION['user_type']; // Get the user type from the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - KML Group</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <style>
        .header {
            background-color: #1e4356 !important;
            padding: 15px 20px;
            color: #ffffff;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .header .sitename {
            font-size: 1.5rem;
            color: #ffffff;
            text-decoration: none;
        }

        .header .nav-links {
            display: flex;
            gap: 15px;
        }

        .header .nav-links a {
            color: #ffffff;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .header .nav-links a:hover {
            background-color: #0056b3;
            color: #ffffff;
        }

        .btn-create {
            background-color: #1e4356;
            color: #ffffff;
            border: none;
            margin-bottom: 15px;
            width: 100%;
        }

        .btn-create:hover {
            background-color: #0056b3;
            color: #ffffff;
        }

        .container {
            padding: 10px;
        }

        @media (max-width: 768px) {
            .header .nav-links {
                flex-direction: column;
                gap: 10px;
            }

            .header .sitename {
                font-size: 1.2rem;
                margin-bottom: 10px;
            }

            .btn-create {
                margin-bottom: 20px;
            }

            table thead {
                display: none;
            }

            table tbody tr {
                display: block;
                margin-bottom: 15px;
                background-color: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            table tbody tr td {
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid #ddd;
            }

            table tbody tr td:last-child {
                border-bottom: none;
            }

            table tbody tr td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #333;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <a href="dashboard.php" class="sitename">KML GROUP</a>
            <div class="nav-links">
                <?php if ($user_type === 'admin'): ?>
                    <a href="user-management.php" class="btn btn-primary">User Management</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </header>

    <div class="container relative" style="margin-top: 100px;">
        <h2 class="text-center">Admin Dashboard</h2>
        <a href="create-post.php" class="btn btn-create">Create New Post</a>
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
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td data-label="Title"><?php echo htmlspecialchars($post['title']); ?></td>
                        <td data-label="Author"><?php echo htmlspecialchars($post['author']); ?></td>
                        <td data-label="Category"><?php echo htmlspecialchars($post['category']); ?></td>
                        <td data-label="Actions">
                            <a href="edit-post.php?post_id=<?php echo $post['post_id']; ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete-post.php?post_id=<?php echo $post['post_id']; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>