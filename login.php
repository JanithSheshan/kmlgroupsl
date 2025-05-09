<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Assuming you are using MD5

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type']; // Store user type
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login - KML Group</title>

    <!-- Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <style>
        body {
            margin-top: 100px;
            margin-bottom: 50px;
        }

        .header {
            background-color: #1e4356 !important;
        }

        .header .sitename {
            color: #ffffff;
        }

        .btn {
            background-color: #1e4356;
            color: #ffffff;
            border: none;
            width: 100%;
        }

        .btn:hover {
            background-color: #0056b3;
            color: #ffffff;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>

</head>

<body>
    <header class="header d-flex align-items-center fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo">
                <h1 class="sitename">KML GROUP</h1>
            </a>
        </div>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center">Admin Login</h2>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
