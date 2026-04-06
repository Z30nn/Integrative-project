@extends('layouts.app')

@section('title', 'Laraveil Suite')

@section('custom-css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
        
@section('content')
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Luxuryliving</h1>
            <p class="hero-subtitle hero-title">"Find your peace in the pulse of BGC"</p>
        </div>
    </div>

    <div class="container about">
        <div class="row mb-5">
            <div class="col-md-6">
                <h2 class="section-title">WHY LARAVEIL SUITES?</h2>
                <p class="section-text">
                    Nestled in the vibrant heart of Bonifacio Global City (BGC), Laraveil Suites offers unparalleled access to the city's finest attractions. Just steps away, you'll find a myriad of upscale shopping destinations, including the iconic SM Aura Premier and Market Market, as well as diverse array of dining options that range from international cuisine to local favorites. Enjoy the nearby lush parks like Terra 28th Trail and Track 30th, perfect escapes for a refreshing break or a leisurely picnic. With easy access to major business districts, cultural sites, and entertainment hubs, Laraveil Suites positions you perfectly to experience the dynamic lifestyle BGC has to offer.
                </p>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('images/about.png') }}" alt="BGC Night View" class="img-fluid about-image">
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-6">
                <div class="image-grid">
                    <img src="{{ asset('images/pexels-valeriya-1860197.jpg') }}" alt="Hotel Lounge" class="grid-image">
                    <img src="{{ asset('images/pexels-gapeppy1-2373201.jpg') }}" alt="Hotel Pool" class="grid-image">
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="section-title">AMBIANCE</h2>
                <p class="section-text">
                    At Laraveil Suites, immerse yourself in a sophisticated and inviting atmosphere that combines modern elegance with the warmth of home. Experience a tranquil escape amidst the urban bustle, where each corner reflects a commitment to comfort and style. With thoughtfully designed spaces that seamlessly transition from day to night, we invite you to the city's energy, allowing you to unwind and recharge in a luxurious setting. Whether you're here for business or leisure, Laraveil Suites offers a harmonious blend of convenience and serenity, making every stay a memorable one.
                </p>
            </div>
        </div>
    </div>

    <!-- New Mission/Vision/Approach Section -->
    <div class="container-fluid mission-vision-section">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <!-- Mission Box -->
                <div class="info-box mission-box">
                    <h2>Our Mission</h2>
                    <p class="small-text">To be the premier choice for travelers seeking an unparalleled blend of luxury, comfort, and personalized service in Bonifacio Global City, setting the standard for excellence in hospitality while fostering lasting connections with our guests and the community.</p>
                </div>
                <!-- Approach Box -->
                <div class="info-box approach-box">
                    <h2>Our Approach</h2>
                    <p class="small-text">Our approach emphasizes the guest experience, with a dedicated team that listens and responds to your needs, ensuring a seamless and enjoyable stay. We are also committed to sustainability and continuous improvement, striving to minimize our environmental impact while enhancing the quality of your experience. Together, these elements define Laraveil Suites as a destination where luxury and genuine hospitality converge to create unforgettable memories.</p>
                </div>
            </div>

            <!-- Right Column - Vision -->
            <div class="col-md-6">
                <div class="info-box vision-box">
                    <h2>Our Vision</h2>
                    <p class="small-text">At Laraveil Suites, our mission is to create memorable experiences by providing exceptional accommodations and unmatched hospitality. We are dedicated to:</p>
                    <ul>
                        <li class="small-text">Delivering personalized service that anticipates and exceeds our guests' expectations.</li>
                        <li class="small-text">Maintaining the highest standards of cleanliness, comfort, and safety in our suites.</li>
                        <li class="small-text">Creating a welcoming and inclusive environment for all guests and staff.</li>
                        <li class="small-text">Embracing sustainability and responsible practices to positively impact our community.</li>
                        <li class="small-text">Fostering a culture of continuous improvement and professional development among our team members.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection 