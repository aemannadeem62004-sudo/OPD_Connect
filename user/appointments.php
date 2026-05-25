<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT a.*, d.doctor_name, dept.dept_name 
                       FROM appointments a
                       LEFT JOIN doctors d ON a.doctor_id = d.doctor_id
                       LEFT JOIN departments dept ON a.dept_id = dept.dept_id
                       WHERE a.user_id = ? 
                       ORDER BY a.appointment_date DESC");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll();
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">My Appointments</h2>
        <a href="book_appointment.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Book New</a>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Appt ID</th>
                        <th>Token</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $row): ?>
                        <tr>
                            <td class="ps-4">#<?php echo $row['appointment_id']; ?></td>
                            <td><span class="badge bg-dark rounded-pill">Token <?php echo $row['token_number']; ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['dept_name']); ?></td>
                            <td>
                                <?php echo date('d M, Y', strtotime($row['appointment_date'])); ?> <br>
                                <small class="text-muted"><?php echo date('h:i A', strtotime($row['slot_time'])); ?></small>
                            </td>
                            <td>
                                <?php
                                $status_class = match ($row['status']) {
                                    'approved' => 'bg-success',
                                    'pending' => 'bg-warning text-dark',
                                    'cancelled' => 'bg-danger',
                                    'completed' => 'bg-primary',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span
                                    class="badge <?php echo $status_class; ?>"><?php echo ucfirst($row['status']); ?></span>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'pending' || $row['status'] == 'approved'): ?>
                                    <a href="cancel_appointment.php?id=<?php echo $row['appointment_id']; ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Cancel this appointment?')">Cancel</a>
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