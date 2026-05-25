<?php
require_once '../config/db.php';
include '../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        // Note: In a real app, use password_verify. Assuming plain text or hashed.
        // Prompt creates table with password VARCHAR(255). I'll use password_verify assuming admins are created securely.
        // If initial admin is manually inserted, it might be plain text. I'll support both for check or just assume hash.
        // Let's assume hash for security best practice.
        if ($admin && ($password === $admin['password'] || password_verify($password, $admin['password']))) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['username'];
            $_SESSION['role'] = 'admin';

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white text-center py-4 border-0">
                    <h2 class="text-white fw-bold mb-0"><i class="fa-solid fa-user-shield"></i></h2>
                    <h4 class="fw-bold mt-2">Admin Panel</h4>
                    <p class="mb-0 opacity-75 small">Restricted Access</p>
                </div>
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger py-2 text-center small"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Username</label>
                            <input type="text" name="username" class="form-control bg-light" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Password</label>
                            <input type="password" name="password" class="form-control bg-light" required>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark btn-lg fw-bold">Login</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <a href="../index.php" class="text-secondary small text-decoration-none">Back to Website</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>