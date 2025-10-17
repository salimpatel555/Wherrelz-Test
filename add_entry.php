<?php
session_start();
require "functions.php";

if(!isset($_COOKIE['user_id'])) header("location: login.php");

if(isset($_POST['save'])){
    $account = $_POST['account'];
    $narration = $_POST['narration'];
    $currency = $_POST['currency'];
    $credit = $_POST['credit'];
    $debit = $_POST['debit'];
    $stmt = $pdo->prepare("INSERT INTO entries (account,narration,currency,credit,debit) VALUES(?,?,?,?,?)");
    $stmt->execute([$account,$narration,$currency,$credit,$debit]);
    log_audit('entries','all','', json_encode($_POST),$_COOKIE['user_id']);
    header("Location: dashboard.php");
}

include "main.php";
?>

<link rel="stylesheet" href="assets/dashboard.css">

  <div class="entry-card">
    <h2><i class="bi bi-plus-circle me-2"></i>Add Entry</h2>

    <?php if (isset($success)): ?>
      <div class="alert alert-success text-center"><?= $success ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <input type="text" name="account" class="form-control" placeholder="Account" required>
      </div>

      <div class="mb-3">
        <input type="text" name="narration" class="form-control" placeholder="Narration">
      </div>

      <div class="mb-3">
        <input type="text" name="currency" class="form-control" placeholder="Currency" required>
      </div>

      <div class="mb-3">
        <input type="number" step="0.01" name="credit" class="form-control" placeholder="Credit">
      </div>

      <div class="mb-3">
        <input type="number" step="0.01" name="debit" class="form-control" placeholder="Debit">
      </div>

      <button type="submit" name="save" class="btn btn-save">
        <i class="bi bi-check-circle me-1"></i> Save Entry
      </button>
    </form>
  </div>

