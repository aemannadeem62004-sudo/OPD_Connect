<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Verify ownership
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE appointment_id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);

    if ($stmt->fetch()) {
        // Cancel
        $update = $pdo->prepare("UPDATE appointments SET status = 'cancelled' WHERE appointment_id = ?");
        $update->execute([$id]);

        // Notify (if table exists)
        try {
            $n_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
            $pdo->prepare($n_sql)->execute([$user_id, "You cancelled appointment #$id."]);
        } catch (Exception $e) {
        }

        header("Location: appointments.php");
    } else {
        echo "Invalid Request";
    }
} else {
    header("Location: dashboard.php");
}
?>