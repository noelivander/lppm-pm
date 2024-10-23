@aware(['listSubMenu' => [
    ['Penelitian', '/lppm/penelitian'],
    ['Pengabdian', '/lppm/pengabdian'],
    ['Agenda', '/lppm/agenda'],
]])

<x-sub-bar :listMenu="$listSubMenu" />