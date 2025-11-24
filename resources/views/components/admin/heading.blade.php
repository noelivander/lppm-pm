@props([
    'name'
])
<!-- Page Heading -->
<div class="page-heading d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $name }}</h1>

    {{ $slot }}

    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<style>
    @media (max-width: 991.98px) {
        .page-heading {
            flex-direction: column;
            align-items: flex-start !important;
        }
        .page-heading > *:not(:first-child) {
            width: 100%;
            display: flex;
            justify-content: flex-start;
        }
        .page-heading .generate-report-btn {
            margin-top: 0.75rem;
        }
    }
</style>