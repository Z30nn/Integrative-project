@extends('layouts.app')

@section('title', 'Our Story')

@section('custom-css')
<style>
    .about-hero {
        height: 70vh;
        background: linear-gradient(rgba(30, 20, 12, 0.6), rgba(30, 20, 12, 0.6)), url('{{ asset('images/pexels-valeriya-1860197.jpg') }}') center/cover fixed no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .story-section {
        background-color: var(--bg-deep);
        padding: 120px 0;
    }

    .editorial-image-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-gap: 20px;
    }

    .grid-img-1 { grid-column: 1 / 8; grid-row: 1 / 10; border-radius: 30px; }
    .grid-img-2 { grid-column: 7 / 13; grid-row: 6 / 15; border-radius: 30px; border: 10px solid var(--bg-deep); z-index: 1; }

    .brand-letter {
        font-family: 'Aboreto', cursive;
        font-size: 4rem;
        color: var(--brand-gold);
        line-height: 1;
        float: left;
        margin-right: 15px;
        margin-top: 5px;
    }

    .value-card {
        background: var(--glass-dark);
        border: 1px solid var(--border-subtle);
        padding: 40px;
        border-radius: 24px;
        height: 100%;
        transition: var(--transition-premium);
    }

    .value-card:hover {
        border-color: var(--brand-gold);
        transform: translateY(-10px);
    }

    .value-icon {
        font-size: 2.5rem;
        color: var(--brand-gold);
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<!-- About Hero -->
<section class="about-hero">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="display-3 aboreto text-white animate-reveal">THE ESSENCE OF LARAVEIL</h1>
        <div class="hero-subtitle text-gold">CRAFTING TIMELESS EXPERIENCES</div>
    </div>
</section>

<!-- The Vision -->
<section class="story-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="editorial-image-grid" data-aos="fade-right">
                    <img src="{{ asset('images/HOTELMAINPAGEPIC.jpg') }}" alt="Legacy" class="img-fluid grid-img-1 shadow-lg">
                    <img src="{{ asset('images/homepage gallery privacy.png') }}" alt="Experience" class="img-fluid grid-img-2 shadow-lg">
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                <h5 class="brand-text-sub text-gold mb-3">Our Legacy</h5>
                <h2 class="display-5 fw-bold mb-4">A Sanctuary of Modern Sophistication</h2>
                <p class="lead text-cream"><span class="brand-letter">L</span>araveil Suites represents the pinnacle of urban luxury. Our journey began with a singular vision: to create a space where the world's most discerning travelers could find absolute tranquility without losing the pulse of the city.</p>
                <p class="text-cream opacity-75">Every arch, every fabric, and every interaction at LARAVEIL is designed to evoke a sense of home—refined, elevated, and deeply personal. We believe that true luxury is not just found in opulent surroundings, but in the seamless anticipation of your every need.</p>
                <div class="mt-5 border-start border-gold ps-4 py-2">
                    <h4 class="aboreto text-gold mb-1">Vincent Paul</h4>
                    <p class="small text-cream opacity-50 mb-0">Founding Architect & Visionary</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-5 bg-warm border-top border-bottom border-gold border-opacity-10">
    <div class="container py-5">
        <div class="row mb-5 text-center">
            <div class="col-12" data-aos="fade-up">
                <h2 class="section-title">The Foundation</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-gem"></i></div>
                    <h4 class="aboreto text-white mb-3">Pristine Quality</h4>
                    <p class="text-cream opacity-75">From Egyptian cotton linens to bespoke gourmet experiences, we never compromise on the standards of our materials or service.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-clock-history"></i></div>
                    <h4 class="aboreto text-white mb-3">Timelessness</h4>
                    <p class="text-cream opacity-75">We blend classical design principles with cutting-edge technology to ensure our suites remain modern yet eternally elegant.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-stars"></i></div>
                    <h4 class="aboreto text-white mb-3">Discrete Service</h4>
                    <p class="text-cream opacity-75">Intuitive hospitality that anticipates your desires while respecting your absolute privacy and sanctuary.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection