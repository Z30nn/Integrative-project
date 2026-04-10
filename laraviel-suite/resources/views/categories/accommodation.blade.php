@extends('layouts.app')

@section('title', 'Suites & Sanctuaries')

@section('custom-css')
<style>
    .accommodation-hero {
        height: 60vh;
        background: linear-gradient(rgba(30, 20, 12, 0.7), rgba(30, 20, 12, 0.7)), url('{{ asset('images/HOTELMAINPAGEPIC.jpg') }}') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .room-grid-section {
        background-color: var(--bg-deep);
        padding: 100px 0;
    }

    /* ── Luxury Room Card ───────────────────── */
    .room-card {
        background: var(--glass-dark);
        border: 1px solid var(--border-gold);
        border-radius: 24px;
        overflow: hidden;
        transition: var(--transition-premium);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .room-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.5);
        border-color: var(--brand-gold);
    }

    .room-image-wrapper {
        position: relative;
        height: 280px;
        overflow: hidden;
    }

    .room-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .room-card:hover .room-image-wrapper img {
        transform: scale(1.1);
    }

    .room-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--brand-gold);
        color: var(--bg-deep);
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .room-content {
        padding: 30px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .room-type {
        font-family: 'Kanit', sans-serif;
        font-size: 1.5rem;
        color: var(--brand-cream);
        margin-bottom: 10px;
    }

    .room-description {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 25px;
    }

    .room-price-row {
        margin-top: auto;
        border-top: 1px solid var(--border-subtle);
        padding-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price-value {
        color: var(--brand-gold);
        font-size: 1.2rem;
        font-weight: 700;
    }

    .price-label {
        font-size: 0.7rem;
        color: var(--text-muted);
        text-transform: uppercase;
        display: block;
    }

    /* ── Modal Improvements ─────────────────── */
    .modal-content {
        background: var(--bg-warm);
        border: 1px solid var(--brand-gold);
        border-radius: 30px;
        color: var(--brand-cream);
    }

    .modal-header { border-bottom: 1px solid var(--border-subtle); }
    .modal-footer { border-top: 1px solid var(--border-subtle); }

    .amenity-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .amenity-item i {
        color: var(--brand-gold);
        font-size: 1.2rem;
        margin-right: 15px;
        width: 25px;
        text-align: center;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="accommodation-hero">
    <div class="container" data-aos="fade-up">
        <h1 class="display-3 aboreto text-white">SUITES & SANCTUARIES</h1>
        <p class="brand-text-sub text-gold">UNPARALLELED COMFORT IN EVERY DETAIL</p>
    </div>
</section>

<!-- Suites Section -->
<section class="room-grid-section">
    <div class="container">
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-12 text-center">
                <h2 class="section-title">The Collection</h2>
            </div>
        </div>

        <!-- This container is populated via AJAX in script.js -->
        <div class="row g-4 standard-room" id="roomContainer">
            <!-- Loading Spinner (Dynamic) -->
            <div class="col-12 text-center py-5" id="loader">
                <div class="spinner-border text-gold" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Modals (Redesigned) -->
@include('categories.partials.room-modals')

@endsection

@section('custom-js')
<script>
    // Custom logic for the redesigned accommodation page can go here
</script>
@endsection
