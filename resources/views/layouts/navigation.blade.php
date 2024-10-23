@aware(['listMenu' => [
    ['Kelembagaan', 1, 'kelembagaan', [['Tentang','kelembagaan_tentang'],['Visi Misi','kelembagaan_visi_misi'],['Struktur Organisasi','kelembagaan_struktur_organisasi']]],
    ['Penelitian', 0, 'lppm'],
    ['Pengmas', 0, 'lpmu'],
    ['Dokumen', 0, 'layanan-berita.index'],
    ['Berita', 0, 'layanan-berita.index'],
    ['Pengumuman', 0, 'pengumuman'],
]])

<nav x-data="{ open: false }" class="bg-white border-b-2 border-orange-100 sticky top-0 z-10">
    
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex py-2">
                        <img src="{{ url('Logo.png') }}" class="block h-16 mr-2 py-2"> <p class="mt-6" style="line-height: 10px;"><span style="font-size: 1.5rem;"><b>LPPM-PM</b></span><br><span class="text-sm">Institut Teknologi B.J. Habibie</span></p>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @foreach($listMenu as $list)
                        @if(empty($list[1]))
                            <x-nav-link :href="route($list[2])" :active="request()->routeIs($list[2])">
                                {{ __($list[0]) }}
                            </x-nav-link>
                        @else
                            <x-nav-link-parent :href="'#'" :active="request()->routeIs($list[2])">
                                <x-slot name="name">{{ __($list[0]) }}</x-slot>
                                <x-slot name="children">
                                    @foreach($list[3] as $listChild)
                                        <a href="{{route($listChild[1])}}">{{ __($listChild[0]) }}</a>
                                    @endforeach
                                    <!-- <span class="separator"></span> -->
                                </x-slot>
                            </x-nav-link-parent>
                        @endif
                    @endforeach
                </div>
            </div>

            @auth
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            @else
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Log in') }}
                </x-nav-link>
                <!-- <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Register') }}
                </x-nav-link> -->
            </div>
            @endauth
            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @foreach($listMenu as $list)
                @if($list[1]==0)
                <x-responsive-nav-link :href="route($list[2])" :active="request()->routeIs($list[2])">
                    {{ __($list[0]) }}
                </x-responsive-nav-link>
                @else
                <x-responsive-nav-link-parent :href="'#'" :active="request()->routeIs($list[2])">
                    <x-slot name="name">{{ __($list[0]) }}</x-slot>
                    <x-slot name="children">
                        @foreach($list[3] as $listChild)
                            <a href="{{route($listChild[1])}}">{{ __($listChild[0]) }}</a>
                        @endforeach
                        <!-- <span class="separator"></span> -->
                    </x-slot>
                </x-responsive-nav-link-parent>
                @endif
            @endforeach

        </div>

        @auth
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>

        @else

        <hr>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('Log in') }}
            </x-responsive-nav-link>
            <!-- <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                {{ __('Register') }}
            </x-responsive-nav-link> -->
        </div>

        @endauth
    </div>
</nav>
