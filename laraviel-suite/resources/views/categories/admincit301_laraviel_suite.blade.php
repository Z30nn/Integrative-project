<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>admin dashboard</title>
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

  <!-- Burger Icon -->
  <div class="burger-icon" onclick="toggleSidebar()">&#9776;</div>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column" id="mySidebar" style="height: 100vh;">
    <div class="text-center">
      <img src="./images/logo.png" alt="" style="width: 100px;">
    </div>
    <div>
      <a href="#dashboard" onclick="setActive(this)">Dashboard</a>
      <a href="#customer" onclick="setActive(this)">Customer</a>
      <a href="#room-service" onclick="setActive(this)">Room Service</a>
      <a href="#calendar" onclick="setActive(this)">Calendar</a>
      <a href="#room-management" onclick="setActive(this)">Room Management</a>
      <a href="#income-tracker" onclick="setActive(this)">Income Tracker</a>
      <a href="{{ route('registeremployee') }}" class="add-employee">
        Add Employee
      </a>
      </form>
    </div>
    <footer class="mt-auto d-flex flex-column justify-content-center align-items-center text-center">
      <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="nav-link btn btn-link p-2" style="color: red; text-decoration: none; border: solid red 1px;">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>
      <p style="font-size: 12px;" class="mt-3">&copy; Laraveil Suite.</p>
    </footer>

  </div>


  <!-- Main Content -->
  <div class="content">
    <!-- Dashboard Section -->
    <section id="dashboard">
      <h1>Dashboard<br /></h1>
      <div class="dashboard-container">
        <div class="card">
          <h3>Total Customers</h3>
          <p>{{ $totalGuests }}</p>
        </div>
        <div class="card">
          <h3>Total Rooms</h3>
          <p>{{ $totalRooms }}</p>
        </div>
        <div class="card">
          <h3>Total Income</h3>
          <p>Php {{ number_format($totalGuestPayments, 2) }}</p>
        </div>
      </div>
    </section>

    <!-- Customer Section -->
    <section id="customer" class="container my-4">
      <h2 class="mb-3">Customer Information</h2>
      @if(session('guestAlert'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('guestAlert') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      <!-- Search Form -->
      <form action="{{ url('/admin') }}" method="GET" class="mb-3">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            name="search"
            placeholder="Search by last name, email, or booking ID"
            value="{{ request()->input('search') }}"
            aria-label="Search" />
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i> Search
          </button>
        </div>
      </form>

      <!-- Guests Table -->
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr class="text-center" style="font-size: 12px;">
              <th>Booking ID</th>
              <th style="width: 100px;">Last Name</th>
              <th>Contact Number</th>
              <th>Email</th>
              <th>Room</th>
              <th style="width: 100px;">Check-in</th>
              <th style="width: 100px;">Check-out</th>
              <th style="width: 150px;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($guests as $guest)
            <tr>
              <td>{{ $guest->booking_id }}</td>
              <td>{{ $guest->lastname }}</td>
              <td>{{ $guest->contact_number }}</td>
              <td>{{ $guest->email }}</td>
              <td>{{ $guest->booked_rooms }}</td>
              <td>{{ $guest->check_in }}</td>
              <td>{{ $guest->check_out }}</td>
              <td class="d-flex">
                <!-- Edit Button -->
                <button
                  type="button"
                  class="btn btn-sm btn-primary me-2 d-flex"
                  data-bs-toggle="modal"
                  data-bs-target="#editModal-{{ $guest->id }}">
                  <i class="bi bi-pencil-fill me-1"></i> Edit
                </button>

                <!-- Delete Button -->
                <form
                  action="{{ route('guest.destroy', $guest->id ?? 1) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this guest?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger d-flex">
                    <i class="bi bi-trash-fill me-1"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center">No guests found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center">
        {{ $guests->links('pagination::bootstrap-5') }}
      </div>
    </section>

    <!-- Edit Modal -->
    <!-- Edit Modal -->
    @foreach($guests as $guest)
    <div class="modal fade" id="editModal-{{ $guest->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $guest->id }}" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel-{{ $guest->id }}">Edit Guest Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('guest.update', ['id' => $guest->id, 'booking_id' => $guest->booking_id]) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="row g-3">
                <!-- Guest Details -->
                <div class="col-md-6">
                  <label for="lastname-{{ $guest->id }}" class="form-label">Last Name</label>
                  <input type="text" class="form-control" id="lastname-{{ $guest->id }}" name="lastname" value="{{ $guest->lastname }}" required>
                </div>

                <div class="col-md-6">
                  <label for="contact_number-{{ $guest->id }}" class="form-label">Contact Number</label>
                  <input type="text" class="form-control" id="contact_number-{{ $guest->id }}" name="contact_number" value="{{ $guest->contact_number }}" required>
                </div>

                <div class="col-md-6">
                  <label for="email-{{ $guest->id }}" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email-{{ $guest->id }}" name="email" value="{{ $guest->email }}" required>
                </div>

                <!-- Room Type Fields -->
                @foreach (['Standard', 'Deluxe', 'Luxury'] as $roomType)
    @foreach (['V1', 'V2', 'V3'] as $subtype)
        @php
            $key = "{$roomType} {$subtype}";
            $roomCounts = collect(explode(',', $guest->booked_rooms ?? ''))->countBy();
            $roomCount = $roomCounts[$key] ?? 0;
        @endphp
        <div class="col-md-4">
            <label for="{{ strtolower($roomType) }}-{{ strtolower($subtype) }}-{{ $guest->id }}" class="form-label">
                {{ $roomType }} {{ $subtype }}
            </label>
            <input
                type="number"
                class="form-control roomTypeGuestEdit"
                id="{{ strtolower($roomType) }}-{{ strtolower($subtype) }}-{{ $guest->id }}"
                name="{{ strtolower($roomType) }}_{{ strtolower($subtype) }}"
                value="{{ $roomCount }}"
                min="0"
                required>
        </div>
    @endforeach
@endforeach

<div class="col-md-12">
    <label class="form-label">Discount Options</label>
    <div class="btn-group" role="group" aria-label="Discount Options">
        <input 
            type="radio" 
            class="btn-check" 
            name="discount_options" 
            id="none-{{ $guest->id }}" 
            value="none" 
            {{ $guest->discount_option === 'none' ? 'checked' : '' }}
            required>
        <label class="btn btn-outline-primary" for="none-{{ $guest->id }}">None</label>

        <input 
            type="radio" 
            class="btn-check" 
            name="discount_options" 
            id="student-{{ $guest->id }}" 
            value="student" 
            {{ $guest->discount_option === 'student' ? 'checked' : '' }}
            required>
        <label class="btn btn-outline-primary" for="student-{{ $guest->id }}">Student</label>

        <input 
            type="radio" 
            class="btn-check" 
            name="discount_options" 
            id="senior-{{ $guest->id }}" 
            value="senior" 
            {{ $guest->discount_option === 'senior' ? 'checked' : '' }}
            required>
        <label class="btn btn-outline-primary" for="senior-{{ $guest->id }}">Senior</label>
    </div>
</div>
                <!-- Check-in and Check-out Dates -->
                <div class="col-md-6">
                  <label for="check_in-{{ $guest->id }}" class="form-label">Check-in Date</label>
                  <input type="date" class="form-control cin" id="check_in-{{ $guest->id }}" name="check_in" value="{{ $guest->check_in }}" required>
                </div>

                <div class="col-md-6">
                  <label for="check_out-{{ $guest->id }}" class="form-label">Check-out Date</label>
                  <input type="date" class="form-control cout" id="check_out-{{ $guest->id }}" name="check_out" value="{{ $guest->check_out }}" required>
                </div>

                <div class="col-md-12">
                  <label for="price_total-{{ $guest->id }}" class="form-label">Total Price</label>
                  <input type="text" class="form-control tprice" id="price_total-{{ $guest->id }}" name="price_total" value="{{ $guest->price_total }}">
                </div>
              </div>

              <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary">Update Guest</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach

    <section id="room-service" class="p-4 rounded-4 shadow my-2">
      <div class="container-fluid">
        <h2>Room Service</h2>
        @if (session('approved'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p class=" text-start">{{ session('approved') }}</p>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th scope="col">Service Name</th>
              <th scope="col">Available Services</th>
              <th scope="col">Description</th>
              <th scope="col">Price</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($roomServices as $roomService)
            <tr>
              <td>{{ $roomService->service_name }}</td>
              <td>{{ $roomService->availed_service }}</td>
              <td>{{ $roomService->description }}</td>
              <td>{{ $roomService->price }}</td>
              <td>
                <div class="d-flex gap-2">
                  <!-- Edit Button -->
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editRoomServiceModal-{{ $roomService->service_id }}">
                    <i class="bi bi-pencil-fill"></i> Edit
                  </button>
                  <!-- Delete Button -->
                  <form action="{{ route('service.delete', $roomService->service_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                      <i class="bi bi-trash-fill"></i> Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center">No room services available.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomServiceModal">Add Room Service</button>
      </div>
    </section>

    @foreach($roomServices as $roomService)
    <div class="modal fade" id="editRoomServiceModal-{{ $roomService->service_id }}" tabindex="-1" aria-labelledby="editRoomServiceModalLabel-{{ $roomService->service_id }}" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editRoomServiceModalLabel-{{ $roomService->service_id }}">Edit Room Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('service.update', $roomService->service_id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="mb-3">
                <label for="serviceName" class="form-label">Service Name</label>
                <input type="text" class="form-control" id="serviceName" name="service_name" value="{{ $roomService->service_name }}" required>
              </div>
              <div class="mb-3">
                <label for="availedService" class="form-label">Available Services</label>
                <input type="text" class="form-control" id="availedService" name="availed_service" value="{{ $roomService->availed_service }}" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $roomService->description }}</textarea>
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $roomService->price }}" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach


    <!--modal for add room service-->
    <div class="modal fade" id="addRoomServiceModal" tabindex="-1" aria-labelledby="addRoomServiceModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addRoomServiceModalLabel">Add Room Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('room.create') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="service_name" class="form-label">Service Name</label>
                <input type="text" class="form-control" id="service_name" name="service_name" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" required>
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
              </div>
              <div class="mb-3">
                <label for="availed_service" class="form-label">Available Services</label>
                <input type="text" class="form-control" id="availed_service" name="availed_service" required>
              </div>
              <button type="submit" class="btn btn-primary">Add Room Service</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Calendar Section -->
    <section id="calendar">
      <h1>Calendar<br /></h1>
      <div class="calendar">
        <div class="calendar-header">
          <button onclick="changeMonth(-1)">&#8592; Prev</button>
          <span id="month-year"></span>
          <button onclick="changeMonth(1)">Next &#8594;</button>
        </div>
        <div class="calendar-days" id="calendarDays"></div>
      </div>
      <div id="customerBookings" class="customer-list" style="display:none;">
        <h3>Customer Bookings for Selected Day</h3>
        <table>
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Room Number</th>
              <th>Check-out Date</th>
            </tr>
          </thead>
          <tbody id="customerBookingsTable"></tbody>
        </table>
      </div>
    </section>

    <!-- Room Management Section -->
    <section id="room-management">
      <div class="card">
        <h3>Room Management</h3>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Room List Container -->
        <div class="room-list" id="roomList">
          <div class="row">
            @foreach($rooms as $room)
            <div class="col-md-6 col-lg-4 col-sm-12 mb-4">
              <div class="room d-flex flex-column text-center" style="height: 100%; display: flex; flex-direction: column;">
                <img src="{{ $room->image_path }}" alt="Room Image" class="img-fluid mb-3">
                <h4>{{ $room->room_type }}</h4>
                <p>Description: {{ $room->description }}</p>
                <p>Price: Php {{ number_format($room->price->price ?? 0, 2) }}</p>


                <!-- Button Container -->
                <div class="mt-auto d-flex justify-content-center mt-3">
                  <form action="{{ route('room.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger me-2"><i class="bi bi-trash-fill"></i> Delete</button>
                  </form>

                  <!-- Edit Button triggers a modal -->
                  <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#editRoomModal{{ $room->id }}">
                    <i class="bi bi-pencil-fill me-2"></i>Edit
                  </button>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Add New Room Button -->
        <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoomModal">Add New Room</a>
      </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('room.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <!-- Room Type Dropdown -->
          <div class="mb-3">
            <label for="roomType" class="form-label">Room Type</label>
            <select class="form-select" id="roomType" name="room_type" required>
              <option value="Standard V1" selected>Standard v1</option>
              <option value="Standard V2">Standard v2</option>
              <option value="Standard V3">Standard v3</option>
              <option value="Deluxe V1">Deluxe v1</option>
              <option value="Deluxe V2">Deluxe v2</option>
              <option value="Deluxe V3">Deluxe v3</option>
              <option value="Luxury V1">Luxury v1</option>
              <option value="Luxury V2">Luxury v2</option>
              <option value="Luxury V3">Luxury v3</option>
            </select>
          </div>
          <input type="text" class="form-control" id="price-id" name="priceId" readonly>
          <!-- Room Price -->
          <div class="mb-3">
            <label for="roomPrice" class="form-label">Price</label>
            <input type="number" class="form-control" id="roomPrice" name="price" readonly>
          </div>

          <!-- Room description -->
          <div class="mb-3">
            <label for="roomDescription" class="form-label">Description</label>
            <input type="text" class="form-control" id="roomDescription" name="description" required>
          </div>

          <!-- Room Image -->
          <div class="mb-3">
            <label for="roomImage" class="form-label">Room Image</label>
            <input type="file" class="form-control" id="roomImage" name="image" accept="image/*" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Room</button>
        </div>
      </form>
    </div>
  </div>
</div>

    @foreach($rooms as $room)
    <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" aria-labelledby="editRoomModalLabel{{ $room->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editRoomModalLabel{{ $room->id }}">Edit Room Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('room.update', $room->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <select class="form-select roomTypeEdit" id="roomTypeEdit" name="room_type" required>
                  <option value="Standard V1" {{$room->room_type == 'Standard V1' ? 'selected' : ''}}>Standard v1</option>
                  <option value="Standard V2" {{$room->room_type == 'Standard V2' ? 'selected' : ''}}>Standard v2</option>
                  <option value="Standard V3" {{$room->room_type == 'Standard V3' ? 'selected' : ''}}>Standard v3</option>
                  <option value="Deluxe V1" {{$room->room_type == 'Deluxe V1' ? 'selected' : ''}}>Deluxe v1</option>
                  <option value="Deluxe V2" {{$room->room_type == 'Deluxe V2' ? 'selected' : ''}}>Deluxe v2</option>
                  <option value="Deluxe V3" {{$room->room_type == 'Deluxe V3' ? 'selected' : ''}}>Deluxe v3</option>
                  <option value="Luxury V1" {{$room->room_type == 'Luxury V1' ? 'selected' : ''}}>Luxury v1</option>
                  <option value="Luxury V2" {{$room->room_type == 'Luxury V2' ? 'selected' : ''}}>Luxury v2</option>
                  <option value="Luxury V3" {{$room->room_type == 'Luxury V3' ? 'selected' : ''}}>Luxury v3</option>
              </select>

              </div>
              <input type="text" class="form-control" id="price-id" name="priceId" readonly value="{{$room->room_price_id}}">

              <div class="mb-3">
                <label for="roomDescription" class="form-label">Description</label>
                <textarea class="form-control" id="roomDescription" name="description" rows="3" required>{{ $room->description }}</textarea>
              </div>
              <div class="mb-3">
                <label for="roomPrice" class="form-label">Price</label>
                <input type="number" class="form-control" id="roomPrice" name="price" value="{{ $room->price }}" readonly>
              </div>
              <div class="mb-3">
                <label for="roomImage" class="form-label">Image</label>
                <input type="file" class="form-control" id="roomImage" name="image">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endforeach


    <div class="income-tracker container-fluid" id="income-tracker">
      <h2>Income Tracker</h2>
      <table>
        <thead>
          <tr>
            <th class="text-center">Customer Name</th>
            <th class="text-center">Availed Services</th>
            <th class="text-center">Price</th>
          </tr>
        </thead>
        <tbody id="incomeList">
          <!-- Loop through the incomeTracker data -->
          @foreach($incomeTracker as $income)
          <tr>
            <td class="text-center">{{ $income->customer_name }}</td>
            <td class="text-center">{{ $income->availed_service }}</td>
            <td class="text-center">Php {{ number_format($income->price, 2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Pagination links -->
      <div class="text-center">
        {{ $incomeTracker->links('pagination::bootstrap-5') }}
      </div>
    </div>


  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

  <script>
    function toggleSidebar() {
        const sidebar = document.getElementById("mySidebar");
        sidebar.classList.toggle("responsive");
      }



      let roomValues = {};
document.querySelectorAll('.roomTypeGuestEdit').forEach(input => {
    roomValues[input.id] = parseInt(input.value, 10) || 0;
});

let roomPrices = {};

const fetchRoomPrices = async () => {
    try {
        const response = await fetch('/api/room-prices');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        
        // Populate the roomPrices object
        data.forEach(room => {
            roomPrices[room.room_type] = parseFloat(room.price);
        });

        console.log('Room prices fetched:', roomPrices);
    } catch (error) {
        console.error('Error fetching room prices:', error);
    }
};

// Call the function when the page loads

      
    document.addEventListener('DOMContentLoaded', () => {

      fetchRoomPrices();

    // Function to calculate total price
    // Attach event listener to all radio buttons in the discount group
document.querySelectorAll('input[name="discount_options"]').forEach((radioButton) => {
    radioButton.addEventListener('change', function() {
        // Call the function to recalculate the total price for the selected guest
        const guestId = this.id.split('-')[1];  // Extract guestId from radio button ID
        calculateTotalPrice(guestId); // Recalculate the price on discount change
    });
});

const calculateTotalPrice = (guestId) => {
    let totalPrice = 0;
    
    // Get the selected discount option
    const discountType = document.querySelector(`input[name="discount_options"]:checked`);
    
    // Get check-in and check-out dates
    const checkInDate = document.querySelector(`#check_in-${guestId}`).value;
    const checkOutDate = document.querySelector(`#check_out-${guestId}`).value;

    // Calculate number of days
    const checkIn = new Date(checkInDate);
    const checkOut = new Date(checkOutDate);

    // Calculate the time difference in milliseconds, then convert it to days
    const timeDifference = checkOut - checkIn;
    const days = Math.max(1, timeDifference / (1000 * 60 * 60 * 24)); // Ensure at least 1 day

    // Validate the days value (it should be > 0)
    if (days <= 0) {
        console.error("Invalid number of days.");
        return;
    }

    // Calculate room price based on room types and counts
    

    // Attach event listeners for inputs
    document.querySelectorAll('.modal').forEach(modal => {
        const guestId = modal.id.split('-')[1];

        // Recalculate when room counts, discount, or dates change
        modal.addEventListener('input', (event) => {
            if (
                event.target.classList.contains('roomTypeGuestEdit') ||
                event.target.name === 'discount_options' ||
                event.target.classList.contains('cin') ||
                event.target.classList.contains('cout')
            ) {
                calculateTotalPrice(guestId);
            }
        });
    });

document.querySelectorAll(`#editModal-${guestId} .roomTypeGuestEdit`).forEach(input => {
        const roomType = input.previousElementSibling.textContent.trim(); // e.g. "Standard V1"
        const roomCount = parseInt(input.value, 10) || 0; // Get the count of rooms (default to 0)
        
        // Get the room price from the roomPrices object (assuming it's defined elsewhere)
        const roomPrice = roomPrices[roomType] || 0; // If room type doesn't exist, set the price to 0
        
        // Add the price for the selected room type and count
        totalPrice += roomCount * roomPrice * days;
    });

    // Apply discount if applicable (20% off for student or senior)
    if (discountType && ["student", "senior"].includes(discountType.value)) {
        totalPrice *= 0.8; // Apply 20% discount
    }

    // Add an additional 1500 (or 15,000 depending on your requirement)
    totalPrice += 1500; // Update this if necessary (it could be a fixed fee or additional charges)

    // Update the total price input field (assumes this exists in the form)
    const totalPriceField = document.querySelector(`#price_total-${guestId}`);
    totalPriceField.value = totalPrice.toFixed(2);
};
      // Global constants
      document.getElementById('roomType').addEventListener('change', function () {
    const roomType = this.value;
    const container = this.closest('.modal-body');

    // Fetch elements within the same container
    const priceInput = container.querySelector('input[name="price"]');
    const priceIdInput = container.querySelector('input[name="priceId"]');

    fetchRoomPrice(roomType, priceInput, priceIdInput);
  });

  function fetchRoomPrices1(roomType) {
    console.log("Fetching room prices for room type:", roomType);
  }

  function fetchRoomPrice(roomType, priceInput, priceIdInput) {
  // Fetch room price from the server based on room type
  fetch(`/api/room-prices/${roomType}`)
    .then(response => response.json())
    .then(data => {
      if (data && data.price) {
        console.log(roomType);
        priceInput.value = data.price; // Set price in the input field
        priceIdInput.value = data.id; // Set price ID
      }
    })
    .catch(error => console.error('Error fetching room price:', error));
}

  document.querySelectorAll('.roomTypeEdit').forEach((dropdown) => {
    dropdown.addEventListener('change', function () {
        // Get the value of the selected option
        const selectedValue = this.value;

        // Log the selected value or take action
        console.log("Selected Room Type: ", selectedValue);

        const container = this.closest('.modal-body');

    // Fetch elements within the same container
    const priceInput = container.querySelector('input[name="price"]');
    const priceIdInput = container.querySelector('input[name="priceId"]');

    fetchRoomPrice(selectedValue, priceInput, priceIdInput);
    });
});

      

      // Active link setting
      function setActive(link) {
        const links = document.querySelectorAll(".sidebar a");
        links.forEach(link => link.classList.remove("active"));
        link.classList.add("active");
      }

      // Calendar functions
      let currentDate = new Date();

      function changeMonth(direction) {
        currentDate.setMonth(currentDate.getMonth() + direction);
        renderCalendar();
      }

      function renderCalendar() {
        const monthYear = document.getElementById("month-year");
        monthYear.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${currentDate.getFullYear()}`;

        const daysContainer = document.getElementById("calendarDays");
        daysContainer.innerHTML = "";

        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
        const totalDays = lastDay.getDate();
        const startingDay = firstDay.getDay();

        // Empty slots for alignment
        for (let i = 0; i < startingDay; i++) {
          const emptyDiv = document.createElement("div");
          emptyDiv.classList.add("calendar-day", "empty");
          daysContainer.appendChild(emptyDiv);
        }

        // Calendar days
        for (let i = 1; i <= totalDays; i++) {
          const dayDiv = document.createElement("div");
          dayDiv.classList.add("calendar-day");
          dayDiv.textContent = i;

          if (i === new Date().getDate() && currentDate.getMonth() === new Date().getMonth()) {
            dayDiv.classList.add("current-day");
          }

          dayDiv.onclick = function() {
            if (this.classList.contains("active-day")) {
              this.classList.remove("active-day");
              hideBookings();
            } else {
              document.querySelectorAll(".calendar-day").forEach(day => day.classList.remove("active-day"));
              this.classList.add("active-day");
              showCustomerBookings(i);
            }
          };

          daysContainer.appendChild(dayDiv);
        }
      }

      renderCalendar();
    });
  </script>

</body>

</html>