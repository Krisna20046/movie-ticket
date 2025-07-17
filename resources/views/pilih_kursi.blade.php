@extends('layouts.app')

@section('title', 'Pilih Kursi - ' . $jadwal->film->judul)

@section('content')
<div class="bg-gradient-to-b from-gray-900 to-gray-800 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="/film/{{ $jadwal->film->id }}" class="flex items-center text-blue-400 hover:text-blue-300 mb-6">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Showtimes
        </a>

        <!-- Movie Info -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/4">
                    <img src="{{ $jadwal->film->poster_url ?? 'https://via.placeholder.com/300x450?text='.$jadwal->film->judul }}" 
                         alt="{{ $jadwal->film->judul }}" 
                         class="w-full rounded-lg shadow">
                </div>
                <div class="w-full md:w-3/4">
                    <h1 class="text-2xl font-bold text-white mb-2">{{ $jadwal->film->judul }}</h1>
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="text-gray-300">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($jadwal->waktu_tayang)->format('l, d F Y') }}
                        </span>
                        <span class="text-gray-300">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($jadwal->waktu_tayang)->format('H:i') }}
                        </span>
                        <span class="text-gray-300">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            {{ $jadwal->studio->nama }}
                        </span>
                        <span class="text-gray-300">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Rp {{ number_format($jadwal->harga, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <div class="flex items-center mb-4">
                        <div class="flex-1 bg-gray-700 h-px"></div>
                        <span class="px-3 text-gray-400">SCREEN THIS WAY</span>
                        <div class="flex-1 bg-gray-700 h-px"></div>
                    </div>
                    
                    <!-- Cinema Screen -->
                    <div class="mb-6">
                        <div class="bg-gradient-to-r from-gray-600 to-gray-500 h-8 rounded-t-lg mx-auto" style="width: 80%; position: relative;">
                            <div class="absolute inset-0 flex items-center justify-center text-white text-sm font-medium">
                                CINEMA SCREEN
                            </div>
                        </div>
                        <div class="bg-gray-700 h-4 mx-auto" style="width: 85%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seat Selection Form -->
        <form id="bookingForm" action="/pesan" method="POST" class="bg-gray-800 rounded-lg shadow-lg p-6">
            @csrf
            <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">

            <h2 class="text-xl font-bold text-white mb-6">Select Your Seats</h2>
            
            <!-- Seat Legend -->
            <div class="flex justify-center gap-6 mb-8">
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-green-500 rounded mr-2"></div>
                    <span class="text-gray-300 text-sm">Available</span>
                </div>
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-red-500 rounded mr-2"></div>
                    <span class="text-gray-300 text-sm">Selected</span>
                </div>
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-gray-500 rounded mr-2"></div>
                    <span class="text-gray-300 text-sm">Taken</span>
                </div>
            </div>

            <!-- Seat Grid -->
            <div class="flex justify-center mb-6">
                <div class="grid grid-cols-10 gap-2">
                    @foreach ($kursis as $kursi)
                        @php
                            $isDisabled = in_array($kursi->id, $terisi);
                            $row = substr($kursi->kode_kursi, 0, 1);
                            $showRowLabel = $loop->first || substr($kursis[$loop->index - 1]->kode_kursi, 0, 1) !== $row;
                        @endphp
                        
                        @if ($showRowLabel)
                            <div class="col-span-10 flex justify-center items-center h-10">
                                <span class="text-gray-400 font-medium">Row {{ $row }}</span>
                            </div>
                        @endif
                        
                        <label class="text-center">
                            <input type="checkbox" name="kursi_id[]" value="{{ $kursi->id }}"
                                   class="hidden peer" {{ $isDisabled ? 'disabled' : '' }} data-price="{{ $jadwal->harga }}">
                            <div class="w-10 h-10 flex items-center justify-center 
                                        {{ $isDisabled ? 'bg-gray-500 cursor-not-allowed' : 'bg-green-500 hover:bg-green-400 cursor-pointer' }} 
                                        peer-checked:bg-red-500 text-white rounded transition-colors">
                                {{ substr($kursi->kode_kursi, 1) }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Price Summary -->
            <div class="bg-gray-700 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Selected Seats:</span>
                    <span id="selectedSeatsList" class="text-white font-medium">-</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-gray-300">Ticket Price:</span>
                    <span id="ticketPrice" class="text-white">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-gray-300">Quantity:</span>
                    <span id="ticketQuantity" class="text-white">0</span>
                </div>
                <div class="border-t border-gray-600 my-3"></div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-300 font-bold">Total Price:</span>
                    <span id="totalPrice" class="text-white font-bold text-lg">Rp 0</span>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-700 my-6"></div>

            <!-- Customer Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-300 mb-2">Full Name</label>
                    <input type="text" name="nama" required 
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Email Address</label>
                    <input type="email" name="email" required 
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="button" onclick="showTicketPreview()"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg transition-colors flex items-center">
                    Continue to Payment
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Ticket Preview Modal -->
<div id="ticketModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <!-- Ticket Design -->
        <div id="ticketCapture" class="p-6 bg-white text-black rounded-lg w-full">
            <div class="border-2 border-gray-300 rounded-lg overflow-hidden">
                <!-- Ticket Header -->
                <div class="bg-blue-600 p-4 text-white text-center">
                    <h2 class="text-2xl font-bold">CINEMAX TICKET</h2>
                    <p class="text-blue-100">Your Movie Experience</p>
                </div>
                
                <!-- Ticket Body -->
                <div class="p-4">
                    <div class="flex items-start mb-4">
                        <img src="{{ $jadwal->film->poster_url ?? 'https://via.placeholder.com/300x450?text='.$jadwal->film->judul }}" 
                             alt="{{ $jadwal->film->judul }}" 
                             class="w-20 h-28 object-cover rounded mr-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $jadwal->film->judul }}</h3>
                            <div class="text-gray-600 mb-2">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span id="ticketSeats" class="font-medium">Seats: </span>
                                </div>
                            </div>
                            <div class="text-gray-600 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span>Studio: {{ $jadwal->studio->nama }}</span>
                            </div>
                            <div class="text-gray-600 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($jadwal->waktu_tayang)->format('l, d F Y') }}</span>
                            </div>
                            <div class="text-gray-600">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($jadwal->waktu_tayang)->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-dashed border-gray-400 my-4"></div>
                    
                    <div class="mb-4">
                        <h4 class="font-bold text-gray-800 mb-2">Customer Info</h4>
                        <p id="ticketName" class="text-gray-600">Name: </p>
                        <p id="ticketEmail" class="text-gray-600">Email: </p>
                    </div>
                    
                    <div class="border-t border-dashed border-gray-400 my-4"></div>
                    
                    <div class="mb-4">
                        <h4 class="font-bold text-gray-800 mb-2">Payment Details</h4>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-600">Ticket Price:</span>
                            <span id="ticketPriceDisplay" class="text-gray-800">Rp 0</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-600">Quantity:</span>
                            <span id="ticketQuantityDisplay" class="text-gray-800">0</span>
                        </div>
                        <div class="flex justify-between font-bold mt-2">
                            <span class="text-gray-800">Total:</span>
                            <span id="ticketTotalDisplay" class="text-blue-600">Rp 0</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-100 p-3 rounded-lg text-center">
                        <p class="text-sm text-gray-600">Please show this ticket at the cinema entrance</p>
                        <div class="flex justify-center mt-2">
                            <div class="w-24 h-8 bg-black"></div>
                        </div>
                        <p id="ticketBookingId" class="text-xs text-gray-500 mt-2">Booking ID: </p>
                    </div>
                </div>
                
                <!-- Ticket Footer -->
                <div class="bg-gray-100 p-3 text-center text-sm text-gray-600">
                    <p>Thank you for choosing CINEMAX</p>
                    <p>Enjoy your movie!</p>
                </div>
            </div>
        </div>
        
        <!-- Modal Actions -->
        <div class="bg-gray-100 px-6 py-4 flex justify-between">
            <button onclick="submitForm()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                Confirm Payment
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </button>
            <button onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-2xl max-w-md w-full p-6">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-3">Payment Successful!</h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500">
                    Your booking has been confirmed. You can now download your ticket.
                </p>
            </div>
            <div class="mt-4 flex justify-center gap-3">
                <button onclick="downloadTicket()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Ticket
                </button>
                <a href="/" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    input:checked + div {
        animation: pulse 0.3s ease;
    }
    
    .ticket {
        position: relative;
    }
    .ticket:before, .ticket:after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #f3f4f6;
        border-radius: 50%;
    }
    .ticket:before {
        top: -10px;
        left: -10px;
    }
    .ticket:after {
        top: -10px;
        right: -10px;
    }
</style>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    // Format number to IDR currency
    function formatIDR(amount) {
        return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Update price summary when seats are selected
    function updatePriceSummary() {
        const selectedSeats = Array.from(document.querySelectorAll('input[name="kursi_id[]"]:checked'));
        const seatPrice = selectedSeats.length > 0 ? parseInt(selectedSeats[0].dataset.price) : 0;
        const totalPrice = selectedSeats.length * seatPrice;
        
        // Update seat codes display
        const seatCodes = selectedSeats.map(input => {
            const seatId = input.value;
            const seat = {!! json_encode($kursis->keyBy('id')) !!}[seatId];
            return seat ? seat.kode_kursi : '';
        }).filter(code => code !== '').join(', ');
        
        document.getElementById('selectedSeatsList').textContent = seatCodes || '-';
        document.getElementById('ticketQuantity').textContent = selectedSeats.length;
        document.getElementById('totalPrice').textContent = formatIDR(totalPrice);
    }

    // Show ticket preview
    function showTicketPreview() {
        // Get selected seats with full codes (A1, B2, etc.)
        const selectedSeats = Array.from(document.querySelectorAll('input[name="kursi_id[]"]:checked'))
            .map(input => {
                const seatId = input.value;
                const seat = {!! json_encode($kursis->keyBy('id')) !!}[seatId];
                return seat ? seat.kode_kursi : '';
            })
            .filter(code => code !== '')
            .join(', ');
        
        if (selectedSeats.length === 0) {
            alert('Please select at least one seat');
            return;
        }
        
        // Get customer info
        const name = document.querySelector('input[name="nama"]').value;
        const email = document.querySelector('input[name="email"]').value;
        
        if (!name || !email) {
            alert('Please fill in your name and email');
            return;
        }

        // Calculate total price
        const seatPrice = parseInt(document.querySelector('input[name="kursi_id[]"]:checked').dataset.price);
        const quantity = document.querySelectorAll('input[name="kursi_id[]"]:checked').length;
        const totalPrice = seatPrice * quantity;
        
        // Update ticket preview
        document.getElementById('ticketSeats').textContent = 'Seats: ' + selectedSeats;
        document.getElementById('ticketName').textContent = 'Name: ' + name;
        document.getElementById('ticketEmail').textContent = 'Email: ' + email;
        document.getElementById('ticketBookingId').textContent = 'Booking ID: ' + generateBookingId();
        document.getElementById('ticketPriceDisplay').textContent = formatIDR(seatPrice);
        document.getElementById('ticketQuantityDisplay').textContent = quantity;
        document.getElementById('ticketTotalDisplay').textContent = formatIDR(totalPrice);
        
        // Store total price in hidden field for form submission
        if (!document.querySelector('input[name="total_harga"]')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'total_harga';
            input.value = totalPrice;
            document.getElementById('bookingForm').appendChild(input);
        } else {
            document.querySelector('input[name="total_harga"]').value = totalPrice;
        }
        
        // Show modal
        document.getElementById('ticketModal').classList.remove('hidden');
    }
    
    // Generate random booking ID
    function generateBookingId() {
        return 'CMX-' + Math.random().toString(36).substr(2, 8).toUpperCase();
    }
    
    // Close modal
    function closeModal() {
        document.getElementById('ticketModal').classList.add('hidden');
    }
    
    // Submit the form via AJAX
    function submitForm() {
        const form = document.getElementById('bookingForm');
        const formData = new FormData(form);
        
        // Show loading state
        const submitBtn = document.querySelector('#ticketModal button[onclick="submitForm()"]');
        submitBtn.innerHTML = 'Processing...';
        submitBtn.disabled = true;
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide ticket preview, show success modal
                document.getElementById('ticketModal').classList.add('hidden');
                document.getElementById('successModal').classList.remove('hidden');
                
                // Store booking data for ticket download
                window.bookingData = {
                    seats: document.getElementById('ticketSeats').textContent,
                    name: document.getElementById('ticketName').textContent,
                    email: document.getElementById('ticketEmail').textContent,
                    bookingId: document.getElementById('ticketBookingId').textContent,
                    price: document.getElementById('ticketPriceDisplay').textContent,
                    quantity: document.getElementById('ticketQuantityDisplay').textContent,
                    total: document.getElementById('ticketTotalDisplay').textContent
                };
            } else {
                alert(data.message || 'Payment failed. Please try again.');
                submitBtn.innerHTML = 'Confirm Payment <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            submitBtn.innerHTML = 'Confirm Payment <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            submitBtn.disabled = false;
        });
    }
    
    // Download ticket as image
    function downloadTicket() {
        const ticketElement = document.getElementById('ticketCapture').cloneNode(true);

        // Tambahkan watermark LUNAS
        const watermark = document.createElement('div');
        watermark.textContent = 'LUNAS';
        watermark.style.position = 'absolute';
        watermark.style.top = '50%';
        watermark.style.left = '50%';
        watermark.style.transform = 'translate(-50%, -50%) rotate(-30deg)';
        watermark.style.fontSize = '4rem';
        watermark.style.color = 'rgba(255, 0, 0, 0.3)';
        watermark.style.fontWeight = 'bold';
        watermark.style.zIndex = '50';
        ticketElement.style.position = 'relative';
        ticketElement.appendChild(watermark);

        // Tempel ke DOM tersembunyi untuk render
        const tempContainer = document.createElement('div');
        tempContainer.style.position = 'fixed';
        tempContainer.style.top = '-9999px';
        tempContainer.appendChild(ticketElement);
        document.body.appendChild(tempContainer);

        html2canvas(ticketElement, {
            scale: 2,
            backgroundColor: '#ffffff'
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'Cinemax-Ticket-' + new Date().getTime() + '.png';
            link.href = canvas.toDataURL('image/png');
            link.click();

            // Bersihkan temp element
            document.body.removeChild(tempContainer);
        }).catch(err => {
            console.error('Download error:', err);
            alert('Gagal menyimpan tiket.');
        });
    }

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Update price summary when seats are selected/deselected
        document.querySelectorAll('input[name="kursi_id[]"]').forEach(input => {
            input.addEventListener('change', updatePriceSummary);
        });
    });
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('ticketModal');
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    }
</script>
</body>
</html>
@endsection