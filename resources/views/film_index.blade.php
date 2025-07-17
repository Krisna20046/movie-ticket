@extends('layouts.app')

@section('title', 'Now Showing - CineMax')

@section('content')
<div class="bg-gradient-to-b from-gray-900 to-gray-800 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-white mb-2">Now Showing</h1>
                <p class="text-gray-300">Book your favorite movies now</p>
            </div>
            <div class="mt-4 md:mt-0">
                <form action="{{ route('films.index') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search movies..." 
                               value="{{ request('search') }}"
                               class="bg-gray-800 text-white rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-64">
                        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex space-x-2 mb-8 overflow-x-auto pb-2">
            <a href="{{ route('films.index') }}" 
               class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap 
                      {{ !request('genre') || request('genre') == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-800 hover:bg-gray-700 text-white' }}">
                All Movies
            </a>
            @foreach($genres as $genre)
            <a href="{{ route('films.index', ['genre' => $genre, 'search' => request('search')]) }}" 
               class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap 
                      {{ request('genre') == $genre ? 'bg-blue-600 text-white' : 'bg-gray-800 hover:bg-gray-700 text-white' }}">
                {{ $genre }}
            </a>
            @endforeach
        </div>

        <!-- Movies Grid -->
        @if($films->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($films as $film)
            <div class="group relative bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 hover:shadow-2xl">
                <!-- Movie Poster -->
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ $film->poster_url ?? 'https://via.placeholder.com/300x450?text='.$film->judul }}" alt="{{ $film->judul }}" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-70">
                    
                    <!-- Rating Badge -->
                    <div class="absolute top-2 left-2 bg-yellow-400 text-gray-900 text-xs font-bold px-2 py-1 rounded flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        {{ number_format($film->rating, 1) }}
                    </div>
                    
                    <!-- Hover Action -->
                    <div class="absolute inset-0 bg-black bg-opacity-70 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="/film/{{ $film->id }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-full flex items-center">
                            View Showtimes
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Movie Info -->
                <div class="p-4">
                    <h3 class="text-white font-bold text-lg mb-1 truncate">{{ $film->judul }}</h3>
                    <div class="flex items-center text-gray-400 text-sm mb-2">
                        <span>{{ $film->durasi }} min</span>
                        <span class="mx-2">•</span>
                        <span>{{ $film->genre }}</span>
                    </div>
                    <p class="text-gray-300 text-sm line-clamp-2">{{ $film->deskripsi }}</p>
                    
                    <!-- Action Buttons -->
                    <div class="mt-4 flex justify-between items-center">
                        <button class="text-gray-400 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                        <a href="/film/{{ $film->id }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium flex items-center">
                            Book Now
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-gray-800 rounded-lg p-8 text-center">
            <p class="text-gray-300 text-lg">No movies found matching your criteria.</p>
            <a href="{{ route('films.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-full">
                Reset Filters
            </a>
        </div>
        @endif

        <!-- Pagination with preserved query parameters -->
        @if ($films->hasPages())
        <div class="mt-10 flex justify-center">
            <nav class="inline-flex rounded-md shadow">
                {{-- Previous Page Link --}}
                @if ($films->onFirstPage())
                    <span class="px-3 py-2 rounded-l-md bg-gray-800 text-gray-500 cursor-not-allowed">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                @else
                    <a href="{{ $films->appends(request()->query())->previousPageUrl() }}" class="px-3 py-2 rounded-l-md bg-gray-800 text-gray-300 hover:bg-gray-700">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($films->getUrlRange(1, $films->lastPage()) as $page => $url)
                    @if ($page == $films->currentPage())
                        <span class="px-4 py-2 bg-blue-600 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $films->appends(request()->query())->url($page) }}" class="px-4 py-2 bg-gray-800 text-gray-300 hover:bg-gray-700">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($films->hasMorePages())
                    <a href="{{ $films->appends(request()->query())->nextPageUrl() }}" class="px-3 py-2 rounded-r-md bg-gray-800 text-gray-300 hover:bg-gray-700">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                @else
                    <span class="px-3 py-2 rounded-r-md bg-gray-800 text-gray-500 cursor-not-allowed">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                @endif
            </nav>
        </div>
        @endif
    </div>
</div>
@endsection