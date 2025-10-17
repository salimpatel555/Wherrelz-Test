<?php
require "functions.php";
if(!isset($_COOKIE['user_id'])) header("location: login.php");

$id = $_GET['id'];

$user = get_user($id);
if($user){
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: user_list.php");
exit;
?>


?>