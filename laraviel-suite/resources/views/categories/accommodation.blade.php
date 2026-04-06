@extends('layouts.app')
@section('custom-css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid p-5 accomodation-bg">
    <h2 class="section-title text-left">STANDARD SUITES</h2>
    <div class="row justify-content-around standard-room"> 
        
    </div>

<!-- Modal for Standard Room Amenities -->
<div class="modal fade" id="amenitiesModal" tabindex="-1" aria-labelledby="amenitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; padding: 30px;">
            <div class="modal-body" style="color: #FEF3E2; padding-top: 20px; padding-bottom: 20px;"> 
                <div class="d-flex justify-content-center mb-3">
                    <img src="{{ asset('images/balcony.png') }}" class="img-fluid mx-2" alt="Room Feature 1" style="border-radius: 15px; width: 40%; height: 328px;">
                    <div class="d-flex flex-column">
                        <img src="{{ asset('images/living area.png') }}" class="img-fluid mb-2" alt="Room Feature 2" style="border-radius: 15px; width: 100%; height: 160px;">
                        <img src="{{ asset('images/kitchen.png') }}" class="img-fluid" alt="Room Feature 3" style="border-radius: 15px; width: 100%; height: 160px;">
                    </div>
                </div>

                <h5 class="text-left" style="color: white; text-align: center; padding-bottom: 10px; border-bottom: 1px solid #FEF3E2;">ROOM FEATURES</h5>
                <div class="row mt-3">
                    <div class="col-6">
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li>King or Queen-sized Bed with premium bedding</li>
                            <li>Living area with a sofa, armchairs, and coffee table</li>
                            <li>Work desk with a comfortable chair and adequate lighting</li>
                            <li>Wardrobe/Closet with hangers and full-length mirror</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li>Private Balcony with outdoor seating</li>
                            <li>Air conditioning and heating controls</li>
                            <li>Television with cable and streaming options</li>
                            <li>Complimentary Wi-Fi access</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Deluxe Room Amenities -->
<div class="modal fade" id="deluxeAmenitiesModal" tabindex="-1" aria-labelledby="deluxeAmenitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; padding: 30px;">
            <div class="modal-body" style="color: #FEF3E2; padding-top: 20px; padding-bottom: 20px;"> 
                <div class="d-flex justify-content-center mb-3">
                    <img src="{{ asset('images/balcony.png') }}" class="img-fluid mx-2" alt="Room Feature 1" style="border-radius: 15px; width: 40%; height: 328px;">
                    <div class="d-flex flex-column">
                        <img src="{{ asset('images/living area.png') }}" class="img-fluid mb-2" alt="Deluxe Room Feature 2" style="border-radius: 15px; width: 100%; height: 160px;">
                        <img src="{{ asset('images/kitchen.png') }}" class="img-fluid" alt="Deluxe Room Feature 3" style="border-radius: 15px; width: 100%; height: 160px;">
                    </div>
                </div>

                <h5 class="text-left" style="color: white; text-align: center; padding-bottom: 10px; border-bottom: 1px solid #FEF3E2;">ROOM FEATURES</h5>

                <div class="row mt-3">
                    <div class="col-6">
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li>King or Queen-sized Bed with high-quality linens</li>
                            <li>Cozy seating area with a sofa or armchairs</li>
                            <li>Work desk with ergonomic chair and adequate lighting</li>
                            <li>In-room safe for personal belongings</li>
                            <li>Individual climate control (air conditioning/heating)</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li>Blackout curtains for better sleep</li>
                            <li>Soundproofing for a quieter experience</li>
                            <li>Stylish décor with modern finishes</li>
                            <li>CLarge windows offering a scenic or city view</li>
                            <li>Enhanced minibar or refrigerator with premium beverages and snacks</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Luxury Room Amenities -->
<div class="modal fade" id="luxuryAmenitiesModal" tabindex="-1" aria-labelledby="luxuryAmenitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; padding: 30px;">
            <div class="modal-body" style="color: #FEF3E2; padding-top: 20px; padding-bottom: 20px;"> 
                <div class="d-flex justify-content-center mb-3">
                    <img src="{{ asset('images/balcony.png') }}" class="img-fluid mx-2" alt="Room Feature 1" style="border-radius: 15px; width: 40%; height: 328px;">
                    <div class="d-flex flex-column">
                        <img src="{{ asset('images/living area.png') }}" class="img-fluid mb-2" alt="Luxury Room Feature 2" style="border-radius: 15px; width: 100%; height: 160px;">
                        <img src="{{ asset('images/kitchen.png') }}" class="img-fluid" alt="Luxury Room Feature 3" style="border-radius: 15px; width: 100%; height: 160px;">
                    </div>
                </div>

                <h5 class="text-left" style="color: white; text-align: center; padding-bottom: 10px; border-bottom: 1px solid #FEF3E2;">ROOM FEATURES</h5>

                <div class="row mt-3">
                    <div class="col-6">
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li>King-sized Bed with high-thread-count linens and premium bedding</li>
                            <li>Spacious living area with designer furniture (sofa, armchairs, coffee table)</li>
                            <li>Separate dining area or kitchenette with a dining table</li>
                            <li>Private balcony or terrace with a stunning view</li>
                            <li>Walk-in closet with ample space, hangers, and a full-length mirror</li>
                            <li>In-room safe with digital lock for extra security</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            <li>Advanced climate control system with personalized settings</li>
                            <li>Blackout curtains or motorized blinds for complete privacy</li>
                            <li>Soundproof walls and windows for a tranquil environment</li>
                            <li>Luxury art and decor for an elegant atmosphere</li>
                            <li>Dedicated office space with ergonomic chair and smart lighting options</li>
                            <li>Butler or concierge service available</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
