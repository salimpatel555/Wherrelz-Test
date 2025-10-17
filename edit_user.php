<?php
require "functions.php";
if(!isset($_COOKIE['user_id'])) header("location: login.php");

$id = $_GET['id'];
$user = get_user($id);

if(isset($_POST['update'])){
    $login_id = $_POST['login_id'];
    $password = $_POST['password'];

    // Check if login_id already exists for another user
    $stmt = $pdo->prepare("SELECT id FROM users WHERE login_id = ? AND id != ?");
    $stmt->execute([$login_id, $id]);
    if($stmt->rowCount() > 0){
        $error = "Login ID already exists!";
    } else {
        // Hash password before saving
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE users SET login_id=?, password=? WHERE id=?");
        $stmt->execute([$login_id, $hashedPassword, $id]);
        $success = "User updated successfully!";
        header("Location: user_list.php");
        exit;
    }
}

include "main.php";
?>
<link rel="stylesheet" href="assets/dashboard.css">

<div class="entry-card">
    <h2><i class="bi bi-update me-2"></i>Edit User</h2>

    <?php if (isset($success)): ?>
      <div class="alert alert-success text-center"><?= $success ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="text" name="login_id" value="<?= htmlspecialchars($user['login_id']) ?>" class="form-control mb-2" required>
        <input type="password" name="password" value="" placeholder="Enter new password" class="form-control mb-2">
        <button type="submit" name="update" class="btn btn-save">Update</button>
    </form>
</div>
