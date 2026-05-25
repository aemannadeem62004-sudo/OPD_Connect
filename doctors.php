<?php
require_once 'config/db.php';
include 'includes/header.php';

// Filters
$dept_id = $_GET['dept_id'] ?? '';
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? ''; // available, on_leave

// Build Query
$query = "SELECT d.*, dept.dept_name FROM doctors d LEFT JOIN departments dept ON d.dept_id = dept.dept_id WHERE 1=1";
$params = [];

if ($dept_id) {
    $query .= " AND d.dept_id = :dept_id";
    $params[':dept_id'] = $dept_id;
}
if ($search) {
    $query .= " AND (d.doctor_name LIKE :search OR d.specialization LIKE :search)";
    $params[':search'] = "%$search%";
}
if ($status) {
    // Assuming status column exists from user SQL: status VARCHAR(50) DEFAULT 'available'
    $query .= " AND d.status = :status";
    $params[':status'] = $status;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$doctors = $stmt->fetchAll();

// Get Departments for Filter Dropdown
$depts = $pdo->query("SELECT * FROM departments")->fetchAll();
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">Find a Doctor</h2>
            <p class="text-muted">Search by name, specialty, or department.</p>
        </div>

        <!-- Filters -->
        <div class="col-12">
            <div class="card border-0 shadow-sm p-3 mb-4">
                <form action="" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search Doctor or Specialty"
                            value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="dept_id" class="form-select">
                            <option value="">All Departments</option>
                            <?php foreach ($depts as $d): ?>
                                <option value="<?php echo $d['dept_id']; ?>" <?php echo $dept_id == $d['dept_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($d['dept_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Any Status</option>
                            <option value="available" <?php echo $status == 'available' ? 'selected' : ''; ?>>Available
                                Today</option>
                            <option value="on_leave" <?php echo $status == 'on_leave' ? 'selected' : ''; ?>>On Leave
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                        <a href="doctors.php" class="btn btn-outline-secondary"><i class="fa-solid fa-refresh"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Doctors Grid -->
    <div class="row g-4">
        <?php if (count($doctors) > 0): ?>
            <?php foreach ($doctors as $doc): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0">
                                <img src="assets/images/doctor_placeholder.png" class="rounded-circle border" width="80"
                                    height="80" style="object-fit:cover;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($doc['doctor_name']); ?></h5>
                                <p class="text-primary small mb-1"><?php echo htmlspecialchars($doc['specialization']); ?></p>
                                <span
                                    class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 rounded-pill"><?php echo htmlspecialchars($doc['dept_name']); ?></span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <hr class="mt-2 mb-3 opacity-10">
                            <div class="row text-center mb-3">
                                <div class="col border-end">
                                    <small class="text-muted d-block text-uppercase"
                                        style="font-size: 0.7rem;">Experience</small>
                                    <span class="fw-bold small"><?php echo htmlspecialchars($doc['qualification']); ?></span>
                                </div>
                                <div class="col">
                                    <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem;">Status</small>
                                    <?php if ($doc['status'] == 'available'): ?>
                                        <span class="badge bg-success small">Available</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger small">On Leave</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Schedule Preview -->
                            <div class="bg-light p-2 rounded mb-3 small">
                                <i class="fa-regular fa-calendar me-1 text-muted"></i>
                                <?php echo htmlspecialchars($doc['opd_days']); ?> <br>
                                <i class="fa-regular fa-clock me-1 text-muted"></i>
                                <?php
                                echo date('h:i A', strtotime($doc['start_time'])) . ' - ' . date('h:i A', strtotime($doc['end_time']));
                                ?>
                            </div>

                            <div class="d-grid">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="user/book_appointment.php?doctor_id=<?php echo $doc['doctor_id']; ?>"
                                        class="btn btn-primary">Book Appointment</a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-outline-primary">Login to Book</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="text-muted fs-4">No doctors found.</div>
                <p>Try adjusting filters.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>