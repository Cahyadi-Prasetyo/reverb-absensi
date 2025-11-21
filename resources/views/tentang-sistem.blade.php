@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.karyawan')

@section('page-title', 'Tentang Sistem')
@section('page-subtitle', 'Informasi tentang Sistem Absensi Real-Time Terdistribusi')

@section('content')
<div class="space-y-6">
    <!-- Hero Section -->
    <div class="p-8 text-center">
        <div class="w-20 h-20 mx-auto mb-4 bg-blue-600 rounded-full flex items-center justify-center">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-white mb-2">Sistem Absensi Real-Time Terdistribusi</h1>
        <p class="text-gray-900 max-w-3xl mx-auto">
            Platform absensi modern dengan arsitektur terdistribusi yang memungkinkan sinkronisasi data 
            secara real-time di berbagai server
        </p>
    </div>

    <!-- Tujuan Proyek -->
    <div class="bg-blue-600 rounded-lg p-6 shadow-lg">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-white mb-3">Tujuan Proyek</h2>
                <p class="text-blue-100 leading-relaxed mb-4">
                    Proyek ini bertujuan untuk mengimplementasikan sistem absensi berbasis web dengan arsitektur terdistribusi. 
                    Sistem ini memastikan ketersediaan data tinggi (high availability) dan konsistensi data di berbagai server 
                    menggunakan teknologi sinkronisasi real-time. Dengan pendekatan ini, sistem dapat terus beroperasi meskipun 
                    salah satu server mengalami gangguan, serta menjamin data absensi selalu up-to-date di seluruh node.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-500 rounded-lg p-4">
                        <h3 class="font-semibold text-white mb-2">High Availability</h3>
                        <p class="text-blue-100 text-sm">Sistem tetap berjalan meskipun ada server yang down</p>
                    </div>
                    <div class="bg-blue-500 rounded-lg p-4">
                        <h3 class="font-semibold text-white mb-2">Real-Time Sync</h3>
                        <p class="text-blue-100 text-sm">Data tersinkronisasi otomatis tanpa delay</p>
                    </div>
                    <div class="bg-blue-500 rounded-lg p-4">
                        <h3 class="font-semibold text-white mb-2">Data Consistency</h3>
                        <p class="text-blue-100 text-sm">Eventual consistency dengan max delay 1-2 detik</p>
                    </div>
                    <div class="bg-blue-500 rounded-lg p-4">
                        <h3 class="font-semibold text-white mb-2">Load Balancing</h3>
                        <p class="text-blue-100 text-sm">Traffic didistribusikan ke multiple nodes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Teknologi yang Digunakan -->
    <div class="bg-white rounded-lg p-6 shadow-lg">
        <h2 class="text-xl font-bold text-white mb-6">Teknologi yang Digunakan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($technologies as $tech)
            <div class="p-4">
                <div class="w-12 h-12 mb-3 rounded-lg flex items-center justify-center
                    @if($tech['color'] === 'red') bg-red-600
                    @elseif($tech['color'] === 'orange') bg-orange-600
                    @elseif($tech['color'] === 'yellow') bg-yellow-600
                    @elseif($tech['color'] === 'blue') bg-blue-600
                    @elseif($tech['color'] === 'cyan') bg-cyan-600
                    @elseif($tech['color'] === 'purple') bg-purple-600
                    @else bg-gray-600
                    @endif">
                    @if($tech['icon'] === 'code')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    @elseif($tech['icon'] === 'database')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                    @elseif($tech['icon'] === 'bolt')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    @elseif($tech['icon'] === 'database-solid')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                        </svg>
                    @elseif($tech['icon'] === 'docker')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    @elseif($tech['icon'] === 'network')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    @endif
                </div>
                <h3 class="font-semibold text-white mb-1">{{ $tech['name'] }}</h3>
                <p class="text-gray-900 text-sm">{{ $tech['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Fitur Utama -->
    <div class="bg-white rounded-lg p-6 shadow-lg">
        <h2 class="text-xl font-bold text-white mb-6">Fitur Utama</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($features as $feature)
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center
                        @if($feature['color'] === 'blue') bg-blue-100
                        @elseif($feature['color'] === 'green') bg-green-100
                        @elseif($feature['color'] === 'purple') bg-purple-100
                        @elseif($feature['color'] === 'orange') bg-orange-100
                        @endif">
                        @if($feature['icon'] === 'bolt')
                            <svg class="w-6 h-6 
                                @if($feature['color'] === 'blue') text-blue-600
                                @elseif($feature['color'] === 'green') text-green-600
                                @elseif($feature['color'] === 'purple') text-purple-600
                                @elseif($feature['color'] === 'orange') text-orange-600
                                @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        @elseif($feature['icon'] === 'server')
                            <svg class="w-6 h-6 
                                @if($feature['color'] === 'blue') text-blue-600
                                @elseif($feature['color'] === 'green') text-green-600
                                @elseif($feature['color'] === 'purple') text-purple-600
                                @elseif($feature['color'] === 'orange') text-orange-600
                                @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        @elseif($feature['icon'] === 'database-solid')
                            <svg class="w-6 h-6 
                                @if($feature['color'] === 'blue') text-blue-600
                                @elseif($feature['color'] === 'green') text-green-600
                                @elseif($feature['color'] === 'purple') text-purple-600
                                @elseif($feature['color'] === 'orange') text-orange-600
                                @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                            </svg>
                        @elseif($feature['icon'] === 'shield')
                            <svg class="w-6 h-6 
                                @if($feature['color'] === 'blue') text-blue-600
                                @elseif($feature['color'] === 'green') text-green-600
                                @elseif($feature['color'] === 'purple') text-purple-600
                                @elseif($feature['color'] === 'orange') text-orange-600
                                @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        @endif
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-white mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-gray-900 text-sm leading-relaxed">{{ $feature['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Arsitektur Sistem -->
    <div class="bg-white rounded-lg p-6 shadow-lg">
        <h2 class="text-xl font-bold text-white mb-4">Arsitektur Sistem</h2>
        <p class="text-gray-900 mb-6">Sistem ini menggunakan arsitektur microservices dengan beberapa komponen utama:</p>
        
        <div class="space-y-3">
            @foreach($architecture as $component)
            <div class="flex items-center space-x-4 p-4 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold text-sm">
                        {{ $component['number'] }}
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-white">{{ $component['title'] }}:</h3>
                    <p class="text-gray-900 text-sm">{{ $component['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

