<x-user-layout>

    <x-user.header judul="{{ $berita->judul }}" user="{{$berita->user->name}}" tanggal="{{$berita->created_at->format('d M Y')}}">
    </x-user.header>

	<div class="container py-5">
		<div class="row g-5">
			<div class="col-lg-9">
				<div class="card shadow wow animated zoomIn h-100" data-wow-delay="0.2s">
					@if($berita->cover)
                       	<img src="{{ asset('storage/'.$berita->cover) }}" class="card-img-top" alt="Cover Berita">
                    @endif
					<div class="card-body">
						{!! $berita->isi !!}
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<x-user.right-side-contents></x-user.right-side-contents>
			</div>
		</div>
	</div>
</x-user-layout>