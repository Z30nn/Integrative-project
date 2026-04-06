<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="/css/viewb.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-dark text-white">

    <div class="container mt-5">
        <!-- Booking Details -->
        @if($guest->booking_id != 404)
        <div class="booking-details mb-5">
            <h2 class="text-center text-warning">Booking Details</h2>
            <hr style="border-color: #BFA75D;">
            <ul class="list-unstyled">
                <li><strong>Room Type:</strong> {{ $guest->booked_rooms }}</li>
                <li><strong>Booking Reference Number:</strong> {{ $guest->booking_id }}</li>
                <li><strong>Guest Name:</strong> {{ $guest->firstname }} {{ $guest->lastname }}</li>
                <li><strong>Check-in:</strong> {{ $guest->check_in }}</li>
                <li><strong>Check-out:</strong> {{ $guest->check_out }}</li>
            </ul>
        </div>

        <!-- Stay Progress -->
        @php
        $checkInDate = \Carbon\Carbon::parse($guest->check_in);
        $checkOutDate = \Carbon\Carbon::parse($guest->check_out);
        $totalDays = $checkInDate->diffInDays($checkOutDate);
        $daysStayed = floor($checkInDate->diffInDays(now()));
            if ($daysStayed < 0) {
                $daysStayed = 0;
            } else {
                $daysStayed = $daysStayed;
            }
        $remainingDays = max(0, $totalDays - $daysStayed);
        @endphp

        <div class="stay-progress mb-5">
            <h2 class="text-center text-warning">Stay Progress</h2>
            <hr style="border-color: #BFA75D;">
            <ul class="list-unstyled">
                <li><strong>Days Stayed:</strong> {{ $daysStayed }}</li>
                <li><strong>Stay Status:</strong> {{ $checkOutDate > now() ? 'Ongoing' : 'Completed' }}</li>
                <li><strong>Remaining Days:</strong> {{ $remainingDays }}</li>
            </ul>
        </div>

        <!-- Billing and Payment -->
        <div class="billing-payment mb-5">
            <h2 class="text-center text-warning">Billing and Payment</h2>
            <hr style="border-color: #BFA75D;">
            <ul class="list-unstyled">
                <li><strong>Total Cost:</strong> Php {{ number_format($guest->price_total, 2) }}</li>
                <li><strong>Paid Amount:</strong> Php {{ number_format($guest->price_total, 2) }}</li>
            </ul>
        </div>

        <!-- Service Feedback Section -->

        <div class="services mb-5">
    <h2 class="text-center text-primary mb-4">Avail Our Services for a Better Experience</h2>

    <!-- Check if user is a guest -->

    <div class="container mt-5">
        <div class="card shadow-sm p-4" style="background-color: #2c3e50; border-radius: 15px;">
            <h2 class="mb-4 text-warning">Select Service</h2>

            <!-- Service Form -->
            <form action="{{ route('services.submit') }}" method="POST">
                @csrf

                <!-- Hidden fields -->
                <input type="hidden" name="booking_id" value="{{ $guest->booking_id }}">
                <input type="hidden" name="name" value="{{ $guest->firstname }} {{ $guest->lastname }}">

                <!-- Dropdown for services -->
                <div class="mb-3">
                    <label for="service" class="form-label text-light">Available Services:</label>
                    <select name="service_id" id="service" class="form-select" aria-label="Select a service" required>
                        <option value="" disabled selected>Select a service</option>
                        @foreach($services as $service)
                        <option value="{{ $service->service_id }}" data-price="{{ $service->price }}">
                            {{ $service->service_name }} - Php {{ number_format($service->price, 2) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Service Date -->
                <div class="mb-3">
                    <label for="service_date" class="form-label text-light">Service Date:</label>
                    <input type="date" name="service_date" id="service_date" class="form-control" required>
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label for="payment_method" class="form-label text-light">Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="over_the_counter">Over the Counter</option>
                        <option value="online_payment">Online Payment</option>
                    </select>
                </div>

                <!-- Total Price -->
                <div class="mb-3">
                    <label for="total_price" class="form-label text-light">Total Price (Php):</label>
                    <input type="number" name="total_price" id="total_price" class="form-control" required readonly>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Availed Services Table -->
    <div class="container mt-5">
        <h2 class="text-warning text-center mb-4">Availed Services</h2>

        <!-- Table for displaying availed services -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered" style="background-color: #34495e; color: #ecf0f1;">
                <thead class="table-dark">
                    <tr>
                        <th>Service Name</th>
                        <th>Service Date</th>
                        <th>Payment Method</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guest->services as $service)
                    <tr>
                        <td>{{ $service->service->service_name ?? 'Service not found' }}</td>
                        <td>{{ $service->service_date }}</td>
                        <td class="text-center">
                            <span class="badge {{ $service->payment_status == 'pending' ? 'bg-warning' : 'bg-success' }} text-white">
                                {{ ucfirst($service->payment_status) }}
                            </span>
                        </td>
                        <td>Php {{ number_format($service->total_price, 2) }}</td>
                        <td>
                            <form action="{{ route('service.destroy', $service->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-dark">No services availed.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



        <!-- Stay Experience Feedback Form -->
        <div class="stay-experience mb-5">
            <h2 class="text-center text-warning">Stay Experience</h2>
            <p class="text-center">Your feedback is valuable to us! Please share your thoughts and suggestions to help improve your experience with Laraveil Suites.</p>

            <form action="{{ route('feedback.store') }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <textarea name="feedback" class="form-control" rows="5" placeholder="Describe your experience..."></textarea>
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <div class="form-check me-4">
                        <input type="radio" name="anonymous" value="1" id="submit-anonymous" checked class="form-check-input">
                        <label for="submit-anonymous" class="form-check-label">Submit Anonymously</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="anonymous" value="0" id="show-my-name" class="form-check-input">
                        <label for="show-my-name" class="form-check-label">Show My Name</label>
                    </div>
                </div>

                <div class="rating">
            <h2 class="rating-title">Rate your experience!</h2>
            <div class="stars">
                <input type="radio" name="rating" value="5" id="star5">
                <label for="star5" class="star-label">&#9733;</label>

                <input type="radio" name="rating" value="4" id="star4">
                <label for="star4" class="star-label">&#9733;</label>

                <input type="radio" name="rating" value="3" id="star3">
                <label for="star3" class="star-label">&#9733;</label>

                <input type="radio" name="rating" value="2" id="star2">
                <label for="star2" class="star-label">&#9733;</label>

                <input type="radio" name="rating" value="1" id="star1">
                <label for="star1" class="star-label">&#9733;</label>
            </div>
        </div>
                <input type="hidden" name="guest_id" value="{{ $guest->id }}">
                <button type="submit" class="btn btn-success w-100">Submit</button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
    @csrf
    <button type="submit" class="nav-link btn btn-link p-2" style="color: red; text-decoration: none; border: solid red 1px;">
      <i class="bi bi-box-arrow-right"></i> Logout
    </button>
  </form>
        </div>
    </div>

    <script>
        const stars = document.querySelectorAll('.rating input');
        stars.forEach(star => {
            star.addEventListener('change', () => {
                const ratingValue = star.id.replace('star', '');
            });
        });

        document.getElementById("service_date").value = new Date().toISOString().split('T')[0];

        // Get the service select element
        const serviceSelect = document.getElementById('service');

        // Get the total price input field
        const totalPriceInput = document.getElementById('total_price');

        // Update total price when a service is selected
        serviceSelect.addEventListener('change', function() {
            // Get the selected option's data-price attribute
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');

            // Set the total price field with the service price
            totalPriceInput.value = price;
        });
    </script>
@else($guest->booking_id == 404)
    <p class="text-center text-warning">You have no active bookings or your stay has already concluded.</p>
@endif
</body>

</html>