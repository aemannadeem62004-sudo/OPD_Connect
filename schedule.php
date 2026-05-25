<?php
require_once 'config/db.php';
include 'includes/header.php';

// Filters
$dept_id = $_GET['dept_id'] ?? '';
$doctor_id = $_GET['doctor_id'] ?? '';

// Build Query
$query = "SELECT d.*, dept.dept_name FROM doctors d 
          LEFT JOIN departments dept ON d.dept_id = dept.dept_id 
          WHERE 1=1";
$params = [];

if ($dept_id) {
    $query .= " AND d.dept_id = :dept_id";
    $params[':dept_id'] = $dept_id;
}
if ($doctor_id) {
    $query .= " AND d.doctor_id = :doctor_id";
    $params[':doctor_id'] = $doctor_id;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$schedules = $stmt->fetchAll();

// Get Departments for Dropdown
$depts = $pdo->query("SELECT * FROM departments")->fetchAll();
// Get Doctors for Dropdown
$all_docs = $pdo->query("SELECT * FROM doctors")->fetchAll();
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">OPD Schedule</h2>
        <p class="text-muted">Check availability and timing for all departments.</p>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm p-4 mb-5">
        <form action="" method="GET" class="row g-3">
            <div class="col-md-5">
                <label class="form-label fw-bold">Department</label>
                <select name="dept_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Departments</option>
                    <?php foreach ($depts as $d): ?>
                        <option value="<?php echo $d['dept_id']; ?>" <?php echo $dept_id == $d['dept_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($d['dept_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label fw-bold">Doctor</label>
                <select name="doctor_id" class="form-select">
                    <option value="">All Doctors</option>
                    <?php foreach ($all_docs as $doc): ?>
                        <option value="<?php echo $doc['doctor_id']; ?>" <?php echo $doctor_id == $doc['doctor_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($doc['doctor_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Check</button>
            </div>
        </form>
    </div>

    <!-- Schedule Table -->
    <div class="table-responsive bg-white shadow-sm rounded-4 p-3">
        <table class="table table-hover align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3">Doctor Name</th>
                    <th class="py-3">Department</th>
                    <th class="py-3">Available Days</th>
                    <th class="py-3">Timings</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($schedules) > 0): ?>
                    <?php foreach ($schedules as $row): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold me-3"
                                        style="width: 40px; height: 40px;">
                                        <?php echo strtoupper(substr($row['doctor_name'], 0, 1)); ?>
                                    </div>
                                    <span class="fw-bold"><?php echo htmlspecialchars($row['doctor_name']); ?></span>
                                </div>
                            </td>
                            <td><span
                                    class="badge bg-info bg-opacity-10 text-info"><?php echo htmlspecialchars($row['dept_name']); ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($row['opd_days']); ?></td>
                            <td>
                                <i class="fa-regular fa-clock text-muted me-1"></i>
                                <?php echo date('h:i A', strtotime($row['start_time'])) . ' - ' . date('h:i A', strtotime($row['end_time'])); ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'available'): ?>
                                    <span class="badge bg-success rounded-pill px-3">Available</span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill px-3">On Leave</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'available'): ?>
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <a href="user/book_appointment.php?doctor_id=<?php echo $row['doctor_id']; ?>"
                                            class="btn btn-sm btn-primary">Book</a>
                                    <?php else: ?>
                                        <a href="login.php" class="btn btn-sm btn-outline-primary">Login</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary" disabled>Unavailable</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No schedules found matching your criteria.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>