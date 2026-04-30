<?php
session_start();
$error = '';
if (!isset($_POST['submit'])) {
    header('Location: signup.php');
    exit();
}
include 'connection.php';
$firstname = trim($_POST['firstname'] ?? '');
$lastname  = trim($_POST['lastname'] ?? '');
$email     = trim($_POST['email'] ?? '');
$gender    = $_POST['gender'] ?? '';
$password  = $_POST['password'] ?? '';

if ($firstname === '' || $lastname === '' || $email === '' || $gender === '' || $password === '') {
    $error = 'Please fill in all required fields.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Please enter a valid email address.';
} elseif (!in_array($gender, ['male', 'female', 'other'], true)) {
    $error = 'Please select a valid gender.';
} elseif (strlen($password) < 6) {
    $error = 'Password must be at least 6 characters long.';
} else {
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare(
            "INSERT INTO users (fname, lname, email, password, gender) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $hashed_password, $gender);
        $stmt->execute();
        $stmt->close();

        header('Location: login.php?signup=success');
        exit();
    } catch (mysqli_sql_exception $e) {
        if ((int) $e->getCode() === 1062) {
            $error = 'That email address is already registered.';
        } else {
            $error = 'Signup failed. Please make sure the users table exists.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up Error &mdash; YearOne</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-body">
    <div class="card">
        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= htmlspecialchars($error) ?></div>
            <a href="signup.php">Go back and try again</a>
        <?php endif; ?>
    </div>
</body>
</html>
