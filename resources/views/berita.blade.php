<x-user-layout>
    <x-slot name="title">
        {{ __('Berita') }}
    </x-slot>
    <x-user.header :breadcrumbs="[['Home','home'],['Layanan','layanan-berita.index']]" judul="Berita" />

    <div class="container py-5">
        <div class="modern-card">
            <div class="modern-card-body">
                <p class="text-muted m-0">Daftar berita terbaru akan tampil di sini.</p>
            </div>
        </div>
    </div>
</x-user-layout>