<?php
require_once '../config/db.php';
include '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch User Info
$user_stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$user_stmt->execute([$user_id]);
$user = $user_stmt->fetch();

// Fetch Upcoming Appointments
$appt_stmt = $pdo->prepare("SELECT a.*, d.doctor_name, dept.dept_name 
                            FROM appointments a
                            JOIN doctors d ON a.doctor_id = d.doctor_id
                            JOIN departments dept ON a.dept_id = dept.dept_id
                            WHERE a.user_id = ? AND a.appointment_date >= CURDATE()
                            ORDER BY a.appointment_date ASC");
$appt_stmt->execute([$user_id]);
$appointments = $appt_stmt->fetchAll();
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h2>
            <p class="text-muted">Manage your health and appointments here.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="book_appointment.php" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>New
                Appointment</a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase opacity-75">Upcoming</h6>
                            <h2 class="fw-bold display-6 mb-0"><?php echo count($appointments); ?></h2>
                        </div>
                        <i class="fa-solid fa-calendar-days fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted">Total Visits</h6>
                            <h2 class="fw-bold display-6 mb-0 text-dark">
                                <?php
                                $hist_stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE user_id = ?");
                                $hist_stmt->execute([$user_id]);
                                echo $hist_stmt->fetchColumn();
                                ?>
                            </h2>
                        </div>
                        <i class="fa-solid fa-clipboard-list fs-1 text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted">Reports</h6>
                            <h2 class="fw-bold display-6 mb-0 text-dark">0</h2>
                        </div>
                        <i class="fa-solid fa-file-medical fs-1 text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Upcoming Appointments</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Token #</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($appointments) > 0): ?>
                            <?php foreach ($appointments as $appt): ?>
                                <tr>
                                    <td class="ps-4"><span
                                            class="badge bg-dark rounded-pill">#<?php echo $appt['token_number']; ?></span></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($appt['doctor_name']); ?></td>
                                    <td><span
                                            class="badge bg-secondary bg-opacity-10 text-secondary"><?php echo htmlspecialchars($appt['dept_name']); ?></span>
                                    </td>
                                    <td>
                                        <div><i class="fa-regular fa-calendar me-1 text-muted"></i>
                                            <?php echo date('M d, Y', strtotime($appt['appointment_date'])); ?></div>
                                        <div class="small text-muted"><i class="fa-regular fa-clock me-1"></i>
                                            <?php echo date('h:i A', strtotime($appt['slot_time'])); ?></div>
                                    </td>
                                    <td>
                                        <?php if ($appt['status'] == 'pending'): ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php elseif ($appt['status'] == 'approved'): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php elseif ($appt['status'] == 'cancelled'): ?>
                                            <span class="badge bg-danger">Cancelled</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?php echo htmlspecialchars($appt['status']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($appt['status'] == 'pending' || $appt['status'] == 'approved'): ?>
                                            <a href="cancel_appointment.php?id=<?php echo $appt['appointment_id']; ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure?')">Cancel</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">You have no upcoming appointments.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>