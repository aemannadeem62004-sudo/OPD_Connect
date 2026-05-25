<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $cnic = $_POST['cnic'];
    $address = $_POST['address'];

    $sql = "UPDATE users SET full_name=?, phone=?, cnic=?, address=? WHERE user_id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$name, $phone, $cnic, $address, $user_id])) {
        $msg = "<div class='alert alert-success'>Profile Updated!</div>";
        $_SESSION['user_name'] = $name; // Update session name
    } else {
        $msg = "<div class='alert alert-danger'>Update Failed.</div>";
    }
}

// Fetch current data
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-white py-4 border-0">
                    <h4 class="fw-bold mb-0 text-center">Profile Settings</h4>
                </div>
                <div class="card-body p-4 p-md-5">
                    <?php echo $msg; ?>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email (Cannot be changed)</label>
                            <input type="email" class="form-control"
                                value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control bg-light"
                                value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control bg-light"
                                    value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CNIC</label>
                                <input type="text" name="cnic" class="form-control bg-light"
                                    value="<?php echo htmlspecialchars($user['cnic']); ?>" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control bg-light"
                                rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>