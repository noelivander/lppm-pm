<x-user-layout>

    <x-user.header judul="{{ $agenda->judul }}" user="{{$agenda->user->name}}" tanggal="{{ $jadwal }}" link_text="Tautan Agenda" tag="{{ $agenda->tag }}" lokasi="{{ $agenda->lokasi }}">
    </x-user.header>

	<div class="container py-5">
		<div class="row g-5">
			<div class="col-lg-9">
				<div class="card shadow wow animated zoomIn h-100" data-wow-delay="0.2s">
					<div class="card-body">

						@if($agenda->cover)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$agenda->cover) }}" class="img-fluid" alt="Cover Berita">
                        </div>
                        @endif
                        
						<div class="px-lg-5 py-3">
							{!! $deskripsi !!}
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