<?php
require_once '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$msg = '';

// Add Department Logic
if (isset($_POST['add_dept'])) {
    $name = $_POST['dept_name'];
    $desc = $_POST['description'];

    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO departments (dept_name, description) VALUES (?, ?)");
        if ($stmt->execute([$name, $desc])) {
            $msg = "<div class='alert alert-success'>Department Added!</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Failed to add department.</div>";
        }
    }
}

// Delete Logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM departments WHERE dept_id = ?")->execute([$id]);
    header("Location: departments.php");
    exit;
}

$departments = $pdo->query("SELECT * FROM departments")->fetchAll();
?>

<div class="container py-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Manage Departments</h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDeptModal"><i
                    class="fa-solid fa-plus me-2"></i> Add Department</button>
        </div>
    </div>

    <?php echo $msg; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Department Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($departments as $d): ?>
                        <tr>
                            <td class="ps-4"><?php echo $d['dept_id']; ?></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($d['dept_name']); ?></td>
                            <td><?php echo htmlspecialchars($d['description']); ?></td>
                            <td>
                                <a href="?delete=<?php echo $d['dept_id']; ?>" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete this department?')"><i
                                        class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addDeptModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="dept_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_dept" class="btn btn-primary">Add Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>