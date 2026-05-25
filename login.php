<?php
require_once 'config/db.php';
include 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Check session status before starting (header.php starts it too, but to be safe)
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['role'] = 'user';

            // Redirect to dashboard
            header("Location: user/dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white text-center py-4 border-0">
                    <h2 class="text-primary fw-bold mb-0"><i class="fa-solid fa-hospital-user"></i></h2>
                    <h4 class="fw-bold text-dark mt-2">Welcome Back</h4>
                    <p class="mb-0 text-muted small">Login to manage appointments</p>
                </div>
                <div class="card-body p-4">

                    <?php if ($error): ?>
                        <div class="alert alert-danger py-2 text-center small"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="fa-regular fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-start-0 ps-0"
                                    placeholder="name@example.com" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label small fw-bold text-uppercase text-muted">Password</label>
                                <a href="#" class="small text-decoration-none">Forgot?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-start-0 ps-0"
                                    placeholder="••••••••" required>
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-muted small mb-2">New to OPD Connect? <a href="register.php"
                                class="text-decoration-none fw-bold">Register Now</a></p>
                        <hr>
                        <a href="admin/login.php" class="text-secondary small text-decoration-none"><i
                                class="fa-solid fa-user-shield me-1"></i> Admin Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>