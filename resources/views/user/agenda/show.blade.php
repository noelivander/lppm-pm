@extends('layouts.user-v2.app')

@section('title', $agenda->judul)

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-100 py-3">
    <div class="container mx-auto px-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800">Beranda</a>
                </li>
                <li class="text-gray-500">/</li>
                <li>
                    <a href="{{ route('layanan-agenda.index') }}" class="text-indigo-600 hover:text-indigo-800">Agenda</a>
                </li>
                <li class="text-gray-500">/</li>
                <li class="text-gray-500">Detail</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Content -->
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-3/4">
            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Cover Image -->
                @if($agenda->cover)
                <div class="w-full h-64 md:h-96 overflow-hidden">
                    <img src="{{ asset('storage/' . ltrim($agenda->cover, '/')) }}" 
                         alt="{{ $agenda->judul }}" 
                         class="w-full h-full object-cover">
                </div>
                @endif

                <!-- Header -->
                <div class="p-6 md:p-8">
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        @if($agenda->tag)
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded-full">
                            {{ $agenda->tag }}
                        </span>
                        @endif
                        <span class="text-sm text-gray-500">
                            <i class="far fa-user mr-1"></i> {{ $agenda->user->name ?? 'Admin' }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-1"></i> {{ $jadwal }}
                        </span>
                        @if($agenda->lokasi)
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $agenda->lokasi }}
                        </span>
                        @endif
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">{{ $agenda->judul }}</h1>

                    <!-- Description -->
                    <div class="prose max-w-none text-gray-700 mb-8">
                        {!! $deskripsi ?? '<p class="text-gray-500">Tidak ada deskripsi tersedia.</p>' !!}
                    </div>

                    <!-- Share Buttons -->
                    <div class="border-t border-gray-200 pt-6 mt-8">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Bagikan:</h3>
                        <div class="flex space-x-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank" 
                               class="text-gray-400 hover:text-blue-600">
                                <i class="fab fa-facebook-square text-2xl"></i>
                                <span class="sr-only">Bagikan ke Facebook</span>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($agenda->judul) }}" 
                               target="_blank" 
                               class="text-gray-400 hover:text-blue-400">
                                <i class="fab fa-twitter text-2xl"></i>
                                <span class="sr-only">Bagikan ke Twitter</span>
                            </a>
                            <a href="whatsapp://send?text={{ urlencode($agenda->judul . ' ' . url()->current()) }}" 
                               target="_blank" 
                               class="text-gray-400 hover:text-green-500">
                                <i class="fab fa-whatsapp text-2xl"></i>
                                <span class="sr-only">Bagikan ke WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/4">
            <!-- Related Events -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Agenda Lainnya</h3>
                @php
                    $relatedAgendas = \App\Models\Agenda::where('id', '!=', $agenda->id)
                        ->where('tag', $agenda->tag)
                        ->orWhere('user_id', $agenda->user_id)
                        ->orderBy('jadwal', 'desc')
                        ->take(3)
                        ->get();
                @endphp

                @if($relatedAgendas->count() > 0)
                    <div class="space-y-4">
                        @foreach($relatedAgendas as $related)
                            <a href="{{ route('layanan-agenda.show', $related->slug) }}" 
                               class="block group">
                                <div class="flex items-start space-x-3">
                                    @if($related->cover)
                                    <div class="flex-shrink-0 w-16 h-16 rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . ltrim($related->cover, '/')) }}" 
                                             alt="{{ $related->judul }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors">
                                            {{ Str::limit($related->judul, 50) }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ \Carbon\Carbon::parse($related->jadwal)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">Tidak ada agenda terkait.</p>
                @endif
            </div>

            <!-- Back to List -->
            <a href="{{ route('layanan-agenda.index') }}" 
               class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Agenda
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .prose {
        max-width: 100%;
    }
    .prose img {
        max-width: 100%;
        height: auto;
        margin: 1.5em 0;
        border-radius: 0.5rem;
    }
    .prose p {
        margin-bottom: 1.25em;
        line-height: 1.7;
    }
    .prose h2, .prose h3, .prose h4 {
        margin-top: 1.5em;
        margin-bottom: 0.75em;
        font-weight: 600;
        color: #111827;
    }
    .prose a {
        color: #4f46e5;
        text-decoration: none;
    }
    .prose a:hover {
        text-decoration: underline;
    }
</style>
@endpush

@endsection