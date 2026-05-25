<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target = $_POST['target']; // all, user, doctor_users
    $message = $_POST['message'];

    if ($target == 'all') {
        // Send to all users
        $users = $pdo->query("SELECT user_id FROM users")->fetchAll();
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        foreach ($users as $u) {
            $stmt->execute([$u['user_id'], $message]);
        }
        $msg = "<div class='alert alert-success'>Sent to all users!</div>";
    } elseif ($target == 'single') {
        $uid = $_POST['user_id'];
        $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)")->execute([$uid, $message]);
        $msg = "<div class='alert alert-success'>Sent to user #$uid!</div>";
    }
    // Implement others if needed (Users of specific doctor requires join)
    // For simplicity, sticking to All or Single
}

$users = $pdo->query("SELECT user_id, full_name, email FROM users")->fetchAll();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-bell me-2"></i> Send Notification</h5>
                </div>
                <div class="card-body p-4">
                    <?php echo $msg; ?>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Target Audience</label>
                            <select name="target" class="form-select" id="targetSelect" onchange="toggleUserSelect()">
                                <option value="all">All Users</option>
                                <option value="single">Single User</option>
                            </select>
                        </div>

                        <div class="mb-3 d-none" id="userSelectDiv">
                            <label class="form-label">Select User</label>
                            <select name="user_id" class="form-select">
                                <?php foreach ($users as $u): ?>
                                    <option value="<?php echo $u['user_id']; ?>">
                                        <?php echo htmlspecialchars($u['full_name']); ?> (<?php echo $u['email']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="4" required
                                placeholder="Type your message here..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg">Send Notification</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleUserSelect() {
        var val = document.getElementById('targetSelect').value;
        if (val == 'single') {
            document.getElementById('userSelectDiv').classList.remove('d-none');
        } else {
            document.getElementById('userSelectDiv').classList.add('d-none');
        }
    }
</script>

<?php include '../includes/footer.php'; ?>