<?php
// Start Session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Get current page name for active link highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPD Connect - Your Healthcare Partner</title>

    <!-- Bootstrap 5 CSS -->
    <?php
    // Start Session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Get current page name for active link highlighting
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OPD Connect - Your Healthcare Partner</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet"
            href="<?php echo (strpos($_SERVER['PHP_SELF'], '/user/') !== false || strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>assets/css/style.css">
    </head>

<body>

    <?php
    $base_url = (strpos($_SERVER['PHP_SELF'], '/user/') !== false || strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
    ?>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $base_url; ?>index.php">
                <i class="fa-solid fa-hospital-user"></i> OPD Connect
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>"
                            href="<?php echo $base_url; ?>index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'departments.php' ? 'active' : ''; ?>"
                            href="<?php echo $base_url; ?>departments.php">Departments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'doctors.php' ? 'active' : ''; ?>"
                            href="<?php echo $base_url; ?>doctors.php">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'schedule.php' ? 'active' : ''; ?>"
                            href="<?php echo $base_url; ?>schedule.php">OPD Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'contact.php' ? 'active' : ''; ?>"
                            href="<?php echo $base_url; ?>contact.php">Contact</a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Logged In User Links -->
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle btn btn-outline-primary text-primary px-3" href="#"
                                role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-circle"></i>
                                <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Account'); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>user/dashboard.php"><i
                                            class="fa-solid fa-gauge me-2"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>user/appointments.php"><i
                                            class="fa-solid fa-calendar-check me-2"></i> My Appointments</a></li>
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>user/profile.php"><i
                                            class="fa-solid fa-user-gear me-2"></i> Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="<?php echo $base_url; ?>logout.php"><i
                                            class="fa-solid fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php elseif (isset($_SESSION['admin_id'])): ?>
                        <!-- Admin Links -->
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle btn btn-dark text-white px-3" href="#" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-shield"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>admin/dashboard.php"><i
                                            class="fa-solid fa-gauge me-2"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>admin/departments.php"><i
                                            class="fa-solid fa-building me-2"></i> Departments</a></li>
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>admin/doctors.php"><i
                                            class="fa-solid fa-user-doctor me-2"></i> Doctors</a></li>
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>admin/appointments.php"><i
                                            class="fa-solid fa-calendar-check me-2"></i> Appointments</a></li>
                                <li><a class="dropdown-item" href="<?php echo $base_url; ?>admin/users.php"><i
                                            class="fa-solid fa-users me-2"></i> Users</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="<?php echo $base_url; ?>logout.php"><i
                                            class="fa-solid fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Guest Buttons -->
                        <li class="nav-item ms-2">
                            <a href="<?php echo $base_url; ?>login.php" class="btn btn-outline-primary me-2">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_url; ?>register.php" class="btn btn-primary">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>