@props([
    'title',
    'value',
    'color' => 'primary'
])

<div class="dashboard-card h-100 fade-in-up">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-{{ $color }} text-uppercase mb-1">
                    {{ $title }}
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $value }}
                </div>
            </div>
            <div class="col-auto">
                {{ $slot }}
                @if(isset($icon))
                    <i class="{{ $icon }} text-gray-300"></i>
                @endif
            </div>
        </div>
    </div>
</div>