<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Handle Status Change
if (isset($_GET['status']) && isset($_GET['id'])) {
    $status = $_GET['status'];
    $id = $_GET['id'];

    // Update
    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
    $stmt->execute([$status, $id]);

    // Notify User
    try {
        $appt = $pdo->query("SELECT user_id FROM appointments WHERE appointment_id = $id")->fetch();
        if ($appt) {
            $msg = "Your appointment #$id status has been updated to: $status";
            $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)")->execute([$appt['user_id'], $msg]);
        }
    } catch (Exception $e) {
    }

    header("Location: appointments.php");
    exit;
}

// Fetch Appointments
$sql = "SELECT a.*, u.full_name as user_name, d.doctor_name, dept.dept_name 
        FROM appointments a
        JOIN users u ON a.user_id = u.user_id
        JOIN doctors d ON a.doctor_id = d.doctor_id
        JOIN departments dept ON a.dept_id = dept.dept_id
        ORDER BY a.appointment_date DESC";
$appointments = $pdo->query($sql)->fetchAll();
?>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Manage Appointments</h2>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>User</th>
                        <th>Doctor</th>
                        <th>Date/Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appt): ?>
                        <tr>
                            <td class="ps-4">#<?php echo $appt['appointment_id']; ?></td>
                            <td>
                                <div class="fw-bold"><?php echo htmlspecialchars($appt['user_name']); ?></div>
                                <small class="text-muted">Token: <?php echo $appt['token_number']; ?></small>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($appt['doctor_name']); ?> <br>
                                <span
                                    class="badge bg-light text-secondary border"><?php echo htmlspecialchars($appt['dept_name']); ?></span>
                            </td>
                            <td>
                                <?php echo date('d M Y', strtotime($appt['appointment_date'])); ?> <br>
                                <?php echo date('h:i A', strtotime($appt['slot_time'])); ?>
                            </td>
                            <td>
                                <?php
                                $s = $appt['status'];
                                $cls = match ($s) { 'approved' => 'success', 'pending' => 'warning', 'cancelled' => 'danger', 'completed' => 'primary', default => 'secondary'};
                                ?>
                                <span class="badge bg-<?php echo $cls; ?>"><?php echo ucfirst($s); ?></span>
                            </td>
                            <td>
                                <?php if ($appt['status'] == 'pending'): ?>
                                    <a href="?id=<?php echo $appt['appointment_id']; ?>&status=approved"
                                        class="btn btn-sm btn-success" title="Approve"><i class="fa-solid fa-check"></i></a>
                                    <a href="?id=<?php echo $appt['appointment_id']; ?>&status=cancelled"
                                        class="btn btn-sm btn-danger" title="Reject"><i class="fa-solid fa-xmark"></i></a>
                                <?php elseif ($appt['status'] == 'approved'): ?>
                                    <a href="?id=<?php echo $appt['appointment_id']; ?>&status=completed"
                                        class="btn btn-sm btn-primary" title="Mark Complete"><i
                                            class="fa-solid fa-clipboard-check"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>