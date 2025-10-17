<?php
session_start();
if(isset($_COOKIE['user_id'])) header("location: dashboard.php");

require "config.php";
if (isset($_POST['register'])) {
    $login_id = trim($_POST['login_id']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    if ($password !== $cpassword) {
        $error = "Password and Confirm Password do not match!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE login_id = ?");
        $checkStmt->execute([$login_id]);
        if ($checkStmt->rowCount() > 0) {
            $error = "Login ID already exists. Please choose another.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (login_id, password) VALUES (?, ?)");
            $stmt->execute([$login_id, $hashedPassword]);
            header("Location: login.php");
            exit;
        }
    }
}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="assets/auth.css">
  <div class="login-card">
    <h2>Sign Up</h2>

    <?php if(isset($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <input type="text" name="login_id" class="form-control" value="<?php echo isset($login_id) ? htmlspecialchars($login_id) : ''; ?>" placeholder="Login ID" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" placeholder="Password" required>
      </div>
      <div class="mb-3">
        <input type="password" name="cpassword" class="form-control" placeholder="Conform Password" required>
      </div>
      <button type="submit" name="register" class="btn btn-login">Register</button>
    </form>
    
    <div class="text-center mt-3">
        <small>Already have an account? 
            <a href="login.php" class="text-decoration-none fw-semibold">Click here</a>
        </small>
    </div>

  </div>