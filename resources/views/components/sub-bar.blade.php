@props([
    'listMenu'
])

<nav class="bg-orange-50 mx-auto">
    <div class="flex justify-center sm:justify-start space-x-4 px-4 sm:px-6 lg:px-9 xl:px-28">
    @foreach($listMenu as $list)
        <x-nav-link class="rounded-none px-3 pb-2 pt-3 text-slate-700 font-medium hover:bg-orange-400 hover:text-white" :href="$list[1]" :active="request()->routeIs('lppm')">
            {{ $list[0] }}
        </x-nav-link>
    @endforeach
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @foreach($listMenu as $list)
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ $list[0] }}
            </x-responsive-nav-link>
            @endforeach
        </div>
    </div>
</nav>