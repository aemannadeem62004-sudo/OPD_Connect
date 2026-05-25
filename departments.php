<?php
require_once 'config/db.php';
include 'includes/header.php';

// Search/Filter logic
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM departments";
if ($search) {
    $sql .= " WHERE dept_name LIKE :search OR description LIKE :search";
}
$stmt = $pdo->prepare($sql);
if ($search) {
    $stmt->bindValue(':search', "%$search%");
}
$stmt->execute();
$departments = $stmt->fetchAll();
?>

<div class="container py-5">
    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold">Our Departments</h2>
            <p class="text-muted">Explore our specialized medical departments.</p>
        </div>
        <div class="col-md-6">
            <form action="" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search departments..."
                    value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php if (count($departments) > 0): ?>
            <?php foreach ($departments as $dept): ?>
                <div class="col-md-4 col-sm-6">
                    <a href="doctors.php?dept_id=<?php echo $dept['dept_id']; ?>" class="text-decoration-none text-dark">
                        <div class="card h-100 border-0 shadow-hover transition-all p-3">
                            <div class="card-body text-center">
                                <div class="mb-3 d-inline-block p-3 rounded-circle bg-primary bg-opacity-10 text-primary">
                                    <i class="fa-solid fa-heart-pulse fs-2"></i>
                                    <!-- Dynamic icons would require an icon column in DB -->
                                </div>
                                <h4 class="card-title fw-bold"><?php echo htmlspecialchars($dept['dept_name']); ?></h4>
                                <p class="text-muted small">
                                    <?php echo htmlspecialchars($dept['description'] ?? 'Providing specialized care'); ?></p>
                                <div class="mt-3 text-primary fw-bold small">
                                    View Doctors <i class="fa-solid fa-arrow-right ms-1"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="text-muted fs-4">No departments found matching "<?php echo htmlspecialchars($search); ?>"</div>
                <a href="departments.php" class="btn btn-outline-primary mt-3">Clear Search</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>