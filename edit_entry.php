<?php
require "functions.php";
if(!isset($_COOKIE['user_id'])) header("location: login.php");

$id = $_GET['id'];
$entry = get_entry($id);

if(isset($_POST['update'])){
    $account = $_POST['account'];
    $narration = $_POST['narration'];
    $currency = $_POST['currency'];
    $credit = $_POST['credit'];
    $debit = $_POST['debit'];

    foreach($_POST as $key => $value){
        if($entry[$key] != $value){
            log_audit('entries',$key,$entry[$key], $value,$_COOKIE['user_id']);
        }
    }
    $stmt = $pdo->prepare("UPDATE entries SET account=?,narration=?,currency=?,credit=?,debit=?");
    $stmt->execute([$account,$narration,$currency,$credit,$debit]);
    header("Location: dashboard.php");
}
include "main.php";

?>
<link rel="stylesheet" href="assets/dashboard.css">

<div class="entry-card">
    <h2><i class="bi bi-plus-circle me-2"></i>Edit Entry</h2>
    <?php if (isset($success)): ?>
      <div class="alert alert-success text-center"><?= $success ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="text" name="account" value="<?= $entry['account'] ?>" class="form-control mb-2" required>
        <input type="text" name="narration" value="<?= $entry['narration'] ?>" class="form-control mb-2">
        <input type="text" name="currency" value="<?= $entry['currency'] ?>" class="form-control mb-2" required>
        <input type="number" step="0.01" name="credit" value="<?= $entry['credit'] ?>" class="form-control mb-2">
        <input type="number" step="0.01" name="debit" value="<?= $entry['debit'] ?>" class="form-control mb-2">
        <button type="submit" name="update" class="btn btn-save">Update</button>
    </form>
</div>