@extends('layouts.app')

@section('title', 'Welcome to Elegance')

@section('custom-css')
<style>
    /* ── Luxury Hero ────────────────────────── */
    .hero-home {
        height: 100vh;
        background: url('{{ asset('images/HOTELMAINPAGEPIC.jpg') }}') center/cover no-repeat;
        position: relative;
        overflow: hidden;
    }

    .hero-home::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(30,20,12,0.4), rgba(30,20,12,0.9));
    }

    .hero-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .hero-title {
        font-family: 'Kanit', sans-serif;
        font-size: 5rem;
        font-weight: 800;
        letter-spacing: 12px;
        color: var(--brand-cream);
        text-transform: uppercase;
        margin-bottom: 0;
        opacity: 0;
        transform: translateY(30px);
    }

    .hero-subtitle {
        font-family: 'Aboreto', cursive;
        font-size: 1.2rem;
        color: var(--brand-gold);
        letter-spacing: 15px;
        margin-top: 10px;
        opacity: 0;
        transform: translateY(20px);
    }

    /* ── Gallery Section ─────────────────────── */
    .gallery-section {
        background-color: var(--bg-deep);
        padding: 120px 0;
    }

    .grid-wrapper {
        display: grid;
        grid-gap: 20px;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        grid-auto-rows: 250px;
        grid-auto-flow: dense;
    }

    .grid-item {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        border: 1px solid var(--border-subtle);
        cursor: pointer;
    }

    .grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .grid-item:hover img {
        transform: scale(1.15);
    }

    .grid-item.wide { grid-column: span 2; }
    .grid-item.tall { grid-row: span 2; }

    .grid-overlay {
        position: absolute;
        bottom: 0; left: 0; width: 100%;
        background: linear-gradient(transparent, rgba(30,20,12,0.9));
        padding: 30px;
        transform: translateY(100%);
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .grid-item:hover .grid-overlay {
        transform: translateY(0);
    }

    /* ── Client Feedbacks ────────────────────── */
    .feedback-section {
        background: var(--bg-warm);
        padding: 120px 0;
    }

    .feedback-card {
        background: rgba(30, 20, 12, 0.4);
        border: 1px solid var(--border-gold);
        border-radius: 24px;
        padding: 40px;
        transition: var(--transition-premium);
        margin: 15px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .feedback-card:hover {
        background: rgba(191,167, 93, 0.05);
        border-color: var(--brand-gold);
    }

    .feedback-text {
        font-size: 1.1rem;
        font-style: italic;
        color: var(--brand-cream);
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .feedback-author {
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .author-initial {
        width: 45px; height: 45px;
        background: var(--brand-gold);
        color: var(--bg-deep);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .stars-display {
        color: var(--brand-gold);
        font-size: 0.9rem;
        margin-bottom: 5px;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-home">
    <div class="hero-content">
        <h1 class="hero-title animate-reveal">EXPERIENCE</h1>
        <div class="hero-subtitle animate-reveal-sub">THE ART OF LIVING</div>
        <div class="mt-5" data-aos="fade-up" data-aos-delay="800">
            <a href="/book-now" class="btn-premium-solid px-5 py-3">Begin Your Stay</a>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="container py-5 my-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6" data-aos="fade-right">
            <h5 class="brand-text-sub text-gold mb-3">Our Sanctuary</h5>
            <h2 class="display-5 fw-bold mb-4">A Legacy of refined sophistication</h2>
            <p class="lead text-cream opacity-75">Nestled in the heart of the city, LARAVEIL SUITES is more than a destination—it's a sanctuary where modern innovation harmonizes with timeless heritage.</p>
            <p class="text-cream opacity-75">From our meticulously curated gallery to our world-class dining, every detail of your stay is orchestrated to provide a seamless transition from the pulse of the city to a state of absolute serenity.</p>
            <div class="mt-4">
                <a href="/about" class="btn-luxury">Explore Our Story</a>
            </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <div class="position-relative">
                <img src="{{ asset('images/homepage about us pic.png') }}" alt="About" class="img-fluid rounded-4 shadow-lg">
                <div class="position-absolute bottom-0 start-0 p-4 w-100 bg-gradient-dark rounded-bottom-4">
                    <p class="mb-0 small aboreto text-gold">Est. 2024</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section class="gallery-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Curated Gallery</h2>
        <div class="grid-wrapper">
            <div class="grid-item wide" data-aos="zoom-in">
                <img src="{{ asset('images/homepage gallery pool.png') }}" alt="Pool">
                <div class="grid-overlay"><span class="aboreto text-white">Azure Infinity Pool</span></div>
            </div>
            <div class="grid-item tall" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{ asset('images/pexels-valeriya-1860197.jpg') }}" alt="Room">
                <div class="grid-overlay"><span class="aboreto text-white">Living Quarters</span></div>
            </div>
            <div class="grid-item" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{ asset('images/homepage gallery food.png') }}" alt="Food">
                <div class="grid-overlay"><span class="aboreto text-white">Culinary Arts</span></div>
            </div>
            <div class="grid-item" data-aos="zoom-in" data-aos-delay="300">
                <img src="{{ asset('images/homepage gallery privacy.png') }}" alt="Privacy">
                <div class="grid-overlay"><span class="aboreto text-white">Secluded Lounge</span></div>
            </div>
            <div class="grid-item wide" data-aos="zoom-in" data-aos-delay="400">
                <img src="{{ asset('images/food.jpg') }}" alt="Gourmet">
                <div class="grid-overlay"><span class="aboreto text-white">The Signature Dining</span></div>
            </div>
            <div class="grid-item" data-aos="zoom-in" data-aos-delay="500">
                <img src="{{ asset('images/balcony.png') }}" alt="Balcony">
                <div class="grid-overlay"><span class="aboreto text-white">Horizon Balcony</span></div>
            </div>
            <div class="grid-item" data-aos="zoom-in" data-aos-delay="600">
                <img src="{{ asset('images/homepage gallery casino.jpg') }}" alt="Casino">
                <div class="grid-overlay"><span class="aboreto text-white">Royal Casino</span></div>
            </div>
            <div class="grid-item" data-aos="zoom-in" data-aos-delay="700">
                <img src="{{ asset('images/homepage gallery gym.jpg') }}" alt="Gym">
                <div class="grid-overlay"><span class="aboreto text-white">Imperial Fitness</span></div>
            </div>
            <div class="grid-item" data-aos="zoom-in" data-aos-delay="800">
                <img src="{{ asset('images/homepage gallery coffeeshop.jpg') }}" alt="Coffee Shop">
                <div class="grid-overlay"><span class="aboreto text-white">Café Sanctuary</span></div>
            </div>
        </div>
    </div>
</section>

<!-- Client Testimonials -->
<section class="feedback-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Guest Sentiment</h2>
        <div id="feedbackCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @php $chunkedFeedbacks = array_chunk($feedbacks->toArray(), 3); @endphp
                @foreach ($chunkedFeedbacks as $index => $feedbackChunk)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row g-4">
                            @foreach ($feedbackChunk as $feedback)
                                <div class="col-md-4">
                                    <div class="feedback-card" data-aos="fade-up">
                                        <div class="stars-display">
                                            @for ($i = 0; $i < $feedback['rating']; $i++) <i class="bi bi-star-fill"></i> @endfor
                                        </div>
                                        <p class="feedback-text">"{{ $feedback['feedback'] }}"</p>
                                        <div class="feedback-author">
                                            @php 
                                                $name = $feedback['anonymous'] ? 'Anonymous' : (\App\Models\Guest::find($feedback['guest_id'])->lastname ?? 'Guest');
                                                $initial = substr($name, 0, 1);
                                            @endphp
                                            <div class="author-initial">{{ $initial }}</div>
                                            <div>
                                                <div class="fw-bold">{{ $name }}</div>
                                                <div class="small text-muted">Verified Resident</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Hero Reveal Animations
        anime.timeline({
            easing: 'easeOutExpo',
        })
        .add({
            targets: '.hero-title',
            translateY: [30, 0],
            opacity: [0, 1],
            duration: 2000,
            delay: 500
        })
        .add({
            targets: '.hero-subtitle',
            translateY: [20, 0],
            opacity: [0, 1],
            duration: 1500,
        }, '-=1000');
    });
</script>
@endsection
