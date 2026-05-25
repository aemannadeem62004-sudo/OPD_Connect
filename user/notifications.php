<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Create table if not exists (Lazy fix for persistence)
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS notifications (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        user_id INT, 
        message TEXT, 
        is_read TINYINT DEFAULT 0, 
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (Exception $e) { /* Ignore */
}

// Mark all as read
$pdo->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?")->execute([$user_id]);

// Fetch
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$notifs = $stmt->fetchAll();
?>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Notifications</h2>

    <div class="list-group shadow-sm rounded-4 overflow-hidden">
        <?php if (count($notifs) > 0): ?>
            <?php foreach ($notifs as $n): ?>
                <div
                    class="list-group-item p-4 border-start border-4 <?php echo $n['is_read'] ? 'border-secondary' : 'border-primary'; ?>">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1 <?php echo $n['is_read'] ? 'text-muted' : 'text-primary fw-bold'; ?>">System
                            Notification</h5>
                        <small class="text-muted"><?php echo date('M d, h:i A', strtotime($n['created_at'])); ?></small>
                    </div>
                    <p class="mb-1"><?php echo htmlspecialchars($n['message']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="list-group-item p-5 text-center text-muted">No notifications yet.</div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>