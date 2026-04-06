@extends('layouts.app')

@section('title', 'Laraveil Suite')

@section('custom-css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
        
@section('content')
<!-- Hero Section -->
<div class="offers-hero d-flex align-items-center justify-content-center text-center">
    <div class="hero-overlay"></div>
    <div class="container">
        <!-- Responsive text classes based on screen size -->
        <h1 class="offers-title display-4 display-md-3 display-lg-1">
            SEASONAL<br>AND<br>EXCLUSIVE OFFERS
        </h1>
    </div>
</div>
<!-- Offers Section -->
<div class="container mt-5">
    <div class="row">
        <!-- Holiday Retreat Package -->
        <div class="col-md-6 mb-4">
            <div class="offer-card">
                <div class="offer-header">
                    <h3>HOLIDAY RETREAT PACKAGE</h3>
                    <div class="luxury-badge">LUXURY LIVING</div>
                    <p class="tagline">"Find your peace in the pulse of BGC"</p>
                </div>
                <div class="offer-content">
                    <p class="offer-description">Celebrate the festive season with our Holiday Retreat Package, designed to bring you joy and relaxation. Enjoy a 20% discount on your stay, complimentary breakfast for two, and access to our exclusive holiday amenities, including a festive welcome drink and holiday-themed room decor. Perfect for couples or families looking to experience a cozy and magical getaway this holiday season.</p>
                    <ul class="offer-features">
                        <li>20% off on room rates</li>
                        <li>Complimentary breakfast for two</li>
                        <li>Holiday welcome drink and room decor</li>
                        <li>Late checkout (subject to availability)</li>
                    </ul>
                    <div class="offer-validity">
                        <p>Selling Dates: Until December 29, 2024</p>
                        <p>Redemption Dates: Until December 30, 2024</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekend Escape Package -->
        <div class="col-md-6 mb-4">
            <div class="offer-card">
                <div class="offer-header">
                    <h3>WEEKEND ESCAPE PACKAGE</h3>
                    <div class="luxury-badge">LUXURY LIVING</div>
                    <p class="tagline">"Find your peace in the pulse of BGC"</p>
                </div>
                <div class="offer-content">
                    <p class="offer-description">Unwind from the week with our Weekend Escape Package—an exclusive deal for weekend travelers. Arrive on a Friday or Saturday to enjoy 15% off your stay, a complimentary room upgrade, and a late checkout for a leisurely departure. Perfect for those looking to recharge and explore BGC's vibrant weekend scene.</p>
                    <ul class="offer-features">
                        <li>15% off on weekend bookings</li>
                        <li>Complimentary room upgrade (subject to availability)</li>
                        <li>Late checkout on Sunday</li>
                        <li>Free access to our rooftop lounge</li>
                    </ul>
                    <div class="offer-validity">
                        <p>Selling Dates: Until December 29, 2024</p>
                        <p>Redemption Dates: Until December 30, 2024</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indulgence Card Section -->
    <div class="row mt-1 mb-5">
        <div class="col-12">
            <div class="indulgence-wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="indulgence-card">
                            <h2>UPCOMING LARAVEIL<br>Indulgence Card</h2>
                            <p class="indulgence-description">Get ready to elevate your stay with the exclusive Laraveil Indulgence Card - your all-access pass to a world of rewards and privileges.Designed with our most valued guests in mind, the Indulgence Card offers exclusive perks, from discounted rates and complimentary upgrades to priority reservations and VIP access to our premium amenities.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="key-benefits" style="color: #FEF3E2;">
                            <h3>Key Benefits:</h3>
                            <ul>
                                <li>Special Member Rates: Enjoy exclusive discounts on room bookings and packages year-round.</li>
                                <li>Complimentary Upgrades: Receive free room upgrades whenever available.</li>
                                <li>Early Check-in & Late Checkout: Flexibility designed to fit your schedule, upon availability.</li>
                                <li>Priority Reservations: Be first in line for booking our suites and amenities.</li>
                                <li>Exclusive Dining and Spa Discounts: Indulge in dining and spa services with special discounts, available only to cardholders.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="indulgence-footer text-center mt-4">
                    <p>The Laraveil Indulgence Card will soon be available for purchase at our front desk and online. Stay tuned for its launch and start experiencing the finest in luxury and hospitality at Laraveil Suites.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection