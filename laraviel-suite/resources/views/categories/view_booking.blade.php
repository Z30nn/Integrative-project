@extends('layouts.app')

@section('title', 'Guest Portal')

@section('custom-css')
<style>
    .portal-wrapper {
        min-height: 100vh;
        background: linear-gradient(rgba(30, 20, 12, 0.8), rgba(30, 20, 12, 0.9)), url('{{ asset('images/pexels-valeriya-1860197.jpg') }}') center/cover fixed no-repeat;
        padding: 150px 0 100px;
    }

    .portal-card {
        background: var(--glass-dark);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--border-gold);
        border-radius: 30px;
        padding: 40px;
        height: 100%;
    }

    .portal-header {
        border-bottom: 1px solid var(--border-gold);
        padding-bottom: 30px;
        margin-bottom: 40px;
    }

    .portal-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--brand-gold);
        display: block;
        margin-bottom: 5px;
    }

    .portal-value {
        font-family: 'Kanit', sans-serif;
        font-size: 1.1rem;
        color: var(--brand-cream);
    }

    /* ── Progress Bar ────────────────────────── */
    .progress-minimal {
        height: 4px;
        background: rgba(254, 243, 226, 0.1);
        border-radius: 10px;
        overflow: hidden;
        margin-top: 15px;
    }

    .progress-bar-gold {
        background: var(--brand-gold);
        height: 100%;
        box-shadow: 0 0 10px var(--brand-gold);
    }

    /* ── Service Form ────────────────────────── */
    .service-select {
        background: rgba(254, 243, 226, 0.05);
        border: 1px solid var(--border-subtle);
        color: var(--brand-cream);
        border-radius: 12px;
        padding: 12px;
    }

    /* ── Rating Stars ────────────────────────── */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 10px;
    }

    .star-rating input { display: none; }
    .star-rating label {
        font-size: 2rem;
        color: rgba(254, 243, 226, 0.2);
        cursor: pointer;
        transition: color 0.3s;
    }

    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: var(--brand-gold);
        text-shadow: 0 0 10px rgba(191, 167, 93, 0.4);
    }
</style>
@endsection

@section('content')
<section class="portal-wrapper">
    <div class="container">
        @if($guest->booking_id != 404)
        <!-- Portal Header -->
        <div class="portal-header d-flex justify-content-between align-items-end" data-aos="fade-down">
            <div>
                <h5 class="brand-text-sub text-gold mb-2">Welcome Back</h5>
                <h1 class="aboreto text-white h2 mb-0">{{ $guest->firstname }} {{ $guest->lastname }}</h1>
            </div>
            <div class="text-end">
                <span class="portal-label">Reference</span>
                <span class="text-gold fw-bold">#{{ $guest->booking_id }}</span>
            </div>
        </div>

        <div class="row g-4">
            <!-- Stay Details -->
            <div class="col-lg-4" data-aos="fade-up">
                <div class="portal-card">
                    <h4 class="aboreto text-gold mb-4 h6">Sanctuary Details</h4>
                    <div class="mb-4">
                        <span class="portal-label">Accommodations</span>
                        <p class="portal-value">{{ $guest->booked_rooms }}</p>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <span class="portal-label">Arrival</span>
                            <p class="portal-value">{{ $guest->check_in }}</p>
                        </div>
                        <div class="col-6">
                            <span class="portal-label">Departure</span>
                            <p class="portal-value">{{ $guest->check_out }}</p>
                        </div>
                    </div>
                    <div>
                        <span class="portal-label">Investment Total</span>
                        <p class="portal-value text-gold h4">₱{{ number_format($guest->price_total, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Stay Progress -->
            @php
                $checkInDate = \Carbon\Carbon::parse($guest->check_in);
                $checkOutDate = \Carbon\Carbon::parse($guest->check_out);
                $totalDays = max(1, $checkInDate->diffInDays($checkOutDate));
                $daysStayed = floor(max(0, $checkInDate->diffInDays(now())));
                $percentage = min(100, ($daysStayed / $totalDays) * 100);
            @endphp
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="portal-card text-center">
                    <h4 class="aboreto text-gold mb-5 h6">Stay Progress</h4>
                    <div class="position-relative d-inline-block mb-4">
                        <h2 class="display-3 fw-bold text-white mb-0">{{ $daysStayed }}</h2>
                        <span class="portal-label">Days Stayed</span>
                    </div>
                    <div class="px-4">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Arrival</span>
                            <span>Departure</span>
                        </div>
                        <div class="progress-minimal">
                            <div class="progress-bar-gold" style="width: {{ $percentage }}%"></div>
                        </div>
                        <p class="small text-gold mt-3 aboreto">{{ $checkOutDate > now() ? 'Stay in Progress' : 'Residency Completed' }}</p>
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="portal-card">
                    <h4 class="aboreto text-gold mb-4 h6">Enhanced Services</h4>
                    <form action="{{ route('services.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $guest->booking_id }}">
                        <input type="hidden" name="name" value="{{ $guest->firstname }} {{ $guest->lastname }}">
                        
                        <div class="mb-3">
                            <label class="portal-label">Available Rituals</label>
                            <select name="service_id" id="service" class="luxury-input py-2" required>
                                <option value="" disabled selected>Select a service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->service_id }}" data-price="{{ $service->price }}">
                                    {{ $service->service_name }} (₱{{ number_format($service->price, 2) }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="portal-label">Preferred Date</label>
                                <input type="date" name="service_date" id="service_date" class="luxury-input py-2" required>
                            </div>
                            <div class="col-6">
                                <label class="portal-label">Payment Mode</label>
                                <select name="payment_method" class="luxury-input py-2" required>
                                    <option value="over_the_counter">On Arrival</option>
                                    <option value="online_payment">Digital</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="total_price" id="total_price">
                        <button type="submit" class="btn-premium-solid w-100 mt-3">Request Service</button>
                    </form>
                </div>
            </div>

            <!-- Availed Services Table -->
            <div class="col-12" data-aos="fade-up">
                <div class="portal-card">
                    <h4 class="aboreto text-gold mb-4 h6">Your Curated Selections</h4>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover border-0">
                            <thead class="text-gold small uppercase">
                                <tr>
                                    <th class="border-0">Service</th>
                                    <th class="border-0">Scheduled</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0 text-end">Investment</th>
                                </tr>
                            </thead>
                            <tbody class="text-muted small">
                                @forelse ($guest->services as $service)
                                <tr>
                                    <td class="border-0 text-cream">{{ $service->service->service_name ?? 'Service' }}</td>
                                    <td class="border-0">{{ $service->service_date }}</td>
                                    <td class="border-0">
                                        <span class="badge rounded-pill {{ $service->payment_status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                                            {{ ucfirst($service->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="border-0 text-end text-cream">₱{{ number_format($service->total_price, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 border-0">No additional services requested.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Feedback -->
            <div class="col-lg-8" data-aos="fade-up">
                <div class="portal-card">
                    <h4 class="aboreto text-gold mb-4 h6">Guest Sentiment</h4>
                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="guest_id" value="{{ $guest->id }}">
                        
                        <div class="star-rating mb-4">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                <label for="star{{ $i }}"><i class="bi bi-star-fill"></i></label>
                            @endfor
                        </div>

                        <textarea name="feedback" class="luxury-input" rows="4" placeholder="Share your experience at Laraveil..."></textarea>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check form-switch opacity-75">
                                <input class="form-check-input" type="checkbox" name="anonymous" value="1" id="anonSwitch" checked>
                                <label class="form-check-label small text-muted" for="anonSwitch">Submit Anonymously</label>
                            </div>
                            <button type="submit" class="btn-luxury px-5">Submit Feedback</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Logout/portal controls -->
            <div class="col-lg-4" data-aos="fade-up">
                <div class="portal-card d-flex flex-column justify-content-center align-items-center text-center">
                    <p class="text-muted small mb-4">Need to conclude your portal session?</p>
                    <form method="POST" action="{{ route('logout') }}" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2">
                             Secure Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="py-5 text-center" data-aos="zoom-in">
            <h1 class="aboreto text-gold">SANCTUARY NOT FOUND</h1>
            <p class="text-muted">You have no active bookings or your stay has already concluded.</p>
            <a href="/" class="btn-premium-solid mt-4">Return Home</a>
        </div>
        @endif
    </div>
</section>
@endsection

@section('custom-js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const serviceSelect = document.getElementById('service');
        const totalPriceInput = document.getElementById('total_price');
        
        if(serviceSelect) {
            serviceSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                totalPriceInput.value = selectedOption.getAttribute('data-price');
            });
        }
    });
</script>
@endsection