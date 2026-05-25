<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Counts
$users_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$doctors_count = $pdo->query("SELECT COUNT(*) FROM doctors")->fetchColumn();
$today_appts = $pdo->query("SELECT COUNT(*) FROM appointments WHERE appointment_date = CURRENT_DATE")->fetchColumn();
$avail_docs = $pdo->query("SELECT COUNT(*) FROM doctors WHERE status = 'available'")->fetchColumn();

// Alerts (Doctors on leave today) -> Logic: doctors with status='on_leave'
// Actually "on leave today" implies date check if leave system is complex, but prompt says simplistic "available/on leave" status column.
$leave_docs = $pdo->query("SELECT * FROM doctors WHERE status != 'available'")->fetchAll();

?>

<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold">Admin Dashboard</h2>
            <p class="text-muted">Overview of hospital operations</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="appointments.php" class="btn btn-primary"><i class="fa-solid fa-list-check me-2"></i>Manage
                Appointments</a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white">
                <div class="card-body p-4">
                    <h6 class="opacity-75">Total Users</h6>
                    <h2 class="fw-bold display-6"><?php echo $users_count; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <h6 class="text-muted">Total Doctors</h6>
                    <h2 class="fw-bold display-6 text-dark"><?php echo $doctors_count; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <h6 class="text-muted">Appointments Today</h6>
                    <h2 class="fw-bold display-6 text-dark"><?php echo $today_appts; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <h6 class="text-muted">Available Doctors</h6>
                    <h2 class="fw-bold display-6 text-success"><?php echo $avail_docs; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> Doctor
                        Alerts</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php if (count($leave_docs) > 0): ?>
                            <?php foreach ($leave_docs as $doc): ?>
                                <li class="list-group-item px-4 py-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold"><?php echo htmlspecialchars($doc['doctor_name']); ?></span>
                                        <span class="badge bg-danger">On Leave</span>
                                    </div>
                                    <small class="text-muted"><?php echo htmlspecialchars($doc['specialization']); ?></small>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item px-4 py-3 text-muted">No alerts. All doctors available.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-bolt me-2"></i> Quick Actions</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <a href="doctors.php?action=add" class="btn btn-outline-primary text-start"><i
                                class="fa-solid fa-plus me-2"></i> Add New Doctor</a>
                        <a href="departments.php" class="btn btn-outline-secondary text-start"><i
                                class="fa-solid fa-building me-2"></i> Manage Departments</a>
                        <a href="notifications.php" class="btn btn-outline-dark text-start"><i
                                class="fa-solid fa-bell me-2"></i> Send Notification</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>