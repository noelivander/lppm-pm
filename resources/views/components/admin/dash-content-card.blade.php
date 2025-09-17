@props([
    'title', 'value', 'color'=>'primary'
])

<div class="col-xl-3 col-md-6 mb-4">
    <div class="dashboard-card h-100 fade-in-up">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="card-title">
                        {{ $title }}
                    </div>
                    <div class="card-value">
                        {{ $value }}
                    </div>
                </div>
                <div class="col-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>