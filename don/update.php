<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'connection.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$error = '';

if (!$id) {
    header('Location: read.php');
    exit();
}

if (isset($_POST['submit'])) {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname  = trim($_POST['lastname'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $gender    = $_POST['gender'] ?? '';

    if ($firstname === '' || $lastname === '' || $email === '' || $gender === '') {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!in_array($gender, ['male', 'female', 'other'], true)) {
        $error = 'Please select a valid gender.';
    } else {
        try {
            $stmt = $conn->prepare(
                "UPDATE users SET fname = ?, lname = ?, email = ?, gender = ? WHERE id = ?"
            );
            $stmt->bind_param("ssssi", $firstname, $lastname, $email, $gender, $id);
            $stmt->execute();
            $stmt->close();

            header('Location: read.php?updated=1');
            exit();
        } catch (mysqli_sql_exception $e) {
            if ((int) $e->getCode() === 1062) {
                $error = 'That email address is already used by another user.';
            } else {
                $error = 'Update failed. Please try again.';
            }
        }
    }
}

$stmt = $conn->prepare("SELECT fname, lname, email, gender FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    header('Location: read.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User &mdash; YearOne</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Fraunces:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-body">

<div class="card">
    <div class="brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
        </div>
        <span class="brand-name">YearOne</span>
    </div>

    <h1>Edit user</h1>
    <p class="subtitle">Update an existing record.</p>

    <?php if (!empty($error)): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="update.php?id=<?= urlencode($id) ?>">
        <div class="row">
            <div class="field">
                <label for="firstname">First name</label>
                <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($user['fname']) ?>" required>
            </div>
            <div class="field">
                <label for="lastname">Last name</label>
                <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($user['lname']) ?>" required>
            </div>
        </div>

        <div class="field">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="field">
            <label for="gender">Gender</label>
            <div class="select-wrapper">
                <select id="gender" name="gender" required>
                    <option value="">Select gender</option>
                    <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                    <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
        </div>

        <button type="submit" class="submit-btn" name="submit">Save changes</button>
    </form>
    <p class="bottom-link"><a href="read.php">Back to users</a></p>
</div>

</body>
</html>
