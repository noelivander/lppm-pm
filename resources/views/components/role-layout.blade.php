@php($role = Auth::user()->role ?? null)
@if($role === 'admin')
<x-admin-layout :hideFooter="$hideFooter ?? true">
    {{ $slot }}
</x-admin-layout>
@elseif($role === 'dosen')
<x-dosen-layout :hideFooter="$hideFooter ?? true">
    {{ $slot }}
</x-dosen-layout>
@elseif($role === 'reviewer')
<x-reviewer-layout :hideFooter="$hideFooter ?? true">
    {{ $slot }}
</x-reviewer-layout>
@elseif($role === 'auditor')
<x-auditor-layout :hideFooter="$hideFooter ?? true">
    {{ $slot }}
</x-auditor-layout>
@elseif($role === 'kaprodi')
<x-kaprodi-layout :hideFooter="$hideFooter ?? true">
    {{ $slot }}
</x-kaprodi-layout>
@else
<x-layouts.app>
    {{ $slot }}
</x-layouts.app>
@endif



