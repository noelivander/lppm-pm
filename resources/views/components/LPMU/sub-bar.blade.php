@aware(['listSubMenu' => [
    ['Dokumen', '/lpmu/dokumen'],
    ['Akreditasi', '/lpmu/akreditasi'],
    ['Agenda', '/lpmu/agenda'],
]])

<x-sub-bar :listMenu="$listSubMenu" />