<x-app-layout>
    <x-slot name="title">
        {{ __('Beranda') }}
    </x-slot>

    <x-home.section-1 />

    <!-- <x-home.section-2 />

    <x-home.section-3 /> -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                @auth
                    You're logged in!
                @else
                    You'rw loggout
                @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
