<?php
require 'functions.php';
if (!isset($_COOKIE['user_id'])) header("Location: login.php");

// Fetch all audit logs
$stmt = $pdo->query("
    SELECT u.login_id,u.id
    FROM users u 
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "main.php";
?>
<link rel="stylesheet" href="assets/dashboard.css">
<!-- Main Content -->
<div class="main-content">
    <div class="top-header mb-3">
        <h2><i class="bi bi-list me-2"></i>User List</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Login Id</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="text-center"><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['login_id']) ?></td>
                            <td class="action-btns">
                                <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</a>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No audit logs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

