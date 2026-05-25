<?php
include 'includes/header.php';
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-primary fw-bold text-uppercase">FAQs</h6>
        <h2 class="fw-bold">Frequently Asked Questions</h2>
        <p class="text-muted">Find answers to common questions about appointments and services.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion accordion-flush shadow-sm rounded-4 overflow-hidden" id="accordionExample">

                <!-- Item 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold py-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            How do I book an appointment?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body text-muted">
                            You can book an appointment by creating an account on OPD Connect. Once logged in, go to
                            "Book Appointment", select your department and doctor, choose a date, and confirm your
                            booking. You will receive a token number immediately.
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Is there a fee for online booking?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body text-muted">
                            No, the online booking service via OPD Connect is completely free of charge. You only pay
                            the consultation fee at the hospital counter or as per the hospital's policy.
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Can I cancel my appointment?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body text-muted">
                            Yes, you can cancel your appointment from your User Dashboard under the "My Appointments"
                            section. Please try to cancel at least 2 hours before the scheduled time.
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            How do I check a doctor's schedule?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body text-muted">
                            You can visit the "OPD Schedule" page from the main menu. Select the department and doctor
                            to see their available days and timings.
                        </div>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            What if the doctor is on leave?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body text-muted">
                            If a doctor is on leave, their status will be shown as "On Leave" in the schedule and
                            doctors list. You will not be able to book appointments for the days they are unavailable.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>