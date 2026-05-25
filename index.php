<?php
require_once 'config/db.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-medium">Your Health, Our
                    Priority</span>
                <h1 class="hero-title">Connecting Patients to <br> <span class="text-primary">Better Healthcare</span>
                </h1>
                <p class="hero-subtitle">Check OPD schedules in real-time, book your tokens online, and avoid long
                    queues at the hospital. Experience seamless healthcare today.</p>
                <div class="d-flex gap-3 mt-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="user/book_appointment.php" class="btn btn-primary btn-lg shadow-sm"><i
                                class="fa-solid fa-calendar-check me-2"></i>Book Appointment</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary btn-lg shadow-sm"><i
                                class="fa-solid fa-calendar-check me-2"></i>Book Appointment</a>
                    <?php endif; ?>
                    <a href="schedule.php" class="btn btn-outline-primary btn-lg shadow-sm"><i
                            class="fa-solid fa-clock me-2"></i>Check Schedule</a>
                </div>
                <div class="mt-4 d-flex gap-4 text-secondary small">
                    <div><i class="fa-solid fa-check-circle text-success me-1"></i> Verified Doctors</div>
                    <div><i class="fa-solid fa-check-circle text-success me-1"></i> Instant Booking</div>
                    <div><i class="fa-solid fa-check-circle text-success me-1"></i> 24/7 Support</div>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <!-- Placeholder for Hero Image - CSS handling background or use an IMG tag -->
                <img src="https://img.freepik.com/free-vector/doctors-concept-illustration_114360-1515.jpg"
                    alt="Healthcare Professionals" class="img-fluid rounded-4 shadow-lg" style="max-height: 450px;">
            </div>
        </div>
    </div>
</section>

<!-- Why OPD Connect -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase ls-2">Features</h6>
            <h2 class="fw-bold fs-1">Why Choose OPD Connect?</h2>
        </div>
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-3">
                <div class="feature-card h-100">
                    <div class="feature-icon mb-4"><i class="fa-regular fa-clock"></i></div>
                    <h5 class="fw-bold">Real-Time Schedules</h5>
                    <p class="text-muted">Get real-time OPD schedules and doctor availability updates instantly to plan
                        your visit.</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-3">
                <div class="feature-card h-100">
                    <div class="feature-icon mb-4"><i class="fa-solid fa-ticket"></i></div>
                    <h5 class="fw-bold">Avoid Long Queues</h5>
                    <p class="text-muted">Book your OPD token online from home and save your valuable time waiting in
                        lines.</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-3">
                <div class="feature-card h-100">
                    <div class="feature-icon mb-4"><i class="fa-solid fa-route"></i></div>
                    <h5 class="fw-bold">Save Travel Time</h5>
                    <p class="text-muted">Check doctor availability before traveling from far-off areas to the city.</p>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-md-3">
                <div class="feature-card h-100">
                    <div class="feature-icon mb-4"><i class="fa-solid fa-user-doctor"></i></div>
                    <h5 class="fw-bold">Verified Doctors</h5>
                    <p class="text-muted">Connect with certified specialists and experienced doctors for the best care.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Departments Preview -->
<section class="py-5 bg-light position-relative">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h6 class="text-primary fw-bold text-uppercase">Departments</h6>
                <h2 class="fw-bold">Our Medical Departments</h2>
            </div>
            <a href="departments.php" class="btn btn-outline-primary">View All <i
                    class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>

        <div class="row g-4">
            <?php
            // Fetch random 4 departments
            try {
                $stmt = $pdo->query("SELECT * FROM departments LIMIT 4");
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch()) {
                        echo '<div class="col-md-3 col-6">';
                        echo '<a href="doctors.php?dept_id=' . $row['dept_id'] . '" class="text-decoration-none">';
                        echo '<div class="card h-100 border-0 shadow-sm text-center p-4 hover-card transition-all">';
                        echo '<div class="card-body">';
                        echo '<div class="mb-3 d-inline-block p-3 rounded-circle bg-primary bg-opacity-10 text-primary"><i class="fa-solid fa-heart-pulse fs-3"></i></div>';
                        echo '<h5 class="card-title text-dark fw-bold">' . htmlspecialchars($row['dept_name']) . '</h5>';
                        echo '<p class="text-muted small mb-0 text-truncate">' . htmlspecialchars($row['description'] ?? 'Specialized care') . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center text-muted">No departments found.</div>';
                }
            } catch (PDOException $e) {
                echo '<p class="text-center text-muted">Departments unavailable.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Doctors Preview -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h6 class="text-primary fw-bold text-uppercase">Specialists</h6>
                <h2 class="fw-bold">Our Top Doctors</h2>
            </div>
            <a href="doctors.php" class="btn btn-outline-primary">View All <i
                    class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
        <div class="row g-4">
            <?php
            // Fetch 4 doctors with dept name
            try {
                $sql = "SELECT d.*, dept.dept_name FROM doctors d 
                        LEFT JOIN departments dept ON d.dept_id = dept.dept_id 
                        LIMIT 4";
                $stmt = $pdo->query($sql);
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch()) {
                        echo '<div class="col-md-3 col-sm-6">';
                        echo '<div class="card h-100 border-0 shadow-hover overflow-hidden">';
                        // Placeholder image logic
                        echo '<div class="text-center bg-light pt-4">';
                        echo '<img src="assets/images/doctor_placeholder.png" class="rounded-circle shadow-sm border border-4 border-white" width="120" height="120" style="object-fit:cover;">';
                        echo '</div>';
                        echo '<div class="card-body text-center">';
                        echo '<h5 class="card-title fw-bold mb-1">' . htmlspecialchars($row['doctor_name']) . '</h5>';
                        echo '<span class="badge bg-primary bg-opacity-10 text-primary mb-2">' . htmlspecialchars($row['dept_name']) . '</span>';
                        echo '<p class="text-muted small mb-3">' . htmlspecialchars($row['qualification']) . '</p>';
                        echo '<div class="d-grid">';
                        echo '<a href="doctors.php?doctor_id=' . $row['doctor_id'] . '" class="btn btn-sm btn-outline-primary">View Profile</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center text-muted">No doctors found.</div>';
                }
            } catch (PDOException $e) {
                echo '<p class="text-center text-muted">Doctors unavailable.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- OPD Schedule Quick Check -->
<section class="py-5 bg-primary text-white position-relative overflow-hidden">
    <div class="container position-relative z-1">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-center mb-5">
                    <h2 class="fw-bold display-5">Check OPD Schedule</h2>
                    <p class="lead opacity-75">Find out exactly when your doctor is available without visiting the
                        hospital.</p>
                </div>
                <div class="card border-0 shadow-lg rounded-4 p-2">
                    <div class="card-body p-4">
                        <form action="schedule.php" method="GET" class="row g-3 text-dark">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-uppercase small text-muted">Department</label>
                                <select name="dept_id" class="form-select form-select-lg bg-light border-0">
                                    <option value="">Select Department</option>
                                    <?php
                                    try {
                                        $dept_stm = $pdo->query("SELECT * FROM departments");
                                        while ($d = $dept_stm->fetch()) {
                                            echo "<option value='" . $d['dept_id'] . "'>" . $d['dept_name'] . "</option>";
                                        }
                                    } catch (Exception $e) {
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-uppercase small text-muted">Doctor</label>
                                <select name="doctor_id" class="form-select form-select-lg bg-light border-0">
                                    <option value="">Select Doctor</option>
                                    <?php
                                    try {
                                        $doc_stm = $pdo->query("SELECT doctor_id, doctor_name FROM doctors");
                                        while ($doc = $doc_stm->fetch()) {
                                            echo "<option value='" . $doc['doctor_id'] . "'>" . $doc['doctor_name'] . "</option>";
                                        }
                                    } catch (Exception $e) {
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Check Schedule <i
                                        class="fa-solid fa-arrow-right ms-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Preview -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <h6 class="text-primary fw-bold text-uppercase">Get in Touch</h6>
                <h2 class="fw-bold mb-4">We are here to help you.</h2>
                <p class="text-muted mb-5">Have questions? Need assistance with booking? Reach out to our 24/7 support
                    team or visit us at our main campus.</p>

                <div class="d-flex align-items-center mb-4">
                    <div class="icon-square bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                        <i class="fa-solid fa-phone fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Emergency Helpline</h6>
                        <p class="mb-0 text-muted">+92 300 1234567</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="icon-square bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                        <i class="fa-solid fa-envelope fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Email Support</h6>
                        <p class="mb-0 text-muted">help@opdconnect.com</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="icon-square bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                        <i class="fa-solid fa-location-dot fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Location</h6>
                        <p class="mb-0 text-muted">123 Health Avenue, Medical City, Lahore</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="map-container rounded-4 overflow-hidden shadow-lg position-relative"
                    style="height: 400px; background: #eee;">
                    <!-- Actual Google Maps Embed would go here -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3399.0123456789!2d74.3587!3d31.5204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3919000000000000%3A0x0!2zMzHCsDMxJzEzLjQiTiA3NMKwMjEnMzEuMyJF!5e0!3m2!1sen!2s!4v1600000000000!5m2!1sen!2s"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>