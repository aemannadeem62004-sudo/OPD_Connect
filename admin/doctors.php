<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$departments = $pdo->query("SELECT * FROM departments")->fetchAll();
$msg = '';
$edit_mode = false;
$doctor_data = [];

// Handle Actions
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM doctors WHERE doctor_id = ?")->execute([$_GET['delete']]);
    header("Location: doctors.php");
    exit;
}

if (isset($_POST['save_doctor'])) {
    // Collect Data
    $name = $_POST['doctor_name'];
    $spec = $_POST['specialization'];
    $qual = $_POST['qualification'];
    $dept = $_POST['dept_id'];
    $days = $_POST['opd_days'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $status = $_POST['status'];

    // Validate Time
    if (empty($name) || empty($dept)) {
        $msg = "<div class='alert alert-danger'>Name and Department are required.</div>";
    } else {
        if (isset($_POST['doctor_id']) && !empty($_POST['doctor_id'])) {
            // Update
            $sql = "UPDATE doctors SET doctor_name=?, specialization=?, qualification=?, dept_id=?, opd_days=?, start_time=?, end_time=?, status=? WHERE doctor_id=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$name, $spec, $qual, $dept, $days, $start, $end, $status, $_POST['doctor_id']])) {
                $msg = "<div class='alert alert-success'>Doctor Updated!</div>";
            }
        } else {
            // Insert
            $sql = "INSERT INTO doctors (doctor_name, specialization, qualification, dept_id, opd_days, start_time, end_time, status) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$name, $spec, $qual, $dept, $days, $start, $end, $status])) {
                $msg = "<div class='alert alert-success'>Doctor Added!</div>";
            }
        }
    }
}

if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
    $stmt->execute([$_GET['edit']]);
    $doctor_data = $stmt->fetch();
    $edit_mode = true;
}

// Fetch All Doctors
$doctors = $pdo->query("SELECT d.*, dept.dept_name FROM doctors d LEFT JOIN departments dept ON d.dept_id = dept.dept_id")->fetchAll();
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manage Doctors</h2>
        <?php if ($edit_mode): ?>
            <a href="doctors.php" class="btn btn-secondary">Cancel Edit</a>
        <?php else: ?>
            <button class="btn btn-primary"
                onclick="document.getElementById('doctorForm').scrollIntoView({behavior: 'smooth'});"><i
                    class="fa-solid fa-plus me-2"></i> Add Doctor</button>
        <?php endif; ?>
    </div>

    <?php echo $msg; ?>

    <!-- Doctors List -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Name</th>
                        <th>Specialization</th>
                        <th>Department</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doctors as $doc): ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?php echo htmlspecialchars($doc['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($doc['specialization']); ?></td>
                            <td><span
                                    class="badge bg-secondary bg-opacity-10 text-secondary"><?php echo htmlspecialchars($doc['dept_name']); ?></span>
                            </td>
                            <td class="small">
                                <?php echo htmlspecialchars($doc['opd_days']); ?> <br>
                                <?php echo date('h:i A', strtotime($doc['start_time'])) . ' - ' . date('h:i A', strtotime($doc['end_time'])); ?>
                            </td>
                            <td>
                                <?php if ($doc['status'] == 'available'): ?>
                                    <span class="badge bg-success">Available</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">On Leave</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?edit=<?php echo $doc['doctor_id']; ?>" class="btn btn-sm btn-outline-primary"><i
                                        class="fa-solid fa-pen"></i></a>
                                <a href="?delete=<?php echo $doc['doctor_id']; ?>" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete this doctor?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Form -->
    <div class="card border-0 shadow-lg rounded-4" id="doctorForm">
        <div class="card-header bg-white py-4 border-0">
            <h4 class="fw-bold mb-0"><?php echo $edit_mode ? 'Edit Doctor' : 'Add New Doctor'; ?></h4>
        </div>
        <div class="card-body p-4">
            <form action="doctors.php" method="POST">
                <?php if ($edit_mode): ?>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor_data['doctor_id']; ?>">
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Doctor Name</label>
                        <input type="text" name="doctor_name" class="form-control"
                            value="<?php echo $edit_mode ? $doctor_data['doctor_name'] : ''; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control"
                            value="<?php echo $edit_mode ? $doctor_data['specialization'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Qualification</label>
                        <input type="text" name="qualification" class="form-control"
                            value="<?php echo $edit_mode ? $doctor_data['qualification'] : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Department</label>
                        <select name="dept_id" class="form-select" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departments as $d): ?>
                                <option value="<?php echo $d['dept_id']; ?>" <?php echo ($edit_mode && $doctor_data['dept_id'] == $d['dept_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($d['dept_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">OPD Days</label>
                        <input type="text" name="opd_days" class="form-control" placeholder="e.g. Mon, Wed, Fri"
                            value="<?php echo $edit_mode ? $doctor_data['opd_days'] : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="start_time" class="form-control"
                            value="<?php echo $edit_mode ? $doctor_data['start_time'] : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" class="form-control"
                            value="<?php echo $edit_mode ? $doctor_data['end_time'] : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="available" <?php echo ($edit_mode && $doctor_data['status'] == 'available') ? 'selected' : ''; ?>>Available</option>
                            <option value="on_leave" <?php echo ($edit_mode && $doctor_data['status'] != 'available') ? 'selected' : ''; ?>>On Leave</option>
                        </select>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" name="save_doctor"
                            class="btn btn-primary btn-lg"><?php echo $edit_mode ? 'Update Doctor' : 'Add Doctor'; ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>