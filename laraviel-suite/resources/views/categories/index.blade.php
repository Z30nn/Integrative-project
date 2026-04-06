@extends('layouts.app')

@section('title', 'Laraveil Suite')  <!-- Optional: Set the title of the page -->
@section('custom-css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Full-height container with background -->
    <div class="container-fluid bg overlay"> 
        <div class="d-flex align-items-center justify-content-center h-100 text-center">
            <div class="d-flex flex-column">
            <h1 class="mx-auto elevate display-5 display-md-4 display-lg-3 fw-bold text-light text-shadow">
    ELEVATE YOUR STAY
</h1>
<h2 class="hotel-name fs-6 fs-md-5 fs-lg-4 fw-light text-light text-shadow">
    Laraveil Suites
</h2>

            </div>
        </div>
    </div>

    <div class="newSction container-fluid">
        <div class="container checkInOut"> <!-- Opening container -->
            <div class="row text-align-center"> <!-- Opening row -->

            </div> <!-- Closing row -->

            <div class="text-center p-relative logo-name mt-4"> <!-- Gallery title section -->
                <h1 class="gallery">GALLERY</h1>
                <p class="gallery">KNOW US BY PICTURES</p>
            </div> <!-- Closing logo-name -->
        </div> <!-- Closing container -->

        <div class="images container"> <!-- Opening images section -->
            <div class="grid-wrapper mt-3 pt-5">
                <div>
                    <img src="./images/homepage about us pic.png" alt="" />
                </div>
                <div>
                    <img src="./images/homepage gallery food.png" alt="" />
                </div>
                <div class="tall">
                    <img src="./images/pexels-valeriya-1860197.jpg" alt="">
                </div>
                <div class="wide">
                    <img src="./images/homepage gallery pool.png" alt="" />
                </div>
                <div>
                    <img src="./images/homepage gallery privacy.png" alt="" />
                </div>
                <div class="tall">
                    <img src="./images/balcony.png" alt="" />
                </div>
                <div class="wide">
                <img src="./images/food.jpg" alt="" />
                </div>
                <div>
                    <img src="./images/homepage gallery seaside.png" alt="" />
                </div>
            </div>
        </div> <!-- Closing images section -->
    </div> <!-- Closing newSction -->
    <div class="container-fluid aboutUs overlay1">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center p-4 text">
                <h1>About us</h1>
                <p>Welcome to Laraveil Suites, where comfort meets sophistication. Nestled in the heart of the city, Laraveil Suites offers a seamless blend of modern elegance and personalized service. Whether you're traveling for business or leisure, our hotel is designed to provide a memorable and stress-free experience.At Laraveil Suites, we pride ourselves on offering more than just a place to stay. Our state-of-the-art amenities, luxurious rooms, and dedicated staff ensure that every guest enjoys the highest level of comfort and convenience. From our intuitive online reservation system to our warm in-person service, we prioritize your satisfaction at every step.We believe in creating a home away from home, a place where you can relax, recharge, and explore. <br><br> Welcome to Laraveil Suites—your perfect getaway awaits.</p>
                <a href="" class="connect mt-3">Connect With Us</a>
            </div>
        </div>
    </div>
    <div class="container-fluid feedbacks text-center">
    <h1 class="feed-text">Client Feedbacks</h1>
    <!-- Carousel Container -->
    <div id="feedbackCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner p-2">
        <!-- Loop over feedbacks and group them into slides -->
        @php
            $chunkedFeedbacks = array_chunk($feedbacks->toArray(), 4); // Split feedbacks into chunks of 4
        @endphp
        
        @foreach ($chunkedFeedbacks as $index => $feedbackChunk)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="row justify-content-center">
                    @foreach ($feedbackChunk as $feedback)
                        <div class="col-md-3 feedback-card d-flex flex-column p-3">
                            <p>{{ $feedback['feedback'] }}</p>
                            
                            <!-- Stars Section with Bootstrap classes to position it at the bottom -->
                            <div class="stars mt-auto">
                                @for ($i = 0; $i < $feedback['rating']; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                                @for ($i = $feedback['rating']; $i < 5; $i++)
                                    <i class="bi bi-star"></i>
                                @endfor
                            </div>
                            
                            <!-- Submitted by Section -->
                            <p class="mt-2"><strong>Submitted by:</strong> 
                                @if($feedback['anonymous'])
                                    Anonymous
                                @else
                                    @php
                                        $guest = \App\Models\Guest::find($feedback['guest_id']);
                                    @endphp
                                    {{ $guest ? $guest->lastname : 'Unknown' }}
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

        <!-- Carousel Indicators (dots) -->
        
    </div>
    <div class="carousel-indicators">
            @foreach ($chunkedFeedbacks as $index => $feedbackChunk)
                <button type="button" data-bs-target="#feedbackCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
</div>


</div>

</div>


    <!-- Feedbacks container -->
   
</div>

@endsection
