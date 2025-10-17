<?php
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, "/"); // set to past time
    unset($_COOKIE['user_id']);
}
header("Location: login.php");
exit;
?>