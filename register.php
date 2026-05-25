<?php
require_once 'config/db.php';
include 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $cnic = trim($_POST['cnic']);
    $address = trim($_POST['address']);

    // Simplistic Validation
    if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($cnic)) {
        $error = "All fields except Address are required.";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (full_name, email, password, phone, cnic, address) VALUES (?, ?, ?, ?, ?, ?)";
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $email, $hashed_password, $phone, $cnic, $address]);
                $success = "Registration successful! You can now login.";
            } catch (PDOException $e) {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="fw-bold mb-0"><i class="fa-solid fa-user-plus me-2"></i> Create Account</h4>
                    <p class="mb-0 opacity-75 small">Join OPD Connect for seamless booking</p>
                </div>
                <div class="card-body p-4 p-md-5">

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?> <a href="login.php">Login here</a></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control bg-light" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control bg-light" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control bg-light" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control bg-light" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CNIC <span class="text-danger">*</span></label>
                                <input type="text" name="cnic" class="form-control bg-light" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control bg-light" rows="2"></textarea>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Register</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <p class="text-muted small">Already have an account? <a href="login.php"
                                class="text-decoration-none fw-bold">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>