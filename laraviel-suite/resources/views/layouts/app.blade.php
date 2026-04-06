<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'LARAVEIL SUITES') | Luxury Refined</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Kanit:wght@300;400;500;600;700&family=Karla:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Frameworks -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom Luxury CSS -->
    <link href="{{ asset('css/luxury.css') }}" rel="stylesheet">
    
    @yield('custom-css')
</head>

<body>
    <!-- Premium Navigation -->
    <div class="navbar-wrapper">
        <div class="container-fluid px-lg-5">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid position-relative">
                    <!-- Left Nav -->
                    <div class="collapse navbar-collapse w-100" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('accommodation') ? 'active' : '' }}" href="/accommodation">Accommodation</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Center Branding -->
                    <a class="navbar-brand-center text-center d-flex flex-column align-items-center text-decoration-none" href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="logo" class="logo mb-1" style="height: 48px;">
                        <h1 class="brand-text-main text-white">LARAVEIL</h1>
                        <span class="brand-text-sub">SUITES</span>
                    </a>

                    <!-- Right Nav & Buttons -->
                    <div class="collapse navbar-collapse w-100">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('offers') ? 'active' : '' }}" href="/offers">Offers</a>
                            </li>
                            <li class="nav-item pe-lg-4">
                                <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="/about">About</a>
                            </li>
                            <li class="nav-item">
                                @if (auth()->check())
                                    @php $role = auth()->user()->role; @endphp
                                    <a class="btn-luxury" href="{{ route($role == 'admin' ? 'admin' : ($role == 'cashier' ? 'cashier' : 'view-booking')) }}">
                                        Portal
                                    </a>
                                @else
                                    <a class="btn-luxury" href="/login">Login</a>
                                @endif
                            </li>
                            <li class="nav-item ps-3 d-none d-lg-block">
                                <a class="btn btn-premium-solid px-4" href="/book-now">Book Now</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Mobile Toggle -->
                    <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                        <i class="bi bi-list fs-2"></i>
                    </button>
                </div>
            </nav>
        </div>
    </div>

    <!-- Mobile Menu Collapse -->
    <div class="collapse bg-dark position-fixed w-100" id="mobileNav" style="z-index: 999; top: 80px;">
        <div class="p-4 text-center">
            <a class="nav-link text-white py-3 d-block border-bottom" href="/">Home</a>
            <a class="nav-link text-white py-3 d-block border-bottom" href="/accommodation">Accommodation</a>
            <a class="nav-link text-white py-3 d-block border-bottom" href="/offers">Offers</a>
            <a class="nav-link text-white py-3 d-block border-bottom" href="/about">About</a>
            <a class="btn-luxury mt-4 w-100" href="/book-now">Book Now</a>
        </div>
    </div>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Premium Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <!-- Brand Info -->
                <div class="col-lg-4 text-center text-lg-start">
                    <img src="{{ asset('images/logo.png') }}" alt="LARAVEIL SUITES">
                    <p class="text-cream opacity-75 pe-lg-5">Experience unparalleled sophistication at the heart of the city. LARAVEIL SUITES is where timeless elegance meets modern luxury living.</p>
                    <div class="social-icons mt-4">
                        <i class="bi bi-facebook"></i>
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-twitter-x"></i>
                        <i class="bi bi-youtube"></i>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-2 text-center text-lg-start">
                    <h4>Direct</h4>
                    <ul class="list-unstyled">
                        <li class="mb-3 text-cream opacity-75"><i class="bi bi-geo-alt me-2"></i> Fort Bonifacio, Taguig</li>
                        <li class="mb-3 text-cream opacity-75"><i class="bi bi-telephone me-2"></i> +63 987 636 4381</li>
                        <li class="mb-3 text-cream opacity-75"><i class="bi bi-envelope me-2"></i> info@laraveil.com</li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-3 text-center text-lg-start">
                    <h4>Destinations</h4>
                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="/accommodation" class="footer-link">Suites</a></li>
                                <li class="mb-2"><a href="/offers" class="footer-link">Curated Offers</a></li>
                                <li class="mb-2"><a href="/about" class="footer-link">Our Story</a></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="/book-now" class="footer-link">Reservations</a></li>
                                <li class="mb-2"><a href="/login" class="footer-link">Staff Login</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Legal -->
                <div class="col-lg-3 text-center text-lg-start">
                    <h4>Legality</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/privacy-policy" class="footer-link">Privacy Policy</a></li>
                        <li class="mb-2"><a href="/terms" class="footer-link">Terms of Service</a></li>
                    </ul>
                    <p class="small text-cream opacity-75 mt-5">© 2026 LARAVEIL SUITES. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    
    <script>
        // AOS Animation Engine
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-cubic'
        });

        // Sticky Navbar logic
        window.addEventListener("scroll", function() {
            const navbar = document.querySelector(".navbar-wrapper");
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('custom-js')
</body>
</html>