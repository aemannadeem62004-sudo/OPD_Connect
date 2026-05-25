<?php
include 'includes/header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulate email sending or DB storage
    $msg = '<div class="alert alert-success">Thank you! Your message has been sent. We will contact you shortly.</div>';
}
?>

<div class="container py-5">
    <div class="row g-5">
        <!-- Contact Info -->
        <div class="col-lg-5">
            <h6 class="text-primary fw-bold text-uppercase">Contact Us</h6>
            <h2 class="fw-bold mb-4">Get in Touch</h2>
            <p class="text-muted mb-5">We are here to assist you. Feel free to reach out for any queries regarding
                appointments, doctors, or hospital services.</p>

            <div class="d-flex mb-4">
                <div class="flex-shrink-0 btn-lg-square bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Our Location</h5>
                    <p class="text-muted mb-0">123 Health Avenue, Medical City, Lahore, Pakistan</p>
                </div>
            </div>

            <div class="d-flex mb-4">
                <div class="flex-shrink-0 btn-lg-square bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Email Us</h5>
                    <p class="text-muted mb-0">info@opdconnect.com</p>
                    <p class="text-muted mb-0">support@opdconnect.com</p>
                </div>
            </div>

            <div class="d-flex mb-4">
                <div class="flex-shrink-0 btn-lg-square bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Call Us</h5>
                    <p class="text-muted mb-0">+92 300 1234567</p>
                    <p class="text-muted mb-0">+92 42 111 222 333</p>
                </div>
            </div>

            <!-- Social Links -->
            <div class="mt-5">
                <h6 class="fw-bold mb-3">Follow Us</h6>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-secondary rounded-circle"><i
                            class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle"><i
                            class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle"><i
                            class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle"><i
                            class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
                <h3 class="fw-bold mb-4">Send us a Message</h3>
                <?php echo $msg; ?>
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control bg-light border-0 py-3"
                                placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Your Email</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-3"
                                placeholder="john@example.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control bg-light border-0 py-3"
                                placeholder="Appointment Inquiry">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control bg-light border-0 py-3" rows="5"
                                placeholder="How can we help you?" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">Send
                                Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="rounded-4 overflow-hidden shadow-sm" style="height: 400px;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13606.516805128796!2d74.3141!3d31.5039!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzHCsDMwJzE0LjAiTiA3NMKwMTgnNTAuOCJF!5e0!3m2!1sen!2s!4v1634567890"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>