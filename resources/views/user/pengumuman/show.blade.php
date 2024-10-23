<x-user-layout>

    <x-user.header judul="{{ $pengumuman->judul }}" user="{{$pengumuman->user->name}}" tanggal="{{$pengumuman->created_at->format('d M Y')}}" link="{{ asset('storage/'.$pengumuman->dokumen) ? ($pengumuman->dokumen) : '' }}" link_text="Dokumen Pengumuman" tag="{{ $pengumuman->tag }}">
    </x-user.header>

	<div class="container py-5">
		<div class="row g-5">
			<div class="col-lg-9">
				<div class="card shadow wow animated zoomIn h-100" data-wow-delay="0.2s">
					<div class="card-body">
						@if($pengumuman->cover)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$pengumuman->cover) }}" class="img-fluid" alt="Cover Berita">
                        </div>
                        @endif
						<div>
							{!! $pengumuman->isi !!}
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<x-user.right-side-contents></x-user.right-side-contents>
			</div>
		</div>
	</div>
</x-user-layout>