<x-user-layout>
    <x-slot name="title">
        {{ __($dokumen->judul) }}
    </x-slot>
    <x-user.header 
        judul="{{ $dokumen->judul }}"  tanggal="{{$dokumen->created_at->format('d M Y')}}">
    </x-user.header>

    <div class="container py-5">
        <div class="row justify-content-md-center g-5">
            <div class="col-lg-9 ">
                <div class="modern-card wow animated zoomIn fade-in-up" data-wow-delay="0.2s">
                    <div class="modern-card-body p-0">
                        <embed src="{{ asset('storage/'.$dokumen->file) }}" type="application/pdf" width="100%" height="720px" class="pt-1">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>