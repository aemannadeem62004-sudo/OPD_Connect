<?php
require_once '../config/db.php';
include '../includes/header.php';

// Check auth
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$departments = $pdo->query("SELECT * FROM departments")->fetchAll();

$dept_id = $_GET['dept_id'] ?? '';
$doctor_id = $_GET['doctor_id'] ?? '';
$date = $_GET['date'] ?? '';

$doctors = [];
if ($dept_id) {
    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE dept_id = ?");
    $stmt->execute([$dept_id]);
    $doctors = $stmt->fetchAll();
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $d_id = $_POST['dept_id'];
    $doc_id = $_POST['doctor_id'];
    $appt_date = $_POST['date'];
    $time = $_POST['time'] ?? '09:00'; // Default or selected

    // Generate Token Number (Simple max + 1 logic for today or random)
    // Functional requirement: "User receives a token number automatically"
    // Let's count appointments for this doctor on this date + 1
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = ? AND appointment_date = ?");
    $stmt->execute([$doc_id, $appt_date]);
    $count = $stmt->fetchColumn();
    $token = $count + 1;

    $sql = "INSERT INTO appointments (user_id, doctor_id, dept_id, appointment_date, slot_time, token_number, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$user_id, $doc_id, $d_id, $appt_date, $time, $token])) {
        echo "<script>alert('Appointment Booked Successfully! Your Token Number is $token'); window.location='dashboard.php';</script>";
        exit;
    } else {
        $msg = "<div class='alert alert-danger'>Booking Failed.</div>";
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-4">
                    <h4 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-check me-2"></i> Book Appointment</h4>
                </div>
                <div class="card-body p-5">

                    <?php echo $msg; ?>

                    <form action="" method="POST">

                        <!-- Step 1 -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">1. Select Department</label>
                            <select name="dept_id" class="form-select bg-light py-3"
                                onchange="window.location.href='?dept_id='+this.value" required>
                                <option value="">Choose Department...</option>
                                <?php foreach ($departments as $d): ?>
                                    <option value="<?php echo $d['dept_id']; ?>" <?php echo $dept_id == $d['dept_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($d['dept_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Step 2 -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">2. Select Doctor</label>
                            <select name="doctor_id" class="form-select bg-light py-3" required <?php echo empty($doctors) ? 'disabled' : ''; ?>>
                                <option value="">Choose Doctor...</option>
                                <?php foreach ($doctors as $doc): ?>
                                    <option value="<?php echo $doc['doctor_id']; ?>" <?php echo $doctor_id == $doc['doctor_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($doc['doctor_name']); ?>
                                        (<?php echo $doc['start_time'] . '-' . $doc['end_time']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Step 3 -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">3. Select Date</label>
                            <input type="date" name="date" class="form-control bg-light py-3"
                                min="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <!-- Step 4 -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">4. Preferred Time (Optional)</label>
                            <input type="time" name="time" class="form-control bg-light py-3">
                            <div class="form-text text-muted">We will try to accommodate your preferred time, but tokens
                                are issued sequentially.</div>
                        </div>

                        <div class="d-grid pt-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Confirm Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>