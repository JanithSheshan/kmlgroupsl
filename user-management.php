<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db.php';

$duplicateError = "";

// Handle user deletion
if (isset($_GET['delete_user_id'])) {
    $delete_user_id = $_GET['delete_user_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$delete_user_id]);
    header("Location: user-management.php");
    exit;
}

// Fetch all users
$stmt = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle adding a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $author_image = 'assets/img/blog/default-author.jpg';

    // Handle image upload
    if (!empty($_FILES['author_image']['name'])) {
        $imageName = uniqid() . '-' . $_FILES['author_image']['name'];
        $imagePath = 'assets/img/blog/' . $imageName;
        
        if (move_uploaded_file($_FILES['author_image']['tmp_name'], $imagePath)) {
            $author_image = $imagePath;
        }
    }

    // Check for duplicate username or email
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->rowCount() > 0) {
        $duplicateError = "Username or email already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type, author_image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password, $email, $user_type, $author_image]);
        header("Location: user-management.php");
        exit;
    }
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $author_image = $_POST['existing_image'];

    // Handle image upload
    if (!empty($_FILES['author_image']['name'])) {
        $imageName = uniqid() . '-' . $_FILES['author_image']['name'];
        $imagePath = 'assets/img/blog/' . $imageName;
        
        if (move_uploaded_file($_FILES['author_image']['tmp_name'], $imagePath)) {
            $author_image = $imagePath;
        }
    }

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, user_type = ?, author_image = ? WHERE user_id = ?");
    $stmt->execute([$username, $email, $user_type, $author_image, $user_id]);
    header("Location: user-management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - KML Group</title>
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

        .header .nav-links a {
            color: #ffffff;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        .header .nav-links a:hover {
            background-color: #0056b3;
            color: #ffffff;
        }

        .card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-warning, .btn-danger {
            color: #ffffff;
            border: none;
        }

        .btn-create {
            background-color: #1e4356;
            color: #ffffff;
            border: none;
            margin-bottom: 15px;
            width: 100%;
        }

        .btn-create:hover, .btn-warning:hover, .btn-danger:hover {
            background-color: #0056b3;
            color: #ffffff;
        }

        .form-control {
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .table th {
            background-color: #1e4356;
            color: #ffffff;
        }

        .alert-duplicate {
            color: #d9534f;
            margin-bottom: 15px;
        }

    </style>
</head>

<body>
<header class="header">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
        <a href="dashboard.php" class="sitename">KML GROUP</a>
        <div class="nav-links">
            <a href="dashboard.php" class="btn btn-primary">Post Management</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</header>

<div class="container relative" style="margin-top: 80px;">
    <div class="card">
        <h2 class="text-center">User Management</h2>

        <!-- Duplicate Error Message -->
        <?php if ($duplicateError): ?>
            <div class="alert-duplicate"><?php echo $duplicateError; ?></div>
        <?php endif; ?>

        <!-- Add User Form -->
        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <h4>Add New User</h4>
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="username" placeholder="Username" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" placeholder="Email" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <select name="user_type" class="form-control" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="file" name="author_image" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" name="add_user" class="btn btn-create w-100">Add</button>
                </div>
            </div>
        </form>

        <!-- User Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <input type="hidden" name="existing_image" value="<?php echo $user['author_image']; ?>">
                            <td><input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="form-control"></td>
                            <td><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control"></td>
                            <td>
                                <select name="user_type" class="form-control">
                                    <option value="user" <?php echo $user['user_type'] === 'user' ? 'selected' : ''; ?>>User</option>
                                    <option value="admin" <?php echo $user['user_type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </td>
                            <td>
                                <img src="<?php echo $user['author_image']; ?>" width="50">
                                <input type="file" name="author_image" class="form-control">
                            </td>
                            <td>
                                <button type="submit" name="update_user" class="btn btn-warning btn-sm">Update</button>
                                <a href="?delete_user_id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
