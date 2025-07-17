@extends('layouts.app')

@section('title', $film->judul . ' - CineMax')

@section('content')
<div class="bg-gradient-to-b from-gray-900 to-gray-800 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="/" class="flex items-center text-blue-400 hover:text-blue-300 mb-6">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Movies
        </a>

        <!-- Movie Header -->
        <div class="flex flex-col md:flex-row gap-6 mb-8">
            <!-- Movie Poster -->
            <div class="w-full md:w-1/3">
                <img src="{{ $film->poster_url ?? 'https://via.placeholder.com/300x450?text='.$film->judul }}" 
                     alt="{{ $film->judul }}" 
                     class="w-full rounded-lg shadow-xl">
            </div>
            
            <!-- Movie Info -->
            <div class="w-full md:w-2/3">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $film->judul }}</h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="flex items-center text-yellow-400">
                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                {{ number_format($film->rating, 1) }}
                            </span>
                            <span class="text-gray-300">{{ $film->duration }} min</span>
                            <span class="text-gray-300">{{ $film->genre }}</span>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-white mb-2">Synopsis</h3>
                    <p class="text-gray-300">{{ $film->deskripsi }}</p>
                </div>
                
                <div class="flex space-x-3">
                    <button class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Watch Trailer
                    </button>
                </div>
            </div>
        </div>

        <!-- Schedule Section -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-white mb-6">Showtimes</h2>
            
            @if ($film->jadwals->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-400">No showtimes available</p>
                </div>
            @else
                <!-- Group schedules by date -->
                @php
                    $groupedSchedules = $film->jadwals->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->waktu_tayang)->format('Y-m-d');
                    });
                @endphp
                
                <!-- Date Selection -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-300 mb-3">Select Date</h3>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-7 gap-2">
                        @foreach($groupedSchedules as $date => $schedules)
                            @php
                                $carbonDate = \Carbon\Carbon::parse($date);
                                $isToday = $carbonDate->isToday();
                                $isSelected = $loop->first; // Default select first date
                            @endphp
                            <button 
                                class="date-tab py-2 px-3 rounded-lg text-center transition-colors {{ $isSelected ? 'bg-blue-600 text-white' : 'bg-gray-700 hover:bg-gray-600 text-gray-300' }}"
                                data-date="{{ $date }}"
                            >
                                <div class="text-xs">{{ $carbonDate->format('D') }}</div>
                                <div class="font-medium">{{ $carbonDate->format('d') }}</div>
                                @if($isToday)
                                    <div class="text-xs mt-1 text-blue-300">Today</div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
                
                <!-- Time Selection (initially hidden) -->
                @foreach($groupedSchedules as $date => $schedules)
                <div class="time-selection mb-6 {{ !$loop->first ? 'hidden' : '' }}" data-date="{{ $date }}">
                    <h3 class="text-lg font-semibold text-gray-300 mb-3">Select Time</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach($schedules as $jadwal)
                            <a href="{{ url('/jadwal/' . $jadwal->id . '/pilih-kursi') }}"
                               class="bg-gray-700 hover:bg-blue-600 text-gray-300 hover:text-white rounded-lg py-3 px-4 text-center transition-colors">
                                <div class="font-medium">{{ \Carbon\Carbon::parse($jadwal->waktu_tayang)->format('H:i') }}</div>
                                <div class="text-xs mt-1 text-gray-400 hover:text-white">{{ $jadwal->studio->nama }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<script>
    // Date tab selection functionality
    document.querySelectorAll('.date-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            document.querySelectorAll('.date-tab').forEach(t => {
                t.classList.remove('bg-blue-600', 'text-white');
                t.classList.add('bg-gray-700', 'text-gray-300');
            });
            
            // Add active class to clicked tab
            this.classList.remove('bg-gray-700', 'text-gray-300');
            this.classList.add('bg-blue-600', 'text-white');
            
            // Hide all time selections
            document.querySelectorAll('.time-selection').forEach(ts => {
                ts.classList.add('hidden');
            });
            
            // Show time selection for selected date
            const date = this.getAttribute('data-date');
            document.querySelector(`.time-selection[data-date="${date}"]`).classList.remove('hidden');
        });
    });
</script>
@endsection

{{-- @extends('layouts.app')

@section('title', $film->judul . ' - CineMax')

@section('content')
<div class="bg-gradient-to-b from-gray-900 to-gray-800 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="/" class="flex items-center text-blue-400 hover:text-blue-300 mb-6">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Movies
        </a>

        <!-- Movie Header -->
        <div class="flex flex-col md:flex-row gap-6 mb-8">
            <!-- Movie Poster -->
            <div class="w-full md:w-1/3">
                <img src="{{ $film->poster_url ?? 'https://via.placeholder.com/300x450?text='.$film->judul }}" 
                     alt="{{ $film->judul }}" 
                     class="w-full rounded-lg shadow-xl">
            </div>
            
            <!-- Movie Info -->
            <div class="w-full md:w-2/3">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $film->judul }}</h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="flex items-center text-yellow-400">
                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                {{ number_format($film->rating, 1) }}
                            </span>
                            <span class="text-gray-300">{{ $film->duration }} min</span>
                            <span class="text-gray-300">{{ $film->genre }}</span>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-white mb-2">Synopsis</h3>
                    <p class="text-gray-300">{{ $film->deskripsi }}</p>
                </div>
                
                <div class="flex space-x-3">
                    <button class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Watch Trailer
                    </button>
                </div>
            </div>
        </div>

        <!-- Schedule Section -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-white mb-6">Showtimes</h2>
            
            @if ($film->jadwals->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-400">No showtimes available</p>
                </div>
            @else
                @php
                    // Filter schedules to only include today and next 3 days
                    $today = now()->startOfDay();
                    $threeDaysLater = now()->addDays(3)->endOfDay();
                    
                    $filteredSchedules = $film->jadwals->filter(function($item) use ($today, $threeDaysLater) {
                        $showTime = \Carbon\Carbon::parse($item->waktu_tayang);
                        return $showTime->between($today, $threeDaysLater);
                    });
                    
                    // Group the filtered schedules by date
                    $groupedSchedules = $filteredSchedules->groupBy(function($item) {
                        return \Carbon\Carbon::parse($item->waktu_tayang)->format('Y-m-d');
                    });
                @endphp
                
                @if($groupedSchedules->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-400">No showtimes available for the next 3 days</p>
                    </div>
                @else
                    <!-- Date Selection -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-300 mb-3">Select Date</h3>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-7 gap-2">
                            @foreach($groupedSchedules as $date => $schedules)
                                @php
                                    $carbonDate = \Carbon\Carbon::parse($date);
                                    $isToday = $carbonDate->isToday();
                                    $isSelected = $loop->first; // Default select first date
                                @endphp
                                <button 
                                    class="date-tab py-2 px-3 rounded-lg text-center transition-colors {{ $isSelected ? 'bg-blue-600 text-white' : 'bg-gray-700 hover:bg-gray-600 text-gray-300' }}"
                                    data-date="{{ $date }}"
                                >
                                    <div class="text-xs">{{ $carbonDate->format('D') }}</div>
                                    <div class="font-medium">{{ $carbonDate->format('d') }}</div>
                                    @if($isToday)
                                        <div class="text-xs mt-1 text-blue-300">Today</div>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Time Selection (initially hidden) -->
                    @foreach($groupedSchedules as $date => $schedules)
                        <div class="time-selection mb-6 {{ !$loop->first ? 'hidden' : '' }}" data-date="{{ $date }}">
                            <h3 class="text-lg font-semibold text-gray-300 mb-3">Select Time</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                @foreach($schedules as $jadwal)
                                    @php
                                        $showTime = \Carbon\Carbon::parse($jadwal->waktu_tayang);
                                        $isAvailable = $showTime->diffInHours(now(), false) < -1; // At least 1 hour before showtime
                                    @endphp
                                    
                                    @if($isAvailable)
                                        <a href="{{ url('/jadwal/' . $jadwal->id . '/pilih-kursi') }}"
                                           class="bg-gray-700 hover:bg-blue-600 text-gray-300 hover:text-white rounded-lg py-3 px-4 text-center transition-colors">
                                            <div class="font-medium">{{ $showTime->format('H:i') }}</div>
                                            <div class="text-xs mt-1 text-gray-400 hover:text-white">{{ $jadwal->studio->nama }}</div>
                                        </a>
                                    @else
                                        <div class="bg-gray-800 text-gray-500 rounded-lg py-3 px-4 text-center cursor-not-allowed">
                                            <div class="font-medium">{{ $showTime->format('H:i') }}</div>
                                            <div class="text-xs mt-1 text-gray-500">{{ $jadwal->studio->nama }}</div>
                                            <div class="text-xs mt-1 text-red-400">Not available</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </div>
</div>

<script>
    // Date tab selection functionality
    document.querySelectorAll('.date-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            document.querySelectorAll('.date-tab').forEach(t => {
                t.classList.remove('bg-blue-600', 'text-white');
                t.classList.add('bg-gray-700', 'text-gray-300');
            });
            
            // Add active class to clicked tab
            this.classList.remove('bg-gray-700', 'text-gray-300');
            this.classList.add('bg-blue-600', 'text-white');
            
            // Hide all time selections
            document.querySelectorAll('.time-selection').forEach(ts => {
                ts.classList.add('hidden');
            });
            
            // Show time selection for selected date
            const date = this.getAttribute('data-date');
            document.querySelector(`.time-selection[data-date="${date}"]`).classList.remove('hidden');
        });
    });
</script>
@endsection --}}