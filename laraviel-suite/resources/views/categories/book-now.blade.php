@extends('layouts.app')

@section('title', 'Reserve Your Sanctuary')

@section('custom-css')
<style>
    .booking-wrapper {
        min-height: 100vh;
        background: linear-gradient(rgba(30, 20, 12, 0.8), rgba(30, 20, 12, 0.9)), url('{{ asset('images/HOTELMAINPAGEPIC.jpg') }}') center/cover fixed no-repeat;
        padding: 150px 0 100px;
    }

    .booking-card {
        background: var(--glass-dark);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--border-gold);
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.6);
        position: relative;
        overflow: hidden;
    }

    /* ── Progress Stepper ───────────────────── */
    .stepper {
        display: flex;
        justify-content: center;
        gap: 60px;
        margin-bottom: 80px;
        position: relative;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        z-index: 2;
    }

    .step-circle {
        width: 15px; height: 15px;
        border: 2px solid var(--brand-gold);
        border-radius: 50%;
        background: transparent;
        transition: var(--transition-premium);
    }

    .step-item.active .step-circle {
        background: var(--brand-gold);
        box-shadow: 0 0 15px var(--brand-gold);
    }

    .step-item.active .step-label {
        color: var(--brand-gold);
        opacity: 1;
    }

    .step-label {
        font-family: 'Aboreto', cursive;
        font-size: 0.7rem;
        letter-spacing: 3px;
        color: var(--brand-cream);
        opacity: 0.4;
        text-transform: uppercase;
    }

    /* ── Calendar Redesign ──────────────────── */
    .calendar-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    @media (min-width: 992px) { 
        .calendar-container { 
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        } 
    }

    @media (max-width: 991px) { .calendar-container { grid-template-columns: 1fr; } }

    .calendar-card {
        background: rgba(254, 243, 226, 0.03);
        border-radius: 24px;
        padding: 25px;
        border: 1px solid var(--border-subtle);
    }

    .calendar-title {
        font-family: 'Kanit', sans-serif;
        font-size: 1.1rem;
        color: var(--brand-gold);
        margin-bottom: 20px;
        text-align: center;
        letter-spacing: 2px;
    }

    .calendar-table {
        width: 100%;
        border-spacing: 5px;
        border-collapse: separate;
    }

    .calendar-table th {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: var(--text-muted);
        text-align: center;
        padding-bottom: 10px;
        font-weight: 400;
        letter-spacing: 1px;
    }

    .clickable-day {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 35px; height: 35px;
        margin: auto;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .clickable-day.disabled {
        opacity: 0.2;
        cursor: not-allowed;
        pointer-events: none;
    }

    .clickable-day:hover {
        background: rgba(191, 167, 93, 0.2);
        color: var(--brand-gold);
    }

    .active-cell {
        background: var(--brand-gold) !important;
        color: var(--bg-deep) !important;
        border-radius: 50%;
    }

    /* ── Form Inputs ────────────────────────── */
    .luxury-input {
        background: rgba(254, 243, 226, 0.03);
        border: 1px solid rgba(191,167, 93, 0.3);
        color: var(--brand-cream);
        border-radius: 8px;
        padding: 12px 20px;
        width: 100%;
        transition: var(--transition-premium);
        margin-bottom: 20px;
    }

    .luxury-input option {
        background: var(--bg-deep);
        color: var(--brand-cream);
    }

    .luxury-input:focus {
        border-color: var(--brand-gold);
        background: rgba(254, 243, 226, 0.06);
        outline: none;
        box-shadow: 0 0 15px rgba(191, 167, 93, 0.1);
    }

    .luxury-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--brand-gold);
        margin-bottom: 8px;
        display: block;
    }

    /* ── Room Cards for Booking ─────────────── */
    .room-card {
        background: rgba(254, 243, 226, 0.04);
        border: 1px solid rgba(191, 167, 93, 0.15);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .room-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        border-color: var(--brand-gold);
    }

    .room-image-wrapper {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .room-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .room-card:hover .room-image-wrapper img {
        transform: scale(1.08);
    }

    .room-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        background: var(--brand-gold);
        color: var(--bg-deep);
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .room-content {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .room-type {
        font-family: 'Kanit', sans-serif;
        font-size: 1.1rem;
        color: var(--brand-cream, #FEF3E2);
        margin-bottom: 8px;
    }

    .room-description {
        color: rgba(254, 243, 226, 0.6);
        font-size: 0.82rem;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .room-price-row {
        margin-top: auto;
    }

    .price-label {
        font-size: 0.6rem;
        color: rgba(191, 167, 93, 0.7);
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
    }

    .price-value {
        color: var(--brand-gold);
        font-size: 1rem;
        font-weight: 700;
        font-family: 'Kanit', sans-serif;
    }

    .select-room-btn {
        font-size: 0.75rem !important;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 600;
        border-radius: 50px !important;
        padding: 8px 24px !important;
        transition: all 0.3s ease;
    }

    .select-room-btn:hover {
        transform: scale(1.05);
    }

    /* ── Step 2 Room Grid ──────────────────── */
    #step-2-content .standard-room .col-md-6,
    #step-2-content .standard-room .col-lg-4 {
        padding-bottom: 8px;
    }

    /* ── Confirmation Step ─────────────────── */
    .glass-card {
        background: rgba(254, 243, 226, 0.04);
        border: 1px solid rgba(191, 167, 93, 0.2);
        border-radius: 20px;
        padding: 30px;
    }

    /* ── Booking Summary ────────────────────── */
    .summary-sidebar {
        background: rgba(191, 167, 93, 0.05);
        border: 1px solid var(--border-gold);
        border-radius: 24px;
        padding: 30px;
        position: sticky;
        top: 120px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .summary-total {
        border-top: 1px solid var(--border-gold);
        margin-top: 20px;
        padding-top: 20px;
        font-family: 'Kanit', sans-serif;
        font-size: 1.4rem;
        color: var(--brand-gold);
    }

    /* ── Responsive Polish ─────────────────── */
    @media (max-width: 768px) {
        .booking-card { padding: 30px 20px; border-radius: 24px; }
        .stepper { gap: 25px; margin-bottom: 40px; }
        .room-image-wrapper { height: 180px; }
        #step-2-content .standard-room { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<section class="booking-wrapper">
    <div class="container">
        <!-- Stepper -->
        <div class="stepper" id="stepper">
            <div class="step-item active" id="step-1-indicator">
                <div class="step-circle"></div>
                <span class="step-label">Timeline</span>
            </div>
            <div class="step-item" id="step-2-indicator">
                <div class="step-circle"></div>
                <span class="step-label">Accommodation</span>
            </div>
            <div class="step-item" id="step-3-indicator">
                <div class="step-circle"></div>
                <span class="step-label">Resident Details</span>
            </div>
            <div class="step-item" id="step-4-indicator">
                <div class="step-circle"></div>
                <span class="step-label">Payment</span>
            </div>
            <div class="step-item" id="step-5-indicator">
                <div class="step-circle"></div>
                <span class="step-label">Confirmation</span>
            </div>
        </div>

        <div class="row g-5">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="booking-card">
                    
                    <!-- Step 1: Timeline -->
                    <div id="step-1-content">
                        <h2 class="aboreto text-gold mb-5">Select Your Timeline</h2>
                        <div class="calendar-container">
                            <!-- Left Calendar -->
                            <div class="calendar-card">
                                <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                                    <button class="btn btn-link text-gold p-0 text-decoration-none border-0 bg-transparent fs-5" id="prevMonthBtn"><i class="bi bi-chevron-left"></i></button>
                                    <div class="calendar-title mb-0" id="currentMonthTitle"></div>
                                    <div style="width: 24px;"></div> <!-- Spacer -->
                                </div>
                                <table class="calendar-table" id="currentMonthCalendar"></table>
                            </div>
                            <!-- Right Calendar -->
                            <div class="calendar-card">
                                <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                                    <div style="width: 24px;"></div> <!-- Spacer -->
                                    <div class="calendar-title mb-0" id="nextMonthTitle"></div>
                                    <button class="btn btn-link text-gold p-0 text-decoration-none border-0 bg-transparent fs-5" id="nextMonthBtn"><i class="bi bi-chevron-right"></i></button>
                                </div>
                                <table class="calendar-table" id="nextMonthCalendar"></table>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Accommodation -->
                    <div id="step-2-content" class="d-none">
                        <h2 class="aboreto text-gold mb-5">Curate Your Stay</h2>
                        <div class="row g-4 standard-room">
                            <!-- Populated via AJAX -->
                        </div>
                    </div>

                    <!-- Step 3: Resident Details -->
                    <div id="step-3-content" class="d-none">
                        <h2 class="aboreto text-gold mb-5">Resident Profile</h2>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="small text-gold aboreto mb-2">Salutation</label>
                                <select class="form-control luxury-input" id="salutation">
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Mrs.">Mrs.</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="luxury-label">First Name</label>
                                <input type="text" class="luxury-input" id="firstname" placeholder="Enter first name">
                            </div>
                            <div class="col-md-5">
                                <label class="luxury-label">Last Name</label>
                                <input type="text" class="luxury-input" id="lastname" placeholder="Enter last name">
                            </div>
                            <div class="col-md-6">
                                <label class="luxury-label">Email Address</label>
                                <input type="email" class="luxury-input" id="email" placeholder="resident@example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="luxury-label">Contact Number</label>
                                <input type="text" class="luxury-input" id="contactNumber" placeholder="+63 9xx xxx xxxx">
                            </div>
                            <div class="col-12">
                                <label class="luxury-label">Full Residential Address</label>
                                <textarea class="luxury-input" id="address" rows="3" placeholder="Street, City, Country"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Payment -->
                    <div id="step-4-content" class="d-none">
                        <h2 class="aboreto text-gold mb-5">Select Payment Method</h2>
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="luxury-label">Payment Type</label>
                                <select class="form-control luxury-input mb-4" id="paymentMethodSelect">
                                    <option value="over_the_counter">Pay at Counter</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pay at Counter Info -->
                        <div id="counterPaymentForm" class="payment-form">
                            <div class="glass-card p-4 text-center">
                                <i class="bi bi-wallet2 text-gold mb-3" style="font-size: 3rem;"></i>
                                <h4 class="text-gold aboreto">Pay Upon Arrival</h4>
                                <p class="text-cream opacity-75">Your reservation will be secured, and payment will be collected at the front desk during check-in. Your booking status will be pending until then.</p>
                            </div>
                        </div>

                        <!-- Processing Animation -->
                        <div id="paymentProcessing" class="d-none text-center py-5">
                            <div class="spinner-border text-gold mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
                            <h4 class="text-gold aboreto">Processing Payment...</h4>
                            <p class="text-cream opacity-75">Please do not close or refresh this page.</p>
                        </div>
                    </div>

                    <!-- Step 5: Final Confirmation -->
                    <div id="step-5-content" class="d-none text-center">
                        <div class="py-5" data-aos="zoom-in">
                            <i class="bi bi-check2-circle text-gold mb-4" style="font-size: 5rem;"></i>
                            <h2 class="aboreto text-gold mb-3 greeting">Request Confirmed</h2>
                            <p class="text-cream opacity-75 mb-5 px-lg-5">Your sanctuary awaits. A detailed summary of your curated stay has been dispatched to your digital correspondence.</p>
                            
                            <div class="glass-card text-start mb-5 mx-auto" style="max-width: 500px;">
                                <div class="guest-info1 text-cream opacity-75"></div>
                                <div class="summary-total mt-4 pt-4">
                                    <span class="small brand-font text-cream opacity-75 d-block">Grand Total</span>
                                    <span class="total-price">Php 0.00</span>
                                </div>
                            </div>
                            
                            <a href="/" class="btn-luxury mt-4 px-5">Return Home</a>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-5 pt-5 d-flex justify-content-between border-top border-gold border-opacity-10" id="step-navigation">
                        <button class="btn btn-outline-light rounded-pill px-4 d-none" id="prevBtn">Previous Step</button>
                        <button class="btn btn-premium-solid px-5 ms-auto" id="nextBtn">Continue Journey</button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Summary -->
            <div class="col-lg-4" id="booking-summary-sidebar">
                <div class="summary-sidebar" data-aos="fade-left">
                    <h4 class="aboreto text-gold mb-4" style="font-size: 0.9rem; letter-spacing: 2px;">Sanctuary Summary</h4>
                    
                    <div class="summary-item">
                        <span class="text-cream opacity-75">Stay Duration</span>
                        <span class="nights text-cream">Select Dates</span>
                    </div>
                    <div class="summary-item">
                        <span class="text-cream opacity-75">Check-in</span>
                        <span id="checkIndd" class="text-cream">-- -- ----</span>
                    </div>
                    <div class="summary-item">
                        <span class="text-cream opacity-75">Check-out</span>
                        <span id="checkOutdd" class="text-cream">-- -- ----</span>
                    </div>
                    
                    <div class="mt-4 pt-4 border-top border-gold border-opacity-10">
                        <span class="luxury-label">Selected Suites</span>
                        <div class="booked-rooms text-cream small pt-2">None selected</div>
                    </div>

                    <div class="summary-total">
                        <span class="small brand-font text-cream opacity-75 d-block" style="font-size: 0.6rem; letter-spacing: 4px;">Investment Total</span>
                        <span class="totalPriceDisplay">Php 0.00</span>
                    </div>
                    
                    <input type="hidden" id="totalNightsInput" value="0">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script>
    // I will integrate this into script.js but for now, we'll keep the logic clean
</script>
@endsection
