<x-user-layout>
    <x-slot name="title">
        {{ __('Tentang Organisasi') }}
    </x-slot>
    <x-user.header 
        :breadcrumbs="[['Home','home'],['Kelembagaan','kelembagaan_tentang']]"
        judul="Tentang Organisasi">
    </x-user.header>

    <div class="container py-5">
        <div class="row justify-content-md-center g-5">
            <div class="col-xl-9 ">
                <div class="card shadow wow animated zoomIn" data-wow-delay="0.2s">
                    <div class="card-body">
                        <div class="prose px-5">
                            {!! $text_about !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>