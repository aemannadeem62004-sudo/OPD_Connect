<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['update_status'])) {
    $doctor_id = $_POST['doctor_id'];
    $status = $_POST['status'];
    $pdo->prepare("UPDATE doctors SET status = ? WHERE doctor_id = ?")->execute([$status, $doctor_id]);
    header("Location: doctor_availability.php"); // Self reload
    exit;
}

$doctors = $pdo->query("SELECT * FROM doctors ORDER BY doctor_name ASC")->fetchAll();
?>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Doctor Availability Control</h2>
    <p class="text-muted mb-4">Quickly toggle doctor status between Available, On Leave, or Emergency.</p>

    <div class="row g-4">
        <?php foreach ($doctors as $doc): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($doc['doctor_name']); ?></h5>
                            <?php if ($doc['status'] == 'available'): ?>
                                <span class="badge bg-success rounded-pill">Available</span>
                            <?php else: ?>
                                <span class="badge bg-danger rounded-pill">On Leave</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-muted small mb-3"><?php echo htmlspecialchars($doc['specialization']); ?></p>

                        <form action="" method="POST">
                            <input type="hidden" name="doctor_id" value="<?php echo $doc['doctor_id']; ?>">
                            <div class="btn-group w-100" role="group">
                                <button type="submit" name="status" value="available"
                                    class="btn btn-sm btn-outline-success <?php echo $doc['status'] == 'available' ? 'active' : ''; ?>">Available</button>
                                <button type="submit" name="status" value="on_leave"
                                    class="btn btn-sm btn-outline-danger <?php echo $doc['status'] == 'on_leave' ? 'active' : ''; ?>">On
                                    Leave</button>
                            </div>
                            <input type="hidden" name="update_status" value="1">
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>