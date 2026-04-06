
@extends('layouts.app')

@section('title', 'Laraveil Suite')
@section('custom-css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="container-fluid book-container pt-5">
    <div class="container">
        <div class="row text-center pt-4">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <div class="step">
                    <div class="circle light">
                        <h1>1</h1>
                    </div>
                    <p class="step-label">Pick a Date</p>
                </div>
                <div class="line"></div>
                <div class="step">
                    <div class="circle">
                        <h1>2</h1>
                    </div>
                    <p class="step-label">Select Accommodations</p>
                </div>
                <div class="line"></div>
                <div class="step">
                    <div class="circle">
                        <h1>3</h1>
                    </div>
                    <p class="step-label">Guest Information</p>
                </div>
                <div class="line"></div>
                <div class="step">
                    <div class="circle">
                        <h1>4</h1>
                    </div>
                    <p class="step-label">Booking Confirmation</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container deets-container">
        <div class="row text-center">
            <div class="col-4">
                <p>Check-in</p>
                <p class="check-in">Select a date</p>
            </div>
            <div class="col-4">
                <p>Check-out</p>
                <p class="check-out">Select a date..</p>
            </div>
            <div class="col-4">
                <p>Number of Nights</p>
                <p class="nights">N/A</p>
            </div>
        </div>
    </div>
    <div class="booking-contents">
        <div class="date-picker" id="date-picker">
        <div class="row justify-content-center text-center p-2">
    <div class="col-md-6 col-lg-6 col-sm-12 rounded">
        <div class="d-flex justify-content-center align-items-center">
            <h2 id="currentMonthTitle" class="me-2"></h2>
            <select id="currentMonthDropdown" class="form-select w-auto">
                <!-- Month options will be populated dynamically -->
            </select>
        </div>
        <div class="col-12">
            <table id="currentMonthCalendar" class="table table-borderless table-custom"></table>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-12 rounded">
        <div class="d-flex justify-content-center align-items-center">
            <h2 id="nextMonthTitle" class="me-2"></h2>
            <select id="nextMonthDropdown" class="form-select w-auto">
                <!-- Month options will be populated dynamically -->
            </select>
        </div>
        <table id="nextMonthCalendar" class="table table-borderless table-custom"></table>
    </div>


        </div>
    </div>
    <div class="container-fluid select-accomodation d-none" id="select-accommodation">
    <div class="container accomodation-page">
        <div class="row">
            <div class="col-12 col-md-9 text-center">
                <div class="row justify-content-center book-room">
                    <!-- Dynamic adding of rooms -->

                </div>
                <div class="row mt-4">
                    <div class="col text-end">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                
                            </ul>
                        </nav>
                    </div>
                </div>
                <input type="hidden" id="totalNightsInput" name="totalNights" value="">
            </div>
            <div class="col-12 col-md-3 d-reciept">
                <div class="container-fluid resibo text-center p-4">
                    <p>Booking Receipt</p>
                    <div class="container-fluid reciept-container">
                        <p><strong>Date</strong> :  <span id="checkIndd"></span> - <span id="checkOutdd"></span></p>
                    </div>
                    <div class="container-fluid text-start mt-2 p-0">
                        <p>Booked Room(s)</p>
                        <div class="container-fluid reciept-container booked-rooms">
                            <!-- Booked rooms will be dynamically updated here -->
                        </div>
                    </div>
                    <div class="container-fluid text-start mt-2 p-0">
                        <p>Other Charges</p>
                        <div class="container-fluid reciept-container">
                            <p><strong>Service Charge & Tax</strong> : Php 1,500.00</p>
                        </div>
                        <div class="container-fluid reciept-container mt-2">
                            <p><strong>Total Bill</strong> : Php <span class="totalPriceDisplay"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add pagination here at the bottom of accomodation-page -->
        
    </div>
</div>

</div>


    <div class="container-fluid guest-info d-none" id="guest-info">
    <div class="container accomodation-page">
        <div class="row">
            <div class="col-12 col-md-9"> <!-- Adjusted column size for cards -->
            <form action="">
                @csrf
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-6 mb-3">
                        <label for="lastname">Lastname <span class="req">*</span></label>
                        <input type="text" class="form-control" placeholder="Lastname" id="lastname" required>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-6 mb-3">
                        <label for="firstname">Firstname <span class="req">*</span></label>
                        <input type="text" class="form-control" placeholder="Firstname" id="firstname" required>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12 mb-3">
                        <label for="salutation">Salutation <span class="req">*</span></label>
                        <input type="text" class="form-control" placeholder="Mr/Mrs" id="salutation" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                        <label for="birthdate">Birthdate <span class="req">*</span></label>
                        <input type="date" class="form-control" id="birthdate" required>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                    <label for="gender">Gender <span class="req">*</span></label>
                <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle gender" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Gender
                </button>
                <ul class="dropdown-menu" id="genderDropdown">
                    <li><a class="dropdown-item" href="#" data-value="Male">Male</a></li>
                    <li><a class="dropdown-item" href="#" data-value="Female">Female</a></li>
                    <li><a class="dropdown-item" href="#" data-value="Something else, idk...">Something else, idk...</a></li>
                </ul>

                </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-12 mb-3">
                        <label for="guestCount">Number of Guests:</label>
                        <input type="number" class="form-control" id="guestCount" min="1" required>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12 mb-3">
                    <h6>Discount Options:</h6>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="discountStudent" name="discountOption" value="student" required>
                        <label class="form-check-label" for="discountStudent">Student Discount (-20%)</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="discountSenior" name="discountOption" value="senior">
                        <label class="form-check-label" for="discountSenior">Senior Citizen Discount (-20%)</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="noDiscount" name="discountOption" value="none" checked>
                        <label class="form-check-label" for="noDiscount">No Discount</label>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                        <label for="email">Email <span class="req">*</span></label>
                        <input type="email" class="form-control" placeholder="Email" id="email" required>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                        <label for="contactNumber">Contact Number <span class="req">*</span></label>
                        <input type="tel" class="form-control" placeholder="Contact Number" id="contactNumber" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="address">Address <span class="req">*</span></label>
                        <input type="text" class="form-control" placeholder="Address" id="address" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center save">
                        <p>SAVE INFORMATION & REGISTER</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="privacy">
                            <label class="form-check-label" for="privacy">
                                I have read and agreed to the <span class="highlight-text privacy-modal">privacy policies and terms and conditions.</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="reservation">
                            <label class="form-check-label" for="reservation">Create my guest account for future reservations.</label>
                        </div>
                    </div>
                </div>
                
            </form>
            </div>
            <div class="col-12 col-md-3 d-reciept"> <!-- Adjusted column size for receipt -->
            <div class="container-fluid resibo text-center p-4">
            <p>Booking Receipt</p>
            <div class="container-fluid reciept-container">
                <p><strong>Date</strong> :  <span class="checkIndd"></span> - <span class="checkOutdd"></span></p>
            </div>
            <div class="container-fluid text-start mt-2 p-0">
                <p>Booked Room(s)</p>
                <div class="container-fluid reciept-container booked-rooms">
                    <!-- Booked rooms will be dynamically updated here -->
                </div>
            </div>
            <div class="container-fluid text-start mt-2 p-0">
                <p>Other Charges</p>
                <div class="container-fluid reciept-container">
                    <p><strong>Service Charge & Tax</strong> : Php 1,500.00</p>
                </div>
                <div class="container-fluid reciept-container mt-2">
                    <p><strong>Total Bill</strong> : Php <span class="totalPriceDisplay"></span></p>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container-fluid booking-confirmation d-none" id="booking-confirmation">
    <div class="container accomodation-page1 px-5">
        <div class="row text-center confirmation">
            <div class="col-12">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
            <hr class="text-white">
            <div class="col-12 text-start intro">
                <div class="container-fluid body p-0">
                    <div class="row">
                        <div class="col-12 text-start">
                            <p class="greeting" style="color:#F2D886;"></p>
                            <p>Thank you for choosing to stay with Laraveil Suites! <br>
                                We are delighted to confirm your reservation and are excited to welcome you. <br>   
                                Below are the details of your reservation for your convenience: </p>
                                <h1 class="mt-2 mb-2">RESERVATION CONFIRMATION</h1>
                                <div class="information mb-2">
                                    <p class="guest-info1">
                                    </p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="text-white">
            <div class="information text-start mb-3">
                <p>Services charge and taxes: <span>Php 1500</span><br>
                    TOTAL AMOUNT TO BE PAID: <span class="total-price">[check-out date]</span>
                </p>
            </div>
            <hr class="text-white">
            <div class="information text-end">
                <p>Warm regards, <br>
                    Laraviel Suites Team <br>
                    <span>
                        +639 234 2345 <br>
                        123 st. Manila <br>
                        LaraveilSuite.com
                    </span>
                </p>
            </div>
        </div>
    </div>
    </div>
    <div class="container-fluid text-end">
        <button class="nextBtn">
            Continue <i class="bi bi-arrow-right"></i>
        </button>
    </div>
</div>
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header  modal-privacy">
                        <h5 class="modal-title" id="privacyModalLabel">Privacy Policies and Terms</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-privacy">
                        <div class="row text-center">
                            <div class="col-12 logo-modal">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo">
                            </div>
                            <div class="col-12">
                                <p class="pri-header">Privacy and Policies</p>
                            </div>
                            <div class="col-12">
                                <p class="mb-2">Laraveil suites is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you make a reservation with us or visit our website. Please read this policy carefully. If you do not agree with the terms of this policy, please do not use our services.</p>
                            </div>
                            <hr>
                            <div class="col-12">
                                <p class="pri-header">Information We Collect</p>
                            </div>
                            <div class="col-12 text-start collect">
                                <ol class="list-unstyled">
                                    <li><strong>1. Personal Information:</strong> This includes your name, email address, phone number, mailing address, and payment information.</li>
                                    <li><strong>2. Reservation Information:</strong> Details about your stay, such as check-in and check-out dates, room preferences, and special requests.</li>
                                    <li><strong>3. Usage Data:</strong> Information about how you use our website, including your IP address, browser type, and pages visited.</li>
                                    <li><strong>4. Cookies and Tracking Technologies:</strong> We use cookies to enhance your experience on our website. You can control cookie preferences through your browser settings.</li>
                                </ol>
                                <hr>
                                <div class="col-12 text-center">
                                    <p class="pri-header">Information We Collect</p>
                                </div>
                                <div class="col-12 text-start collect">
                                    <p class="mb-2">We may share your information with:</p>
                                    <ol class="list-unstyled">
                                        <li><strong>Service Providers</strong>: Third-party vendors who assist us in operating our business </li>
                                        <li><strong>Legal Authorities</strong>: If required by law or in response to valid requests by public authorities.</li>
                                        <li><strong>Business Transfers</strong>: In connection with any merger, sale of company assets, or acquisition of all or a portion of our business.</li>
                                    </ol>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p class="pri-header">Your Rights</p>
                                </div>
                                <div class="col-12 rights">
                                    <ul>
                                        <li>The right to access and receive a copy of your personal information.</li>
                                        <li>The right to request corrections to your personal information.</li>
                                        <li>The right to request the deletion of your personal information.</li>
                                        <li>The right to object to or restrict the processing of your personal information.</li>
                                    </ul>
                                    <p>To exercise these rights, please contact us using the information provided below.</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row text-center">
                                <div class="col-12">
                                    <p class="pri-header">Changes to This Privacy Policy</p>
                                    <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the effective date. We encourage you to review this Privacy Policy periodically for any updates.</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row text-center">
                                <p class="pri-header">Contact Us</p>
                                <p>If you have any questions or concerns about this Privacy Policy or our practices, please contact us at:</p>
                                <div class="container">
                                    <p>Laraveil Suites <br>
                                        Fort Bonifacio, Taguig <br>
                                        laraveilsuites@gmail.com <br>
                                        +63 98521364752</p> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal-privacy">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {




        const privacyCheckbox = document.getElementById('privacy');
        const privacyModal = new bootstrap.Modal(document.getElementById('privacyModal'));
        const privacySpan = document.querySelector('.privacy-modal'); // Select the span element
    
        // Event listener for the span
        privacySpan.addEventListener('click', function() {
            privacyModal.show(); // Show the modal when the span is clicked
        });
    
        // Event listener for the checkbox (no action on click)
        privacyCheckbox.addEventListener('click', function() {
            // Do not show the modal when the checkbox is clicked
        });

        
    });
    
</script>
@endsection
