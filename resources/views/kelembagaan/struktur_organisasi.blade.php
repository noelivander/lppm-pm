<x-user-layout>
    <x-slot name="title">
        {{ __('Struktur Organisasi') }}
    </x-slot>

    <!-- Hero Section -->
    <section class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%);">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="display-4 fw-bold mb-3 animate-float">Struktur Organisasi</h1>
                    <p class="lead mb-0">Susunan organisasi dan kepemimpinan LPPM-PM ITH</p>
                </div>
            </div>
        </div>
        <!-- Floating Background Elements -->
        <div class="position-absolute" style="top: 10%; left: 5%; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 60%; right: 10%; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%; animation: float-delayed 8s ease-in-out infinite;"></div>
    </section>

    <!-- Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <!-- Organization Chart Visualization -->
                    <div class="card border-0 shadow-sm mb-5" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-body p-5">
                            <!-- Decorative Element -->
                            <div class="mb-4 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 20px;">
                                    <i class="fas fa-sitemap fa-2x" style="color: #4f46e5;"></i>
                                </div>
                                <h3 class="mt-4 mb-2" style="color: #1e1b4b; font-weight: 700;">Bagan Organisasi</h3>
                                <p class="text-muted">Struktur hierarki kepemimpinan LPPM-PM ITH</p>
                            </div>
                            
                            <!-- Organization Chart -->
                            <div class="org-chart-container" style="overflow-x: auto; padding: 2rem 0;">
                                <div class="org-chart">
                                    <!-- Level 1: Ketua -->
                                    <div class="org-level">
                                        <div class="org-card org-head">
                                            <div class="org-card-icon">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                            <div class="org-card-content">
                                                <h5>Ketua LPPM-PM</h5>
                                                <p class="text-muted mb-0">Kepala Lembaga</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Connector Line -->
                                    <div class="org-connector-vertical"></div>
                                    
                                    <!-- Level 2: Wakil & Sekretaris -->
                                    <div class="org-level">
                                        <div class="org-row">
                                            <div class="org-card org-deputy">
                                                <div class="org-card-icon">
                                                    <i class="fas fa-user-shield"></i>
                                                </div>
                                                <div class="org-card-content">
                                                    <h6>Wakil Ketua Bidang LPPM</h6>
                                                    <p class="text-muted mb-0 small">Penelitian & Pengabdian</p>
                                                </div>
                                            </div>
                                            
                                            <div class="org-card org-deputy">
                                                <div class="org-card-icon">
                                                    <i class="fas fa-user-shield"></i>
                                                </div>
                                                <div class="org-card-content">
                                                    <h6>Wakil Ketua Bidang PM</h6>
                                                    <p class="text-muted mb-0 small">Penjaminan Mutu</p>
                                                </div>
                                            </div>
                                            
                                            <div class="org-card org-secretary">
                                                <div class="org-card-icon">
                                                    <i class="fas fa-user-edit"></i>
                                                </div>
                                                <div class="org-card-content">
                                                    <h6>Sekretaris</h6>
                                                    <p class="text-muted mb-0 small">Administrasi</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Connector Lines -->
                                    <div class="org-connector-horizontal"></div>
                                    <div class="org-connector-vertical-group">
                                        <div class="org-connector-vertical-small"></div>
                                        <div class="org-connector-vertical-small"></div>
                                        <div class="org-connector-vertical-small"></div>
                                    </div>
                                    
                                    <!-- Level 3: Divisi/Unit -->
                                    <div class="org-level">
                                        <div class="org-row">
                                            <div class="org-card org-division">
                                                <div class="org-card-icon">
                                                    <i class="fas fa-flask"></i>
                                                </div>
                                                <div class="org-card-content">
                                                    <h6>Divisi Penelitian</h6>
                                                    <p class="text-muted mb-0 small">Koordinator Penelitian</p>
                                                </div>
                                            </div>
                                            
                                            <div class="org-card org-division">
                                                <div class="org-card-icon">
                                                    <i class="fas fa-hands-helping"></i>
                                                </div>
                                                <div class="org-card-content">
                                                    <h6>Divisi Pengabdian</h6>
                                                    <p class="text-muted mb-0 small">Koordinator Pengabdian</p>
                                                </div>
                                            </div>
                                            
                                            <div class="org-card org-division">
                                                <div class="org-card-icon">
                                                    <i class="fas fa-award"></i>
                                                </div>
                                                <div class="org-card-content">
                                                    <h6>Divisi Penjaminan Mutu</h6>
                                                    <p class="text-muted mb-0 small">Koordinator Mutu</p>
                                                </div>
                                            </div>
                                            
                                            <div class="org-card org-division">
                                                <div class="org-card-icon">
                                                    <i class="fas fa-file-alt"></i>
                                                </div>
                                                <div class="org-card-content">
                                                    <h6>Divisi Administrasi</h6>
                                                    <p class="text-muted mb-0 small">Staff Administrasi</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Text Content -->
                    <div class="card border-0 shadow-sm mb-5" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-body p-5">
                            <div class="mb-4 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 20px;">
                                    <i class="fas fa-info-circle fa-2x" style="color: #4f46e5;"></i>
                                </div>
                                <h3 class="mt-4 mb-2" style="color: #1e1b4b; font-weight: 700;">Informasi Struktur</h3>
                            </div>
                            
                            <!-- Content -->
                            <div class="prose" style="max-width: 100%; line-height: 1.8; color: #374151;">
                                {!! $text_stucture !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Organization Info Cards -->
                    <div class="row g-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="card border-0 shadow-sm h-100 text-center hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 15px;">
                                            <i class="fas fa-user-tie fa-2x" style="color: #4f46e5;"></i>
                                        </div>
                                    </div>
                                    <h5 style="color: #1e1b4b; font-weight: 600; margin-bottom: 0.5rem;">Kepemimpinan</h5>
                                    <p class="text-muted mb-0">Struktur kepemimpinan yang solid dan berpengalaman</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card border-0 shadow-sm h-100 text-center hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 15px;">
                                            <i class="fas fa-users fa-2x" style="color: #4f46e5;"></i>
                                        </div>
                                    </div>
                                    <h5 style="color: #1e1b4b; font-weight: 600; margin-bottom: 0.5rem;">Tim Profesional</h5>
                                    <p class="text-muted mb-0">SDM yang berkompeten dan berdedikasi tinggi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card border-0 shadow-sm h-100 text-center hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 15px;">
                                            <i class="fas fa-tasks fa-2x" style="color: #4f46e5;"></i>
                                        </div>
                                    </div>
                                    <h5 style="color: #1e1b4b; font-weight: 600; margin-bottom: 0.5rem;">Koordinasi</h5>
                                    <p class="text-muted mb-0">Sistem kerja yang terorganisir dengan baik</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card border-0 shadow-sm h-100 text-center hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <div class="d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 15px;">
                                            <i class="fas fa-chart-line fa-2x" style="color: #4f46e5;"></i>
                                        </div>
                                    </div>
                                    <h5 style="color: #1e1b4b; font-weight: 600; margin-bottom: 0.5rem;">Pengembangan</h5>
                                    <p class="text-muted mb-0">Peningkatan kualitas berkelanjutan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
    <style>
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            color: #1e1b4b;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }
        .prose p {
            margin-bottom: 1rem;
        }
        .prose ul, .prose ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 1.5rem 0;
        }
        
        /* Organization Chart Styles */
        .org-chart {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 900px;
        }
        
        .org-level {
            display: flex;
            justify-content: center;
            margin: 1rem 0;
        }
        
        .org-row {
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .org-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            min-width: 200px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .org-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .org-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .org-head .org-card-icon {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
        }
        
        .org-deputy .org-card-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
        
        .org-secretary .org-card-icon {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .org-division .org-card-icon {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }
        
        .org-card-content h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e1b4b;
            margin-bottom: 0.5rem;
        }
        
        .org-card-content h6 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e1b4b;
            margin-bottom: 0.5rem;
        }
        
        .org-card-content p {
            font-size: 0.85rem;
            margin: 0;
        }
        
        /* Connector Lines */
        .org-connector-vertical {
            width: 2px;
            height: 40px;
            background: linear-gradient(180deg, #7c3aed 0%, #c7d2fe 100%);
            margin: 0 auto;
        }
        
        .org-connector-horizontal {
            width: 80%;
            height: 2px;
            background: linear-gradient(90deg, #c7d2fe 0%, #7c3aed 50%, #c7d2fe 100%);
            margin: 0 auto;
        }
        
        .org-connector-vertical-group {
            display: flex;
            justify-content: space-around;
            width: 80%;
            margin: 0 auto;
        }
        
        .org-connector-vertical-small {
            width: 2px;
            height: 40px;
            background: linear-gradient(180deg, #7c3aed 0%, #c7d2fe 100%);
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .org-chart {
                min-width: 700px;
            }
            
            .org-row {
                gap: 1rem;
            }
            
            .org-card {
                min-width: 160px;
                padding: 1rem;
            }
            
            .org-card-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }
        }
        
        @media (max-width: 768px) {
            .org-chart {
                min-width: 600px;
            }
            
            .org-card {
                min-width: 140px;
                padding: 0.875rem;
            }
            
            .org-card-content h5 {
                font-size: 0.95rem;
            }
            
            .org-card-content h6 {
                font-size: 0.85rem;
            }
            
            .org-card-content p {
                font-size: 0.75rem;
            }
        }
    </style>
    @endpush
</x-user-layout>