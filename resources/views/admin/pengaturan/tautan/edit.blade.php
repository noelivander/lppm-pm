<x-admin-layout>
    <x-slot name="header">
        {{ __('Pengaturan/Tautan') }}
    </x-slot>

    <x-admin.heading name="Edit Tautan">
        <a href="{{ route('related_link.index') }}" class="modern-btn modern-btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Kembali
        </a>
    </x-admin.heading>

    @if (session('success'))
        <div class="modern-alert modern-alert-success mb-3 fade-in-up">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="modern-alert modern-alert-danger mb-3 fade-in-up">
            <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="modern-card mb-4 fade-in-up">
                <div class="modern-card-header">
                    <h5 class="mb-0">
                        <i class="fa fa-edit me-2"></i>Edit Tautan
                    </h5>
                </div>
                <form method="POST" action="{{ route('related_link.update', ['related_link' => $related_link->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modern-card-body">
                        <div class="modern-form-group">
                            <label for="nama" class="modern-form-label"><i class="fa fa-font me-2"></i>Nama <span class="text-danger">*</span></label>
                            <input id="nama" type="text" class="modern-form-input" name="nama" value="{{ old('nama', $related_link->nama) }}" placeholder="Masukkan nama tautan..." required>
                            @if ($errors->has('nama'))
                                <div class="text-danger small mt-1">{{ $errors->first('nama') }}</div>
                            @endif
                        </div>
                        <div class="modern-form-group">
                            <label for="url" class="modern-form-label"><i class="fa fa-link me-2"></i>URL <span class="text-danger">*</span></label>
                            <input id="url" type="url" class="modern-form-input" name="url" value="{{ old('url', $related_link->url) }}" placeholder="https://example.com" required>
                            @if ($errors->has('url'))
                                <div class="text-danger small mt-1">{{ $errors->first('url') }}</div>
                            @endif
                        </div>
                        <p class="text-muted small mt-3 mb-0">* Wajib diisi</p>
                    </div>
                    <div class="modern-card-footer d-flex gap-2">
                        <a href="{{ route('related_link.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fa fa-times me-1"></i> Batalkan
                        </a>
                        <button type="submit" class="modern-btn modern-btn-primary">
                            <i class="fa fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

