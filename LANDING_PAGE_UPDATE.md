# 🎨 Landing Page Modern Update - LPPM-PM ITH

## 📋 Overview
Landing Page telah diperbarui dengan desain modern, responsif, dan informatif menggunakan kombinasi warna **Ungu Indigo** sebagai tema utama. Semua data terintegrasi langsung dari Backend/Database.

---

## ✨ Fitur Utama yang Ditambahkan

### 1. **Hero Section dengan Image Slider**
- ✅ **Carousel 3 Gambar Kampus** dengan auto-slide (4 detik interval)
- ✅ **Gradient Background** Indigo Purple yang menarik
- ✅ **Animated Background Elements** (floating circles)
- ✅ **Quick Stats Cards** menampilkan data real-time:
  - Total Penelitian (dari database)
  - Total Pengabdian (dari database)
  - Total Dosen (dari database)
  - Total Program Studi (dari database)
- ✅ **CTA Buttons** dengan hover effects
- ✅ **Floating Info Cards** (Terakreditasi BAN-PT, Kerjasama Internasional)
- ✅ **Scroll Indicator** animasi bounce

### 2. **Warna & Design System**
- **Primary Colors**:
  - `#1e1b4b` - Indigo 900 (Dark)
  - `#312e81` - Indigo 800
  - `#4c1d95` - Purple 900
  - `#5b21b6` - Purple 800
  - `#6d28d9` - Purple 700
  - `#7c3aed` - Purple 600 (Main)
  - `#a78bfa` - Purple 400 (Light)
  - `#c4b5fd` - Purple 300
  - `#e0e7ff` - Indigo 100 (Very Light)

### 3. **Animasi & Interaktivitas**
- ✅ **Scroll Reveal Animation** - Elemen muncul saat di-scroll
- ✅ **Float Animation** - Background elements bergerak halus
- ✅ **Hover Effects** - Transform & shadow pada hover
- ✅ **Counter Animation** - Angka statistik naik otomatis
- ✅ **Smooth Scroll** - Navigasi halus antar section

### 4. **Section-Section yang Diperbarui**

#### **Hero Section**
- Full-screen height (100vh)
- Image slider dengan caption
- Data statistik terintegrasi dari backend
- Gradient background dengan animated elements
- Responsive untuk semua device

#### **Keunggulan Section**
- 3 Card keunggulan dengan icon
- 4 Stats card dengan data real-time
- Dark indigo background dengan blur effects

#### **Pencapaian & Statistik**
- 4 Counter cards dengan animasi
- Grafik tren penelitian (bar chart sederhana)
- Distribusi bidang penelitian

#### **Berita & Pengumuman**
- **Berita Section** (8 kolom):
  - Menampilkan 3 berita terbaru dari database
  - Card dengan gambar cover
  - Tanggal publikasi
  - Excerpt berita
  - Button "Baca Selengkapnya"
  - Fallback jika tidak ada berita
- **Pengumuman Section** (4 kolom):
  - Static pengumuman (bisa diubah ke dynamic)
  - Badge status (Aktif, Mendatang, Berlangsung)

---

## 📁 File yang Dibuat/Diubah

### **File Baru:**
1. **`public/css/landing-page.css`**
   - Semua animasi dan style khusus landing page
   - Keyframes untuk float, bounce, fadeIn, dll
   - Utility classes untuk reveal, gradient-text, dll
   - Custom carousel styles
   - Modern button styles
   - Responsive utilities

### **File Diubah:**
1. **`resources/views/user/home.blade.php`**
   - Hero section dengan image slider
   - Section berita yang lebih menarik
   - Data terintegrasi dari backend

2. **`resources/views/layouts/user-v2/app.blade.php`**
   - Menambahkan link ke `landing-page.css`

---

## 🎯 Data yang Terintegrasi dari Backend

### **Dari Controller (`HomeController.php`):**
```php
$berita = Berita::orderBy('created_at','desc')->take(3)->get();
$totalPenelitian = Penelitian::count();
$totalPengabdian = Pengabdian::count();
$totalDosen = Pegawai::count();
$totalProdi = ProgramStudi::count();
$totalBerita = Berita::count();
```

### **Ditampilkan di View:**
- ✅ `{{ $totalPenelitian }}` - Jumlah penelitian
- ✅ `{{ $totalPengabdian }}` - Jumlah pengabdian
- ✅ `{{ $totalDosen }}` - Jumlah dosen
- ✅ `{{ $totalProdi }}` - Jumlah program studi
- ✅ `{{ $totalBerita }}` - Jumlah berita
- ✅ `@foreach($berita as $value)` - Loop berita terbaru
  - Cover image
  - Judul
  - Excerpt
  - Tanggal
  - Link detail

---

## 📱 Responsivitas

### **Desktop (> 991px)**
- Hero section full width dengan 2 kolom
- Image slider 500px height
- Semua section optimal

### **Tablet (768px - 991px)**
- Hero section tetap 2 kolom tapi lebih compact
- Image slider 350px height
- Font size disesuaikan

### **Mobile (< 768px)**
- Hero section menjadi 1 kolom (stacked)
- Image slider 250px height
- Font size lebih kecil
- Padding & spacing disesuaikan
- Stats cards 2 kolom per row

---

## 🎨 Animasi yang Tersedia

### **CSS Animations:**
```css
@keyframes float - Floating effect untuk background
@keyframes bounce - Bouncing effect untuk scroll indicator
@keyframes fadeInUp - Fade in dari bawah
@keyframes slideInRight - Slide in dari kanan
@keyframes shimmer - Shimmer effect
```

### **JavaScript Animations:**
- **Scroll Reveal** - Elemen muncul saat di-scroll
- **Counter Animation** - Angka naik otomatis
- **Smooth Scroll** - Scroll halus ke anchor

---

## 🚀 Cara Menggunakan

### **1. Pastikan File CSS Sudah Ter-load**
File `landing-page.css` sudah ditambahkan di layout:
```html
<link href="{{ asset('css/landing-page.css') }}" rel="stylesheet">
```

### **2. Ganti Gambar Slider**
Edit di `home.blade.php`, section carousel:
```html
<img src="URL_GAMBAR_ANDA" class="d-block w-100" alt="Kampus ITH">
```

**Rekomendasi:**
- Upload gambar kampus ke `public/img/`
- Gunakan path: `{{ asset('img/kampus-1.jpg') }}`
- Ukuran optimal: 1470x500px
- Format: JPG/PNG

### **3. Ubah Warna (Opsional)**
Jika ingin mengubah warna, edit di `landing-page.css`:
```css
/* Ganti nilai hex color */
background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
```

---

## 🎯 Komponen yang Bisa Digunakan Ulang

### **Modern Button:**
```html
<a href="#" class="btn btn-lg px-5 py-3" 
   style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); 
          color: white; border-radius: 50px; font-weight: 600;">
    Button Text
</a>
```

### **Gradient Text:**
```html
<h2 class="gradient-text">Your Text</h2>
```

### **Reveal Animation:**
```html
<div class="reveal" style="animation-delay: 0.1s;">
    Content akan muncul saat di-scroll
</div>
```

### **Hover Lift Effect:**
```html
<div class="hover-lift">
    Card akan terangkat saat di-hover
</div>
```

---

## 📊 Performa & Optimasi

### **Optimasi yang Sudah Dilakukan:**
- ✅ Lazy loading untuk images
- ✅ CSS animations menggunakan transform (GPU accelerated)
- ✅ Minimal JavaScript untuk animasi
- ✅ Carousel auto-pause saat tidak terlihat
- ✅ Smooth scroll dengan CSS

### **Tips Tambahan:**
- Compress gambar sebelum upload (gunakan TinyPNG)
- Gunakan WebP format untuk gambar modern
- Enable browser caching
- Minify CSS di production

---

## 🔧 Troubleshooting

### **Animasi Tidak Jalan:**
1. Pastikan `landing-page.css` ter-load
2. Cek console browser untuk error
3. Pastikan JavaScript di `app.blade.php` ter-load

### **Gambar Tidak Muncul:**
1. Cek path gambar di `home.blade.php`
2. Pastikan gambar ada di folder `public/`
3. Run `php artisan storage:link` jika menggunakan storage

### **Data Tidak Muncul:**
1. Cek `HomeController.php` sudah pass data ke view
2. Pastikan ada data di database
3. Cek nama variable di view sesuai dengan controller

---

## 📞 Kontak & Support

Jika ada pertanyaan atau butuh bantuan:
- Check dokumentasi Laravel: https://laravel.com/docs
- Bootstrap 5: https://getbootstrap.com/docs/5.0
- Font Awesome Icons: https://fontawesome.com/icons

---

## 🎉 Selesai!

Landing Page LPPM-PM ITH sekarang sudah modern, responsif, dan informatif dengan:
- ✅ Hero section dengan image slider
- ✅ Warna ungu indigo yang konsisten
- ✅ Data terintegrasi dari backend
- ✅ Animasi smooth dan menarik
- ✅ Responsif untuk semua device
- ✅ Performance optimal

**Selamat menggunakan! 🚀**
