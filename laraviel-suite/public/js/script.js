document.addEventListener("DOMContentLoaded", function () {
    let currentStep = 1;
    let checkInDate = null;
    let checkOutDate = null;
    let selectedRooms = [];
    let totalPrice = 0;

    let calYear = new Date().getFullYear();
    let calMonth = new Date().getMonth();

    // ── Pre-fetch Elevation ────────────────────
    const fetchRooms = () => {
        const container = document.querySelector(".standard-room");
        if (!container) return;

        fetch("/rooms")
            .then(res => {
                if (!res.ok) throw new Error("Network response was not ok");
                return res.json();
            })
            .then(data => {
                const loader = document.getElementById("loader");
                if (loader) loader.remove();

                if (!data || data.length === 0) {
                    container.innerHTML = '<div class="col-12 text-center py-5 text-gold opacity-50">No sanctuaries available at this moment.</div>';
                    return;
                }

                data.forEach(room => {
                    const modalTarget = room.room_type.includes("Deluxe") ? "#deluxeAmenitiesModal" : 
                                      (room.room_type.includes("Luxury") ? "#luxuryAmenitiesModal" : "#amenitiesModal");

                    const roomHtml = `
                    <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
                        <div class="room-card">
                            <div class="room-image-wrapper">
                                <img src="/${room.image_path.replace(/^\//, '')}" alt="${room.room_type}" loading="lazy">
                                <span class="room-badge">${room.room_type.split(' ')[0]}</span>
                            </div>
                            <div class="room-content">
                                <h3 class="room-type">${room.room_type}</h3>
                                <p class="room-description">${room.description.substring(0, 90)}...</p>
                                
                                <div class="room-price-row pt-3 mt-auto border-top border-gold border-opacity-10 d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="price-label">Per Night</span>
                                        <span class="price-value">₱${parseFloat(room.price).toLocaleString()}</span>
                                    </div>
                                    <button class="btn btn-premium-solid btn-sm select-room-btn" 
                                            data-id="${room.id}" 
                                            data-type="${room.room_type}" 
                                            data-price="${room.price}">
                                        Select
                                    </button>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="#" class="small text-gold text-decoration-none aboreto" style="font-size: 0.6rem; letter-spacing: 2px;" data-bs-toggle="modal" data-bs-target="${modalTarget}">
                                        View In-Suite Amenities
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    container.insertAdjacentHTML("beforeend", roomHtml);
                });

                // Attach selection listeners
                document.querySelectorAll(".select-room-btn").forEach(btn => {
                    btn.addEventListener("click", function() {
                        const roomId = this.dataset.id;
                        
                        // Redirect logic if on Accommodation page
                        if (!document.getElementById("stepper")) {
                            window.location.href = `/book-now?room_id=${roomId}`;
                            return;
                        }

                        const roomType = this.dataset.type;
                        const price = parseFloat(this.dataset.price);

                        if (this.innerText === "Selected") {
                            this.innerText = "Select";
                            this.classList.replace("btn-light", "btn-premium-solid");
                            selectedRooms = [];
                        } else {
                            // Deselect all others
                            document.querySelectorAll(".select-room-btn").forEach(b => {
                                b.innerText = "Select";
                                b.classList.replace("btn-light", "btn-premium-solid");
                            });
                            // Select this one
                            this.innerText = "Selected";
                            this.classList.replace("btn-premium-solid", "btn-light");
                            selectedRooms = [{ id: roomId, type: roomType, price: price }];
                        }
                        updateSummary();
                    });
                });

                // Auto-select room from URL
                const urlParams = new URLSearchParams(window.location.search);
                const preselectRoomId = urlParams.get('room_id');
                if (preselectRoomId && document.getElementById("stepper")) {
                    const preselectBtn = document.querySelector(`.select-room-btn[data-id="${preselectRoomId}"]`);
                    if (preselectBtn) {
                        preselectBtn.click();
                        // Jump to Step 2 to show their selection
                        setTimeout(() => switchStep(2), 500); 
                    }
                }
            })
            .catch(err => {
                console.error("Room fetch error:", err);
                const loader = document.getElementById("loader");
                if (loader) {
                    loader.innerHTML = '<p class="text-gold small">An error occurred while curating our collection. Please refresh.</p>';
                }
            });
    };

    const updateSummary = () => {
        const roomListElem = document.querySelector(".booked-rooms");
        if(!roomListElem) return;

        const nightsInput = document.querySelector("#totalNightsInput");
        const nights = nightsInput ? parseInt(nightsInput.value) || 0 : 0;

        if (selectedRooms.length === 0) {
            roomListElem.textContent = "None selected";
        } else {
            roomListElem.innerHTML = selectedRooms.map(r => `<div>${r.type}</div>`).join("");
        }

        totalPrice = selectedRooms.reduce((acc, r) => acc + (r.price * nights), 0);
        
        document.querySelectorAll(".totalPriceDisplay").forEach(display => {
            display.textContent = `₱${totalPrice.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        });
    };

    // ── Payment Form Toggle ────────────────────
    const paymentMethodSelect = document.getElementById('paymentMethodSelect');
    if (paymentMethodSelect) {
        paymentMethodSelect.addEventListener('change', function(e) {
            document.querySelectorAll('.payment-form').forEach(el => el.classList.add('d-none'));
            if (e.target.value === 'over_the_counter') {
                document.getElementById('counterPaymentForm').classList.remove('d-none');
            }
        });
    }

    // ── Step Navigation ────────────────────────
    const switchStep = (step) => {
        // Validation for step 1
        if (step === 2 && (!checkInDate || !checkOutDate)) {
            alert("Please select your Timeline first.");
            return;
        }

        // Validation for step 2
        if (step === 3 && selectedRooms.length === 0) {
            alert("Please select at least one Suite.");
            return;
        }

        // Validation for step 3
        if (step === 4) {
            const reqFields = ["firstname", "lastname", "email", "contactNumber", "address"];
            const isComplete = reqFields.every(id => document.getElementById(id).value.trim() !== "");
            if (!isComplete) {
                alert("Please complete the Resident Profile.");
                return;
            }
        }

        // Processing payment (transition from 4 to 5)
        if (step === 5) {
            // Show processing
            const paymentForms = document.querySelectorAll(".payment-form");
            paymentForms.forEach(el => el.classList.add("d-none"));
            if(document.getElementById("paymentMethodSelect")) document.getElementById("paymentMethodSelect").classList.add("d-none");
            const labels = document.querySelectorAll("#step-4-content label");
            labels.forEach(el => el.classList.add("d-none"));
            
            const processingNode = document.getElementById("paymentProcessing");
            if(processingNode) processingNode.classList.remove("d-none");
            
            const stepNav = document.getElementById("step-navigation");
            if(stepNav) stepNav.classList.add("d-none");
            
            setTimeout(() => {
                submitBooking();
                renderSwitch(5);
            }, 2000);
            return;
        }

        renderSwitch(step);
    };

    const renderSwitch = (step) => {
        currentStep = step;

        for(let i=1; i<=5; i++) {
            const content = document.getElementById(`step-${i}-content`);
            if(content) content.classList.add("d-none");
            
            const indicator = document.getElementById(`step-${i}-indicator`);
            if(indicator) indicator.classList.remove("active");
        }

        const activeContent = document.getElementById(`step-${currentStep}-content`);
        if(activeContent) activeContent.classList.remove("d-none");
        
        const activeIndicator = document.getElementById(`step-${currentStep}-indicator`);
        if(activeIndicator) activeIndicator.classList.add("active");

        window.scrollTo({ top: 0, behavior: 'smooth' });

        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        
        if (prevBtn) {
            if (currentStep === 1 || currentStep === 5) prevBtn.classList.add("d-none");
            else prevBtn.classList.remove("d-none");
        }

        if (nextBtn) {
            if (currentStep === 5) nextBtn.classList.add("d-none");
            else if (currentStep === 4) nextBtn.innerText = "Confirm & Pay";
            else nextBtn.innerText = "Continue Journey";
        }
        
        if(activeContent) {
            anime({
                targets: activeContent,
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 800,
                easing: 'easeOutCubic'
            });
        }
    };

    if (document.getElementById("nextBtn")) {
        document.getElementById("nextBtn").addEventListener("click", () => switchStep(currentStep + 1));
    }
    if (document.getElementById("prevBtn")) {
        document.getElementById("prevBtn").addEventListener("click", () => switchStep(currentStep - 1));
    }

    // ── Calendar Core ──────────────────────────
    function generateCalendar(year, month, calendarId, titleId) {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();

        const titleElem = document.getElementById(titleId);
        const calendarElem = document.getElementById(calendarId);
        if (!titleElem || !calendarElem) return;

        titleElem.textContent = `${monthNames[month]} ${year}`;

        let table = `<thead><tr><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th></tr></thead><tbody><tr>`;
        for (let i = 0; i < firstDay; i++) table += `<td></td>`;
        
        const today = new Date();
        today.setHours(0,0,0,0);

        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
            const loopDate = new Date(dateStr);
            loopDate.setHours(0,0,0,0);

            const isPast = loopDate < today;
            let classes = ['clickable-day'];
            
            if (isPast) {
                classes.push('disabled');
            }
            if (checkInDate === dateStr || checkOutDate === dateStr) {
                classes.push('active-cell');
            }

            table += `<td><span class="${classes.join(' ')}" data-date="${dateStr}">${day}</span></td>`;
            if ((day + firstDay) % 7 === 0) table += `</tr><tr>`;
        }
        table += `</tr></tbody>`;
        calendarElem.innerHTML = table;

        calendarElem.querySelectorAll(".clickable-day").forEach(day => {
            if (day.classList.contains("disabled")) return;

            day.addEventListener("click", function () {
                const date = this.dataset.date;
                if (!checkInDate || (checkInDate && checkOutDate)) {
                    checkInDate = date;
                    checkOutDate = null;
                    document.getElementById("checkIndd").innerText = date;
                    document.getElementById("checkOutdd").innerText = "-- -- ----";
                    document.querySelectorAll(".clickable-day").forEach(d => d.classList.remove("active-cell"));
                    this.classList.add("active-cell");
                } else {
                    if (new Date(date) < new Date(checkInDate)) {
                        checkInDate = date;
                        document.getElementById("checkIndd").innerText = date;
                        document.querySelectorAll(".clickable-day").forEach(d => d.classList.remove("active-cell"));
                        this.classList.add("active-cell");
                    } else {
                        checkOutDate = date;
                        document.getElementById("checkOutdd").innerText = date;
                        calculateNights();
                        highlightRange();
                    }
                }
            });
        });
    }

    const calculateNights = () => {
        if (checkInDate && checkOutDate) {
            const di = new Date(checkInDate);
            const do_ = new Date(checkOutDate);
            const nights = Math.ceil((do_ - di) / (1000 * 60 * 60 * 24));
            
            const nDisplay = document.querySelector(".nights");
            if(nDisplay) nDisplay.textContent = `${nights} Night${nights > 1 || nights === 0 ? 's' : ''}`;
            
            const nInput = document.getElementById("totalNightsInput");
            if(nInput) nInput.value = nights;
            
            updateSummary();
        }
    };

    const highlightRange = () => {
        if (!checkInDate || !checkOutDate) return;
        const start = new Date(checkInDate);
        const end = new Date(checkOutDate);
        document.querySelectorAll(".clickable-day").forEach(el => {
            const current = new Date(el.dataset.date);
            if (current >= start && current <= end && !el.classList.contains("disabled")) {
                el.classList.add("active-cell");
            } else if (current !== start && current !== end) {
                el.classList.remove("active-cell");
            }
        });
    };

    const renderCalendars = () => {
        if (!document.getElementById("currentMonthCalendar")) return;
        
        generateCalendar(calYear, calMonth, "currentMonthCalendar", "currentMonthTitle");
        
        let nextM = calMonth + 1;
        let nextY = calYear;
        if (nextM > 11) { nextM = 0; nextY++; }
        generateCalendar(nextY, nextM, "nextMonthCalendar", "nextMonthTitle");
        
        highlightRange();
    };

    if (document.getElementById("prevMonthBtn")) {
        document.getElementById("prevMonthBtn").addEventListener("click", () => {
            calMonth--;
            if (calMonth < 0) { calMonth = 11; calYear--; }
            renderCalendars();
        });
    }

    if (document.getElementById("nextMonthBtn")) {
        document.getElementById("nextMonthBtn").addEventListener("click", () => {
            calMonth++;
            if (calMonth > 11) { calMonth = 0; calYear++; }
            renderCalendars();
        });
    }

    // ── Submission Logic ───────────────────────
    const submitBooking = () => {
        const guestData = {
            bookingId: Math.random().toString(36).substr(2, 9) + Date.now().toString(36),
            salutation: document.getElementById("salutation").value,
            firstname: document.getElementById("firstname").value,
            lastname: document.getElementById("lastname").value,
            email: document.getElementById("email").value,
            contactNumber: document.getElementById("contactNumber").value,
            address: document.getElementById("address").value,
            checkIn: checkInDate,
            checkOut: checkOutDate,
            bookedRooms: selectedRooms.map(r => r.type).join(", "),
            priceTotal: totalPrice,
            paymentMethod: 'over_the_counter',
            paymentStatus: 'pending'
        };

        const greeting = document.querySelector(".greeting");
        if (greeting) greeting.innerText = `Welcome, ${guestData.salutation} ${guestData.lastname}`;

        const confirmationBox = document.querySelector(".guest-info1");
        if (confirmationBox) {
            confirmationBox.innerHTML = `
                <div class="mb-2"><strong>Account:</strong> ${guestData.lastname}, ${guestData.firstname}</div>
                <div class="mb-2"><strong>Arrival:</strong> ${guestData.checkIn}</div>
                <div class="mb-2"><strong>Departure:</strong> ${guestData.checkOut}</div>
                <div class="mb-2"><strong>Suites:</strong> ${guestData.bookedRooms}</div>
            `;
        }
        
        const totPriceEl = document.querySelector(".total-price");
        if(totPriceEl) totPriceEl.innerText = `₱${totalPrice.toLocaleString()}`;

        fetch("/submit-guest-info", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify(guestData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.errors) console.error(data.errors);
            else {
                console.log("Success:", data);
                // Success animation
                anime({
                    targets: '.greeting',
                    scale: [0.9, 1],
                    duration: 1000,
                    easing: 'easeOutElastic(1, .8)'
                });
            }
        });
    };

    // ── Initialization ─────────────────────────
    fetchRooms();
    
    if (document.getElementById("currentMonthCalendar")) {
        // Auto-select today
        const today = new Date();
        const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, "0")}-${String(today.getDate()).padStart(2, "0")}`;
        checkInDate = todayStr;
        
        const checkInEl = document.getElementById("checkIndd");
        if (checkInEl) checkInEl.innerText = todayStr;

        renderCalendars();
    }
});
