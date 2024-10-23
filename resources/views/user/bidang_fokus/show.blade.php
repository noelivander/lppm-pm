<x-user-layout>
    <x-slot name="title">
        {{ __('Struktur Organisasi') }}
    </x-slot>
    <x-user.header 
        :breadcrumbs="[['Home','home']]"
        judul="{{ $bidang_fokus->nama }}">
    </x-user.header>

    <div class="container py-5">
        <div class="row justify-content-md-center g-5">
            <div class="col-lg-9 ">
                <div class="card shadow wow animated zoomIn" data-wow-delay="0.2s">
                    <div class="card-body">
                        <div class="p-4">
                            {!! $deskripsi !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>