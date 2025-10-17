<?php
session_start();
require "functions.php";
if(!isset($_COOKIE['user_id'])) header("location: login.php");

$id = $_GET['id'];
$entry = get_entry($id);
$stmt = $pdo->prepare("UPDATE entries SET is_deleted = 1 WHERE id =?");
$stmt->execute([$id]);
log_audit('entries', 'is_deleted', 0, 1, $_COOKIE['user_id']);
header("Location: dashboard.php");

?>