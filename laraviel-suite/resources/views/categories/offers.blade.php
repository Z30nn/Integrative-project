@extends('layouts.app')

@section('title', 'Exclusive Offers')

@section('custom-css')
<style>
    .offers-hero {
        height: 60vh;
        background: linear-gradient(rgba(30, 20, 12, 0.7), rgba(30, 20, 12, 0.7)), url('{{ asset('images/homepage gallery pool.png') }}') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .offer-card {
        background: var(--glass-dark);
        border: 1px solid var(--border-gold);
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 40px;
        transition: var(--transition-premium);
        display: flex;
        flex-direction: row;
        height: 480px;
    }

    @media (max-width: 991px) {
        .offer-card { flex-direction: column; height: auto; }
        .offer-image { width: 100% !important; height: 300px; }
    }

    .offer-image {
        width: 50%;
        position: relative;
        overflow: hidden;
    }

    .offer-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s ease;
    }

    .offer-card:hover .offer-image img {
        transform: scale(1.1);
    }

    .offer-body {
        width: 50%;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    @media (max-width: 991px) { .offer-body { width: 100%; padding: 40px; } }

    .offer-tag {
        color: var(--brand-gold);
        font-family: 'Aboreto', cursive;
        letter-spacing: 4px;
        font-size: 0.8rem;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .offer-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--brand-cream);
    }

    .offer-description {
        color: var(--text-muted);
        line-height: 1.8;
        margin-bottom: 35px;
    }

    .benefit-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 40px;
    }

    .benefit-item {
        margin-bottom: 12px;
        color: var(--brand-cream);
        display: flex;
        align-items: center;
        font-size: 0.95rem;
    }

    .benefit-item i {
        color: var(--brand-gold);
        margin-right: 15px;
    }
</style>
@endsection

@section('content')
<!-- Offers Hero -->
<section class="offers-hero">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="display-3 aboreto text-white">THE CURATED COLLECTION</h1>
        <div class="hero-subtitle text-gold">UNRIVALED PRIVILEGES AWAIT</div>
    </div>
</section>

<!-- Offers List -->
<section class="py-5 my-5">
    <div class="container py-5">
        
        <!-- Offer 1: Season Sanctuary -->
        <div class="offer-card" data-aos="fade-up">
            <div class="offer-image">
                <img src="{{ asset('images/HOTELMAINPAGEPIC.jpg') }}" alt="Seasonal Offer">
            </div>
            <div class="offer-body">
                <span class="offer-tag">Seasonal Experience</span>
                <h2 class="offer-title">Urban Escape</h2>
                <p class="offer-description">Experience the best of LARAVEIL with our quintessential urban sanctuary package. Perfect for weekend getaways or mid-week restoration sessions.</p>
                <ul class="benefit-list">
                    <li class="benefit-item"><i class="bi bi-star"></i> Guaranteed Early Check-in & Late Departure</li>
                    <li class="benefit-item"><i class="bi bi-star"></i> Curated Breakfast for Two in our Signature Garden</li>
                    <li class="benefit-item"><i class="bi bi-star"></i> 20% Privilege on Spa & Wellness Rituals</li>
                </ul>
                <div>
                    <a href="/book-now" class="btn-premium-solid px-4 py-2">Reserve Now</a>
                </div>
            </div>
        </div>

        <!-- Offer 2: Culinary Arts -->
        <div class="offer-card flex-lg-row-reverse" data-aos="fade-up" data-aos-delay="200">
            <div class="offer-image">
                <img src="{{ asset('images/homepage gallery food.png') }}" alt="Culinary Offer">
            </div>
            <div class="offer-body">
                <span class="offer-tag">Culinary Masterpiece</span>
                <h2 class="offer-title">The Gourmet Stay</h2>
                <p class="offer-description">A sensory journey through the finest flavors of our region. Dedicated to the passionate epicurean traveler seeking artistic gastronomic refinement.</p>
                <ul class="benefit-list">
                    <li class="benefit-item"><i class="bi bi-star"></i> 5-Course Chef's Tasting Menu Dinner</li>
                    <li class="benefit-item"><i class="bi bi-star"></i> Private Wine Pairing with our Resident Sommelier</li>
                    <li class="benefit-item"><i class="bi bi-star"></i> Signature Culinary Welcome Amenity</li>
                </ul>
                <div>
                    <a href="/book-now" class="btn-premium-solid px-4 py-2">Savor the Moment</a>
                </div>
            </div>
        </div>

        <!-- Offer 3: Wellness Retreat -->
        <div class="offer-card" data-aos="fade-up" data-aos-delay="300">
            <div class="offer-image">
                <img src="{{ asset('images/homepage gallery privacy.png') }}" alt="Wellness">
            </div>
            <div class="offer-body">
                <span class="offer-tag">Serenity Rituals</span>
                <h2 class="offer-title">Zen Suite Haven</h2>
                <p class="offer-description">Dedicated to absolute restoration of mind, body, and spirit. Transform your suite into a personal spa with our signature wellness immersion.</p>
                <ul class="benefit-list">
                    <li class="benefit-item"><i class="bi bi-star"></i> In-Suite Aromatherapy Concierge</li>
                    <li class="benefit-item"><i class="bi bi-star"></i> Guided Morning Meditation by the Azure Pool</li>
                    <li class="benefit-item"><i class="bi bi-star"></i> Personalized Wellness Nutritional Plan</li>
                </ul>
                <div>
                    <a href="/book-now" class="btn-premium-solid px-4 py-2">Reclaim Vitality</a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection