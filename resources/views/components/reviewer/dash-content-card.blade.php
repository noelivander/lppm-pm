@props([
    'title', 'value', 'color'=>'green'
])

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-{{$color}} shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-{{$color}} text-uppercase mb-1">
                        <strong>{{ $title }}</strong></div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800"><strong>{{ $value }}</strong></div>
                </div>
                <div class="col-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>