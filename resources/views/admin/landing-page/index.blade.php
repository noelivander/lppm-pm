<x-admin-layout>
    <x-slot name="title">
        Landing Page Configuration
    </x-slot>

    <x-admin.heading name="Landing Page Configuration">
    </x-admin.heading>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-card mb-4">
        <div class="modern-card-header">
            <ul class="nav nav-tabs card-header-tabs" id="landingPageTabs" role="tablist">
                @foreach($contents as $section => $items)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $section }}-tab"
                            data-bs-toggle="tab" data-bs-target="#{{ $section }}" type="button" role="tab"
                            aria-controls="{{ $section }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ ucfirst($section) }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="modern-card-body">
            <form action="{{ route('admin.landing-page.update', 1) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="tab-content" id="landingPageTabsContent">
                    @foreach($contents as $section => $items)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $section }}"
                            role="tabpanel" aria-labelledby="{{ $section }}-tab">
                            <h5 class="mb-4 text-primary fw-bold text-uppercase">{{ ucfirst($section) }} Settings</h5>

                            <div class="row">
                                @foreach($items as $item)
                                    <div class="col-md-12 mb-3">
                                        <label for="content_{{ $item->id }}"
                                            class="form-label fw-semibold">{{ ucwords(str_replace('_', ' ', $item->key)) }}</label>

                                        @if($item->type === 'textarea')
                                            <textarea class="form-control" id="content_{{ $item->id }}"
                                                name="content_{{ $item->id }}" rows="4">{{ $item->value }}</textarea>
                                        @elseif($item->type === 'image')
                                            <div class="mb-2">
                                                @if($item->value)
                                                    <img src="{{ $item->value }}" alt="Current Image" class="img-thumbnail"
                                                        style="max-height: 150px;">
                                                @endif
                                            </div>
                                            <input type="file" class="form-control" id="content_{{ $item->id }}"
                                                name="content_{{ $item->id }}">
                                            <div class="form-text">Upload a new image to replace the current one.</div>
                                        @else
                                            <input type="text" class="form-control" id="content_{{ $item->id }}"
                                                name="content_{{ $item->id }}" value="{{ $item->value }}">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>