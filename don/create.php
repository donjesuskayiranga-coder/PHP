<?php
session_start();

include 'connection.php';
if (isset($_POST['submit'])) {
    $firstname= trim($_POST['firstname']);
    $lastname= trim($_POST['lastname']);
    $email= trim($_POST['email']);
    $gender= $_POST['gender'];
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO users (fname, lname, email, password, gender) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $hashed_password, $gender);
    if ($stmt->execute()) {
        header('Location: login.php?signup=success');
        exit();
    } else {
        $error = "Signup failed: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up Error — YearOne</title>
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