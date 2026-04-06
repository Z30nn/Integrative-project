<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cashier Dashboard</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #FFFFFF;
            color: #442E1A;
            font-family: 'Karla', sans-serif;
        }

        .table {
            background-color: #FFFFFF;
            color: #442E1A;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-dark {
            background-color: #442E1A;
            color: #FEF3E2;
        }

        .table td,
        .table th {
            border-color: rgba(68, 46, 26, 0.3);
            vertical-align: middle;
        }



        .btn-danger {
            background-color: #dc3545;
            border: none;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .btn-danger i {
            margin-right: 8px;
        }

        .btn-success {
            background-color: rgba(25, 135, 84, 0.8);
            border: 1px solid #FEF3E2;
            color: #FEF3E2;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .bg-warning {
            background-color: rgba(255, 176, 0, 0.8) !important;
        }

        .bg-success {
            background-color: rgba(25, 135, 84, 0.8) !important;
        }

        .rounded-pill {
            font-size: 0.9rem;
            padding: 5px 15px;
        }

        .nav-link {
            color: #FFB000 !important;
            font-family: 'Karla', sans-serif;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #FEF3E2 !important;
            transform: translateY(-2px);
        }


        .card {
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 12px;
            flex: 1;
            min-width: 250px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        form {
            margin: 0;
            padding: 0;
            line-height: 1;
        }

        .d-flex.justify-content-center.gap-2 {
            display: flex;
            justify-content: center;
            gap: 0.5rem !important;
        }

        td {
            vertical-align: middle !important;
        }

        /* Logo and title styling */
        .logo-container {
            display: flex;
            align-items: center;
        }

        h2 {
            font-weight: 600;
            color: #442E1A;
            margin-bottom: 0;
        }

        /* Ensure proper spacing in the header row */

        /* Add these responsive styles to your existing CSS */
        @media (max-width: 768px) {
            .header-row {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .logo-col,
            .title-col,
            .logout-col {
                width: 100%;
                justify-content: center;
                text-align: center;
            }

            .title-col h2 {
                font-size: 1.5rem;
                margin: 0.5rem 0;
            }

            .logout-col {
                justify-content: center !important;
            }

            .btn-danger {
                padding: 8px 20px !important;
                font-size: 16px !important;
            }
        }

        @media (max-width: 480px) {
            .title-col h2 {
                font-size: 1.2rem;
            }

            .btn-danger {
                padding: 6px 15px !important;
                font-size: 14px !important;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row px-2 header-row">
            <!-- Logo -->
            <div class="col-md-4 col-12 d-flex align-items-center logo-col">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 100px; height: auto;">
            </div>

            <!-- Title -->
            <div class="col-md-4 col-12 title-col">
                <h2 class="mb-0 text-uppercase text-center d-flex justify-content-center align-items-center"
                    style="color: #442E1A; font-family: 'Karla', sans-serif; letter-spacing: 1px; height: 100%;">
                    Transaction Overview
                </h2>
            </div>

            <!-- Logout Button -->
            <div class="col-md-4 col-12 d-flex justify-content-end align-items-center logout-col">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="padding: 10px 30px; font-size: 18px;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    
        <div class="row">
            <div class="container">
                <div class="row">
                    <!-- Search function using booking_id -->
                    <div class="col-md-6">
                        <form action="{{ url('/cashier') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" name="booking_id" class="form-control" placeholder="Search by Booking ID" value="{{ request()->input('booking_id') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ url('/cashier') }}" method="GET">
                            <div class="d-flex align-items-center mb-3">
                                <!-- Payment Status Filters -->
                                <div class="form-check form-check-inline me-3">
                                    <input class="form-check-input" type="radio" name="payment_status" id="pending" value="pending" {{ request()->payment_status == 'pending' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pending">Pending</label>
                                </div>
                                <div class="form-check form-check-inline me-3">
                                    <input class="form-check-input" type="radio" name="payment_status" id="paid" value="paid" {{ request()->payment_status == 'paid' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="paid">Paid</label>
                                </div>
                                <div class="form-check form-check-inline me-3">
                                    <input class="form-check-input" type="radio" name="payment_status" id="paid" value="Refunded" {{ request()->payment_status == 'Refunded' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="paid">Refunded</label>
                                </div>
                                <!-- Filter Button -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-filter"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                    <h2>Services Availed</h2>
                    <!-- Table to display services -->
                    <table class="table-responsive table border table-striped">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Service Name</th>
                                <th>Service Date</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($availed_services as $availed_service)
                            <tr class="text-center">
                                <td>{{ $availed_service->guest_name }}</td>
                                <td>{{ $availed_service->service ? $availed_service->service->service_name : 'N/A' }}</td>
                                <td>{{ $availed_service->service_date }}</td>
                                <td>{{ $availed_service->payment_method }}</td>
                                <td class="text-center">
                                    <p class="{{ $availed_service->payment_status == 'pending' ? 'bg-warning text-white' : '' }}
                                            {{ $availed_service->payment_status == 'paid' ? 'bg-success text-white' : '' }}
                                            {{ $availed_service->payment_status == 'Refunded' ? 'bg-secondary text-white' : '' }}
                                            p-2 rounded-pill">
                                        {{ $availed_service->payment_status }}
                                    </p>
                                </td>
                                <td>{{ $availed_service->total_price }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center" style="gap: 8px;">
                                        <!-- Action Buttons -->
                                        <form action="{{ route('service.destroy', $availed_service->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="width: 80px; height: 38px;">Delete</button>
                                        </form>

                                        @if($availed_service->payment_status == 'pending')
                                        <form action="{{ route('mark.as.paid', ['id' => $availed_service->id, 'booking_id' => $availed_service->booking_id]) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="btn btn-success" style="width: 80px; height: 38px;">Paid</button>
                                        </form>
                                        @elseif ($availed_service->payment_status == 'paid')
                                        <form action="{{ route('service.refund', $availed_service->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning" style="width: 80px; height: 38px;">Refund</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <!-- Message displayed when no data is found -->
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No Data Was Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $availed_services->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <div class="row">
    <div class="col-md-12">
        <!-- Table for Income Tracker -->
        <h2 class="my-4">Income Tracker</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Customer Name</th>
                        <th>Availed Services</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incomeTracker as $income)
                    <tr class="text-center">
                        <td>{{ $income->customer_name }}</td>
                        <td>{{ $income->availed_service }}</td>
                        <td>{{ $income->price }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            No Data Was Found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        {{ $incomeTracker->links('pagination::bootstrap-5') }}
    </div>
</div>

    </div>

</body>

</html>