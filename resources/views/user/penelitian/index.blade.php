<x-user-layout>
    <x-slot name="title">
        {{ __('Penelitian') }}
    </x-slot>
    <x-user.header 
        :breadcrumbs="[['Home','home']]"
        judul="Penelitian">
    </x-user.header>

    <div class="container pb-5">
        <div class="row justify-content-md-center g-5">
            <div class="col-lg-5 text-center">
                <img class="img-fluid w-100" src="{{ asset('vendor/user/img/under-construction.png') }}" alt="">
                <p class="h1 pt-4 text-warning"><strong>Under Construction</strong></p>
            </div>
        </div>
    </div>
</x-user-layout>