<?php
session_start();
if(isset($_COOKIE['user_id'])) header("location: dashboard.php");
require 'config.php';

if(isset($_POST['login'])){
    $login_id = $_POST['login_id'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login_id = ?");
    $stmt->execute([$login_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user && password_verify($password, $user['password'])){
        setcookie('user_id', $user['id'], time() + 3600, "/");
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid Login ID or Password";
    }
}
?>

<!-- HTML -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="assets/auth.css">
  <div class="login-card">
    <h2>Sign In</h2>

    <?php if(isset($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <input type="text" name="login_id" class="form-control" value="<?php echo isset($login_id) ? htmlspecialchars($login_id) : ''; ?>" placeholder="Login ID" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" name="login" class="btn btn-login">Login</button>
    </form>
    <div class="text-center mt-3">
        <small>Don't have an account? 
            <a href="register.php" class="text-decoration-none fw-semibold">Click here</a>
        </small>
    </div>

  </div>

