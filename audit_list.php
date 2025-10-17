<?php
require 'functions.php';
if (!isset($_COOKIE['user_id'])) header("Location: login.php");

// Fetch all audit logs
$stmt = $pdo->query("
    SELECT a.*, u.login_id 
    FROM audit a 
    LEFT JOIN users u ON a.action_by = u.id 
    ORDER BY a.action_time DESC
");
$audit_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "main.php";
?>
<link rel="stylesheet" href="assets/dashboard.css">
<!-- Main Content -->
<div class="main-content">
    <div class="top-header mb-3">
        <h2><i class="bi bi-list me-2"></i>Audit Log</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Table</th>
                    <th>Field</th>
                    <th>Old Value</th>
                    <th>New Value</th>
                    <th>Action By</th>
                    <th>Action Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($audit_logs) > 0): ?>
                    <?php foreach ($audit_logs as $log): ?>
                        <tr>
                            <td class="text-center"><?= $log['id'] ?></td>
                            <td><?= htmlspecialchars($log['table_name']) ?></td>
                            <td><?= htmlspecialchars($log['field_name']) ?></td>

                            <!-- Old Value as List -->
                            <td>
                                <?php
                                $oldValue = json_decode($log['old_value'], true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($oldValue)) {
                                    echo '<ul class="list-group list-group-flush">';
                                    foreach ($oldValue as $key => $value) {
                                        echo '<li class="list-group-item"><strong>' . htmlspecialchars(ucfirst($key)) . ':</strong> ' . htmlspecialchars($value) . '</li>';
                                    }
                                    echo '</ul>';
                                } else {
                                    echo '<span class="badge bg-secondary">' . htmlspecialchars($log['old_value']) . '</span>';
                                }
                                ?>
                            </td>

                            <!-- New Value as List -->
                            <td>
                                <?php
                                $newValue = json_decode($log['new_value'], true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($newValue)) {
                                    echo '<ul class="list-group list-group-flush">';
                                    foreach ($newValue as $key => $value) {
                                        echo '<li class="list-group-item"><strong>' . htmlspecialchars(ucfirst($key)) . ':</strong> ' . htmlspecialchars($value) . '</li>';
                                    }
                                    echo '</ul>';
                                } else {
                                    echo '<span class="badge bg-success">' . htmlspecialchars($log['new_value']) . '</span>';
                                }
                                ?>
                            </td>

                            <td class="text-center"><span class="badge bg-primary"><?= htmlspecialchars($log['login_id']) ?></span></td>
                            <td class="text-center"><?= date('d-M-Y H:i:s', strtotime($log['action_time'])) ?></td>
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

