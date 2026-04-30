<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'connection.php';
$sql = "SELECT id, fname, lname, email, gender FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users &mdash; YearOne</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Fraunces:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="records-body">
<main class="records-container">
    <h1>users</h1>

    <?php if (isset($_GET['updated'])): ?>
        <div class="alert-success">User updated successfully.</div>
    <?php endif; ?>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert-success">User deleted successfully.</div>
    <?php endif; ?>
    <div class="table-wrap records-table-wrap">
        <table class="data-table records-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['fname']) ?></td>
                            <td><?= htmlspecialchars($row['lname']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['gender']) ?></td>
                            <td class="action-cell">
                                <a href="update.php?id=<?= urlencode($row['id']) ?>" class="table-btn edit-link">Edit</a>
                                <a href="delete.php?id=<?= urlencode($row['id']) ?>" class="table-btn delete-link" data-delete-link>Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-cell">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<div class="modal-overlay" id="deleteModal" aria-hidden="true">
    <div class="delete-modal" role="dialog" aria-modal="true" aria-labelledby="deleteTitle">
        <h2 id="deleteTitle">Delete user?</h2>
        <p>This record will be removed from the users table.</p>
        <div class="modal-actions">
            <button type="button" class="modal-cancel" id="cancelDelete">Cancel</button>
            <a href="#" class="modal-delete" id="confirmDelete">Delete</a>
        </div>
    </div>
</div>
<script>
const deleteModal = document.getElementById('deleteModal');
const confirmDelete = document.getElementById('confirmDelete');
const cancelDelete = document.getElementById('cancelDelete');

document.querySelectorAll('[data-delete-link]').forEach((link) => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        confirmDelete.href = link.href;
        deleteModal.classList.add('is-open');
        deleteModal.setAttribute('aria-hidden', 'false');
    });
});
function closeDeleteModal() {
    deleteModal.classList.remove('is-open');
    deleteModal.setAttribute('aria-hidden', 'true');
    confirmDelete.href = '#';
}
cancelDelete.addEventListener('click', closeDeleteModal);
deleteModal.addEventListener('click', (event) => {
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
});
</script>
</body>
</html>
