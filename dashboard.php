<?php
session_start();
require "functions.php";

if (!isset($_COOKIE['user_id'])) header("Location: login.php");
$entries = get_entries();

$total_entries = $pdo->query("SELECT COUNT(*) FROM entries")->fetchColumn();
$total_credit = $pdo->query("SELECT SUM(credit) FROM entries")->fetchColumn();
$total_debit = $pdo->query("SELECT SUM(debit) FROM entries")->fetchColumn();

include "main.php";
?>

<link rel="stylesheet" href="assets/dashboard.css">


<!-- Main Content -->
<div class="main-content">
    <div class="top-header">
        <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card-summary card-credit text-center">
                <h5>Total Credit</h5>
                <h3>₹ <?= number_format($total_credit, 2) ?></h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card-summary card-debit text-center">
                <h5>Total Debit</h5>
                <h3>₹ <?= number_format($total_debit, 2) ?></h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card-summary card-balance text-center">
                <h5>Balance</h5>
                <h3>₹ <?= number_format($total_credit - $total_debit, 2) ?></h3>
            </div>
        </div>
    </div>

    <!-- Entries Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Account</th>
                    <th>Narration</th>
                    <th>Currency</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($entries as $e): ?>
                <tr>
                    <td><?= $e['id'] ?></td>
                    <td><?= $e['account'] ?></td>
                    <td><?= $e['narration'] ?></td>
                    <td><?= $e['currency'] ?></td>
                    <td>₹ <?= number_format($e['credit'], 2) ?></td>
                    <td>₹ <?= number_format($e['debit'], 2) ?></td>
                    <td class="action-btns">
                        <a href="edit_entry.php?id=<?= $e['id'] ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a href="delete_entry.php?id=<?= $e['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

