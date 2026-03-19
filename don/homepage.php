<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage — YearOne</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Fraunces:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <span class="brand-name">YearOne</span>
    <div class="header-right">
        Hello, <strong><?= $username ?></strong>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<main class="main-content">
    <h1>Welcome back, <?= $username ?>!</h1>
    <p>You're now logged in. This page is protected — Feel free to explore anything you want.</p>
</main>

<footer class="site-footer">
    <p>&copy; 2025 YearOne</p>
</footer>

</body>
</html>