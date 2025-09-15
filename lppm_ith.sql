-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2025 at 04:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lppm_ith`
--

-- --------------------------------------------------------

--
-- Table structure for table `agendas`
--

CREATE TABLE `agendas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `jadwal` timestamp NULL DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 0,
  `tautan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `jadwal_akhir` timestamp NULL DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agendas`
--

INSERT INTO `agendas` (`id`, `user_id`, `tag`, `judul`, `lokasi`, `slug`, `jadwal`, `deskripsi`, `is_shown`, `tautan`, `created_at`, `updated_at`, `deleted_at`, `jadwal_akhir`, `cover`) VALUES
(1, 7, 'a', 'dwada', 'wadasd', '1757401291-dwada', '2025-09-09 07:00:00', 'agenda/text/1757401291-dwada.txt', 1, 'https://www.google.com', '2025-09-09 07:01:31', '2025-09-09 07:01:31', NULL, '2025-09-19 07:00:00', 'agenda/2025/1757401291-—Pngtree—black latter a_6212817.png');

-- --------------------------------------------------------

--
-- Table structure for table `anggotas`
--

CREATE TABLE `anggotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penelitian_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nidn` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `peran` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggotas`
--

INSERT INTO `anggotas` (`id`, `penelitian_id`, `nama`, `nidn`, `jabatan`, `peran`, `email`, `telepon`, `created_at`, `updated_at`) VALUES
(63, 35, 'iWF2q7ep3bnl7MJ5oF15Zw==', 'oDGkoFL8CEPM1vmOCHU1yw==', 'JSUT4zNwi3phW9VrngFwRw==', 'Ketua', 'aSNrIhQXQMuO4pfn9w4M9/Q/gRS+cHnxl0ynBcSdI/E=', 'eXci4yCC65MzsNyRIZ7ljg==', '2024-12-24 03:26:01', '2024-12-24 03:26:01'),
(64, 35, 'PU2BUOAa22PIBmPySqd/Ew==', 'oDGkoFL8CEPM1vmOCHU1yw==', 'JSUT4zNwi3phW9VrngFwRw==', 'Anggota', 'aoHu5TRCVWQUMDdmgMiPyWKf8QgCreUKPCCWwGTPhEg=', 'eXci4yCC65MzsNyRIZ7ljg==', '2024-12-24 03:26:01', '2024-12-24 03:26:01'),
(65, 36, 'iWF2q7ep3bnl7MJ5oF15Zw==', 'oDGkoFL8CEPM1vmOCHU1yw==', 'hVbobWXeXUfmtuVB6KJ0iA==', 'Ketua', 'aSNrIhQXQMuO4pfn9w4M9/Q/gRS+cHnxl0ynBcSdI/E=', 'eXci4yCC65MzsNyRIZ7ljg==', '2024-12-24 06:49:27', '2024-12-24 06:49:27'),
(66, 37, 'PU2BUOAa22PIBmPySqd/Ew==', 'HdVtu5RopIRMW5z99tAfrA==', 'hVbobWXeXUfmtuVB6KJ0iA==', 'Ketua', 'aSNrIhQXQMuO4pfn9w4M9/Q/gRS+cHnxl0ynBcSdI/E=', 'eXci4yCC65MzsNyRIZ7ljg==', '2024-12-27 00:21:10', '2024-12-27 00:21:10'),
(67, 37, 'iWF2q7ep3bnl7MJ5oF15Zw==', 'oDGkoFL8CEPM1vmOCHU1yw==', 'JSUT4zNwi3phW9VrngFwRw==', 'Anggota', 'dvQadWxcp4IrLQTifd0PR10Bf19RfmOQoq1qCGYahGQ=', 'yeh3cPLs4+316ius6aKy1g==', '2024-12-27 00:21:10', '2024-12-27 00:21:10'),
(68, 38, 'iWF2q7ep3bnl7MJ5oF15Zw==', 'oDGkoFL8CEPM1vmOCHU1yw==', 'hVbobWXeXUfmtuVB6KJ0iA==', 'Ketua', 'aSNrIhQXQMuO4pfn9w4M9/Q/gRS+cHnxl0ynBcSdI/E=', 'eXci4yCC65MzsNyRIZ7ljg==', '2024-12-27 10:12:43', '2024-12-27 10:12:43'),
(69, 38, 'PU2BUOAa22PIBmPySqd/Ew==', 'oDGkoFL8CEPM1vmOCHU1yw==', 'JSUT4zNwi3phW9VrngFwRw==', 'Anggota', 'aoHu5TRCVWQUMDdmgMiPyWKf8QgCreUKPCCWwGTPhEg=', 'eXci4yCC65MzsNyRIZ7ljg==', '2024-12-27 10:12:43', '2024-12-27 10:12:43'),
(70, 39, 'C2zI4Vh+w5HLgq8ASyGEIQ==', 'pFHyH1XD0ocemdo3xvHY8w==', 'hVbobWXeXUfmtuVB6KJ0iA==', 'Ketua', 'jnH8OhcC/2eUim0GP2ommCT/+YokyxHNw4veH0MVRaU=', 'gfL/jAFRH5LfZuNek9ESgw==', '2025-01-06 07:28:47', '2025-01-06 07:28:47'),
(71, 40, 'iWF2q7ep3bnl7MJ5oF15Zw==', 'oDGkoFL8CEPM1vmOCHU1yw==', 'JSUT4zNwi3phW9VrngFwRw==', 'Ketua', 'dvQadWxcp4IrLQTifd0PR10Bf19RfmOQoq1qCGYahGQ=', 'eXci4yCC65MzsNyRIZ7ljg==', '2025-01-07 00:59:23', '2025-01-07 00:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `anggota_pengabdians`
--

CREATE TABLE `anggota_pengabdians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengabdian_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nidn` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `peran` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota_pengabdians`
--

INSERT INTO `anggota_pengabdians` (`id`, `pengabdian_id`, `nama`, `nidn`, `jabatan`, `peran`, `email`, `telepon`, `created_at`, `updated_at`) VALUES
(10, 8, 'iWF2q7ep3bnl7MJ5oF15Zw==', 'oDGkoFL8CEPM1vmOCHU1yw==', 'hVbobWXeXUfmtuVB6KJ0iA==', 'Ketua', 'aSNrIhQXQMuO4pfn9w4M9/Q/gRS+cHnxl0ynBcSdI/E=', 'eXci4yCC65MzsNyRIZ7ljg==', '2024-12-24 02:34:56', '2024-12-24 02:34:56'),
(11, 8, 'PU2BUOAa22PIBmPySqd/Ew==', 'SErw5vX0PvjKHHu6lxSEPQ==', 'JSUT4zNwi3phW9VrngFwRw==', 'Anggota', 'nyDJ2MQoRV1gXzPX8e6DmA==', 'dcqcASh+muBkluLV8DnbVg==', '2024-12-24 02:34:56', '2024-12-24 02:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text DEFAULT NULL,
  `dokumen` varchar(255) DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `slug`, `user_id`, `judul`, `isi`, `dokumen`, `is_shown`, `created_at`, `updated_at`, `deleted_at`, `cover`, `tag`) VALUES
(1, '1757399273-tes123', 7, 'tes123', 'adasdasdawdasdawd', 'pengumuman/2025/1757399273-KHS_20221_221031002_NOEL IVANDER PUSUNG.pdf', 1, '2025-09-09 06:27:53', '2025-09-09 07:03:19', NULL, 'pengumuman/2025/sampul/1757399273-—Pngtree—black latter b_6212819.png', 'effsd');

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `id` int(10) UNSIGNED NOT NULL,
  `bannable_type` varchar(255) NOT NULL,
  `bannable_id` bigint(20) UNSIGNED NOT NULL,
  `created_by_type` varchar(255) DEFAULT NULL,
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_penting`
--

CREATE TABLE `dokumen_penting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `folder` varchar(255) DEFAULT NULL,
  `label` int(11) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 0,
  `is_lock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumen_penting`
--

INSERT INTO `dokumen_penting` (`id`, `slug`, `judul`, `cover`, `file`, `folder`, `label`, `urutan`, `is_shown`, `is_lock`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'pengecekan-similarity-artikel-ilmiah-menggunakan-turnitin', 'Pengecekan Similarity Artikel Ilmiah Menggunakan Turnitin', 'dokumen_penting/sampul/01-pengecekan-similarity.png', 'dokumen_penting/1664095367-1664095367-pedoman-pengecekan-plagiarisme-turnitin.pdf', NULL, NULL, 1, 0, 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(2, 'roadmap-roadmap-penelitian-ith-2023', 'Roadmap Penelitian ITH 2023', 'dokumen_penting/sampul/1757402253-—Pngtree—black latter b_6212819.png', 'dokumen_penting/1757402253-roadmap-roadmap-penelitian-ith-2023.pdf', NULL, 0, 1, 1, 0, '2024-10-04 08:33:59', '2025-09-09 07:17:33', NULL),
(3, 'pedoman-pedoman-penelitian-dan-pengabdian-kedapa-masyarakat-ith-2023', 'Pedoman Penelitian dan Pengabdian kedapa Masyarakat ITH 2023', 'dokumen_penting/sampul/1757398998-WhatsApp Image 2025-07-24 at 18.25.26_277227a4.jpg', 'dokumen_penting/1757398955-pedoman-pedoman-penelitian-dan-pengabdian-kedapa-masyarakat-ith-2023.pdf', NULL, 0, 1, 1, 0, '2024-10-04 08:33:59', '2025-09-09 06:23:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flags`
--

CREATE TABLE `flags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `filter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `is_fungsional` int(11) NOT NULL,
  `tingkatan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `kode`, `nama`, `tahun`, `urutan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'tpi', 'Teknologi Produksi dan Industri', '2022', 1, NULL, NULL, NULL),
(2, 'sci', 'Sains', '2022', 2, NULL, NULL, NULL),
(3, 'adw3d2', 'tes', '1234', NULL, NULL, NULL, '2025-09-09 07:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(22, '2024_06_12_120520_create_dosen_table', 2),
(24, '2024_06_24_170733_create_proposals_table', 4),
(27, '2024_09_11_130019_add_tanggal_mulai_selesai_to_penelitian_table', 7),
(28, '2024_09_11_130046_add_tanggal_mulai_selesai_to_pengabdian_table', 7),
(29, '2024_09_13_143648_create_anggota_penelitian_table', 8),
(33, '2024_09_30_142526_create_reviews_table', 12),
(36, '2024_10_02_164452_add_review_pdf_to_reviews_table', 15),
(67, '2024_10_04_144447_create_reviews_table', 18),
(68, '2014_10_12_000000_create_users_table', 19),
(69, '2014_10_12_100000_create_password_resets_table', 19),
(70, '2019_08_19_000000_create_failed_jobs_table', 19),
(71, '2019_12_14_000001_create_personal_access_tokens_table', 19),
(72, '2022_06_22_232557_create_news_table', 19),
(73, '2022_06_22_232630_create_announcements_table', 19),
(74, '2022_06_23_232718_create_related_links_table', 19),
(75, '2022_07_01_025405_create_agendas_table', 19),
(76, '2022_07_29_035533_create_jabatan_table', 19),
(77, '2022_07_29_035545_create_golongan_table', 19),
(78, '2022_07_29_035611_create_jurusan_table', 19),
(79, '2022_07_29_035625_create_program_studi_table', 19),
(80, '2022_07_29_035645_create_pegawai_table', 19),
(81, '2022_09_17_095302_create_dokumen_penting_table', 19),
(82, '2022_09_28_094329_create_ppm_jenis_hibah_table', 19),
(83, '2022_09_28_094340_create_ppm_hibah_table', 19),
(84, '2022_09_28_094357_create_ppm_skema_table', 19),
(85, '2022_09_28_094420_create_ppm_luaran_table', 19),
(86, '2022_09_28_102201_create_ppm_fokus_bidang_table', 19),
(87, '2022_09_28_102226_create_ppm_table', 19),
(88, '2024_01_12_202702_update_agendas_announcements_table', 19),
(89, '2024_06_12_213042_add_role_to_users_table', 19),
(90, '2024_06_25_115110_create_penelitians_table', 19),
(91, '2024_06_25_115110_create_pengabdians_table', 19),
(94, '2024_09_30_141937_create_reviews_table', 19),
(95, '2024_09_13_150234_create_anggotas_table', 20),
(96, '2024_09_23_141206_create_anggota_pengabdians_table', 20),
(97, '2024_09_30_144258_create_review_table', 21),
(99, '2024_11_06_183007_create_review_table', 22),
(101, '2024_11_06_185009_create_review_table', 23),
(102, '2024_11_06_185033_create_id_review_table', 23),
(103, '2024_11_06_230930_add_jabatan_to_anggotas_table', 24),
(104, '2024_11_06_231525_add_jabatan_to_anggotas_pengabdian_table', 25),
(108, '2024_11_06_234058_add_nidn_to_anggotas_table', 26),
(109, '2024_11_06_234135_add_jabatan_to_anggotas_pengabdian_table', 26),
(110, '2024_11_14_130353_update_table_review', 26),
(111, '2024_11_19_234957_add_sinta_index_to_penelitian_table', 27),
(112, '2024_11_19_235102_add_sinta_index_to_pengabdian_table', 28),
(113, '2024_11_20_234531_add_reviewer_name_to_reviews_table', 29),
(114, '2024_12_23_105954_modify_biaya_diusulkan_to_text_in_penelitians', 30),
(115, '2024_12_24_103411_modify_biaya_diusulkan', 31),
(116, '2017_03_04_000000_create_bans_table', 32),
(117, '2024_12_25_000000_create_timelines_table', 33),
(118, '2025_02_03_133447_update_timelines_table', 34),
(119, '2025_09_09_000001_add_avatar_to_users_table', 35);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `user_id`, `slug`, `judul`, `isi`, `cover`, `is_shown`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 7, '1757401348-tes123', 'tes123', 'sadawdasdada\r\nadasd\r\na\r\nda\r\nd\r\nda\r\nd\r\n\r\n\r\n\r\nadwadadsa', 'berita/2025/1757401348-WhatsApp Image 2025-09-04 at 08.40.05_88a63f36.jpg', 1, '2025-09-09 07:02:28', '2025-09-09 07:02:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pangkat_golongan_ruang`
--

CREATE TABLE `pangkat_golongan_ruang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `pangkat` varchar(255) NOT NULL,
  `golongan` varchar(255) NOT NULL,
  `ruang` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pangkat_golongan_ruang`
--

INSERT INTO `pangkat_golongan_ruang` (`id`, `kode`, `pangkat`, `golongan`, `ruang`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'i-a', 'Juru Muda', 'I', 'a', NULL, NULL, NULL),
(2, 'i-b', 'Juru Muda Tingkat I', 'I', 'b', NULL, NULL, NULL),
(3, 'i-c', 'Juru', 'I', 'c', NULL, NULL, NULL),
(4, 'i-d', 'Juru Tingkat I', 'I', 'd', NULL, NULL, NULL),
(5, 'ii-a', 'Pengatur Muda', 'II', 'a', NULL, NULL, NULL),
(6, 'ii-b', 'Pengatur Muda Tingkat I', 'II', 'b', NULL, NULL, NULL),
(7, 'ii-c', 'Pengatur', 'II', 'c', NULL, NULL, NULL),
(8, 'ii-d', 'Pengatur Tingkat I', 'II', 'd', NULL, NULL, NULL),
(9, 'iii-a', 'Penata Muda', 'III', 'a', NULL, NULL, NULL),
(10, 'iii-b', 'Penata Muda Tingkat I', 'III', 'b', NULL, NULL, NULL),
(11, 'iii-c', 'Penata', 'III', 'c', NULL, NULL, NULL),
(12, 'iii-d', 'Penata Tingkat I', 'III', 'd', NULL, NULL, NULL),
(13, 'iv-a', 'Pembina', 'IV', 'a', NULL, NULL, NULL),
(14, 'iv-b', 'Pembina Tingkat I', 'IV', 'b', NULL, NULL, NULL),
(15, 'iv-c', 'Pembina Utama Muda', 'IV', 'c', NULL, NULL, NULL),
(16, 'iv-d', 'Pembina Utama Madya', 'IV', 'd', NULL, NULL, NULL),
(17, 'iv-e', 'Pembina Utama', 'IV', 'e', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `program_studi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jabatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pangkat_golongan_ruang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `user_id`, `program_studi_id`, `jabatan_id`, `pangkat_golongan_ruang_id`, `nama`, `email`, `foto`, `nip`, `is_shown`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, NULL, 17, 'Prof. Dr. Ir. ANSAR SUYUTI, MT., IPU., ASEAN.Eng.', NULL, NULL, '196712311992021001', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(2, NULL, NULL, NULL, 13, 'DR. Ir. MOHAMMAD MOCHSEN SIR, S.T., M.T.', NULL, NULL, '196904071996031003', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(3, NULL, NULL, NULL, 13, 'DR.Eng. ARMIN LAWI, S.Si., M.Eng.', NULL, NULL, '197204231995121001', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(4, NULL, NULL, NULL, 15, 'DR.Eng. INTAN SARI ARENI, S.T., M.T.', NULL, NULL, '197502032000122002', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(5, NULL, NULL, NULL, 14, 'DR. ANDI ILHAM LATUNRA, M.Si.', NULL, NULL, '196702071991031001', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(6, NULL, NULL, NULL, 13, 'DR. INDAR CHAERAH GUNADIN, S.T., M.T.', NULL, NULL, '197311181998032001', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(7, NULL, NULL, NULL, 10, 'DR. Ir. Abdullah B., M.M.', NULL, NULL, '196612311997031039', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(8, NULL, 2, NULL, 10, 'PUTRI AYU MAHARANI, S.T., M.Sc.', NULL, NULL, '199406112022032020', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(9, NULL, 2, NULL, 10, 'NAILI SURI INTIZHAMI, S.Kom., M.Kom.', NULL, NULL, '199503082022032016', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(10, NULL, 2, NULL, 10, 'EKA QADRI NURANTI B., S.Kom., M.Kom.', NULL, NULL, '199502082022032010', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(11, NULL, 2, NULL, 10, 'MARDHIYYAH RAFRIN, S.T., M.Sc.', NULL, NULL, '199009212022032011', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(12, NULL, 2, NULL, 10, 'MUH. AGUS, S.Kom., M.Kom.', NULL, NULL, '199508212022031011', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(13, NULL, 1, NULL, 10, 'NUR RAHMI, S.Pd., M.Si.', NULL, NULL, '199210062022032015', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(14, NULL, 1, NULL, 10, 'WAHYUNI EKASASMITA, S.Pd., M.Sc.', NULL, NULL, '199104132022032015', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(15, NULL, 1, NULL, 10, 'AHMAD FAJRI S., S.Si., M.Si.', NULL, NULL, '199505082022031009', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(16, NULL, 1, NULL, 10, 'MIFTAHULKHAIRAH, M.Sc.', NULL, NULL, '198809222022032002', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(17, NULL, 1, NULL, 10, 'NURUL FUADY ADHALIA H, S.Pd., M.Si.', NULL, NULL, '199012102022032007', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(18, NULL, 3, NULL, 10, 'MAR\'ATUTTAHIRAH, S.Pd., M.T.', NULL, NULL, '199407012022032017', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(19, NULL, 3, NULL, 10, 'ROSMIATI, S.Kom., M.Kom.', NULL, NULL, '199003282022032006', 0, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(20, NULL, 3, NULL, 10, 'KHAERA TUNNISA, S.Tr.Kom., M.Kom.', NULL, NULL, '199605062022032021', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(21, NULL, 3, NULL, 10, 'RAKHMADI RAHMAN, M.Kom.', NULL, NULL, '199003162022031006', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(22, NULL, 3, NULL, 10, 'ALVIAN TRI PUTRA DARTI AKHSA, S.Kom., M.Kom.', NULL, NULL, '199402192022031007', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(23, NULL, NULL, NULL, 13, 'MUH. ALIFAKHMI, S.Sos., M.M.', NULL, NULL, '197708032006041008', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(24, NULL, NULL, NULL, 12, 'MUHAMMAD IRSYAD A. RAHMAN, S.E., M.Eng.', NULL, NULL, '197310282006041010', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(25, NULL, NULL, NULL, 12, 'MULIANI BACO, S.E.', NULL, NULL, '197809142007012016', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(26, NULL, NULL, NULL, 12, 'AMSIR, S.T.', NULL, NULL, '197806272009041003', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(27, NULL, NULL, NULL, 11, 'LILIS, S.E., M.M.', NULL, NULL, '198407072007011002', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(28, NULL, NULL, NULL, 9, 'SITTI MULYANA M, S.Pd.', NULL, NULL, '198608012010012011', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(29, NULL, NULL, NULL, 7, 'DWIRATY SESARI WALALANGI, A.Md.', NULL, NULL, '199103222022032011', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(30, NULL, NULL, NULL, 7, 'MUSFADLI, A.Ma.', NULL, NULL, '198901252022031004', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(31, NULL, NULL, NULL, 7, 'HASMI SISWANTI HANDAYANI S, A.Ma., Ak.', NULL, NULL, '200010222022032001', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(32, NULL, NULL, NULL, 7, 'AYU ANUGRAH, A.Ma., M', NULL, NULL, '199901282022032010', 0, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penelitians`
--

CREATE TABLE `penelitians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `luaran_wajib` varchar(255) NOT NULL,
  `lama_penelitian` varchar(255) NOT NULL,
  `biaya_diusulkan` text DEFAULT NULL,
  `skema` varchar(255) NOT NULL,
  `luaran_tambahan` varchar(255) DEFAULT NULL,
  `ringkasan_proposal` text NOT NULL,
  `dokumen_proposal` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sinta_index` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penelitians`
--

INSERT INTO `penelitians` (`id`, `judul`, `luaran_wajib`, `lama_penelitian`, `biaya_diusulkan`, `skema`, `luaran_tambahan`, `ringkasan_proposal`, `dokumen_proposal`, `status`, `user_id`, `created_at`, `updated_at`, `sinta_index`) VALUES
(35, 'OAXJjx3Iyny3jLgCtHgPH2We7Q+GLaa2atA5iex+jMA=', 'DSQCE7ZK3EkYPrWyLCp6jdKq2Is8E/65o8IgDbZktCk=', '9zj8o1w7Rz9R/p4ZqT96rA==', 'f0VIdKC9TFWW4KjQWIZbdA==', 'i7o+N58r0RlzmRQxU9qS52JC0/FJsJdFRIMPziEqnwI=', 'DOzRb/Lw0Mh/u53ujke8Pw==', 'd31/F/pWx520ryVfBQ09RA==', 'public/proposals/pWZYUJW47uszaGwTHsjogJ9cGVBJIB07d0aRLJp8.pdf.enc', 'Pending', 6, '2024-12-24 03:26:01', '2024-12-24 03:26:01', 'L6x/ubSDBeB07C4Fd0ZEJg=='),
(36, 'bS7w5/cDfOB20k4VarB7hg==', 'tzO3WNgvfKJdOJj9b5G0FXhgar1A8bzjd+vEv0GzQlg=', '9zj8o1w7Rz9R/p4ZqT96rA==', 'f0VIdKC9TFWW4KjQWIZbdA==', 'i7o+N58r0RlzmRQxU9qS52JC0/FJsJdFRIMPziEqnwI=', 'DOzRb/Lw0Mh/u53ujke8Pw==', 'bS7w5/cDfOB20k4VarB7hg==', 'public/proposals/7IkqWef7hQCiu8bYQiI9aZfRAV67AbKETiawVRTb.pdf.enc', 'Selesai', 6, '2024-12-24 06:49:27', '2024-12-24 07:13:16', 'oGF8xsyTpop9IAdklS0aYw=='),
(37, 'gb1yNqd1tqlop46bSgzCHg==', 'DSQCE7ZK3EkYPrWyLCp6jdKq2Is8E/65o8IgDbZktCk=', '9zj8o1w7Rz9R/p4ZqT96rA==', 'f0VIdKC9TFWW4KjQWIZbdA==', 'i7o+N58r0RlzmRQxU9qS52JC0/FJsJdFRIMPziEqnwI=', 'xG//9FiesPB1YeZEGLAtgw==', 'irhg69/lhVkPFbWHABrrNw==', 'public/proposals/pfnEqQxyAW5XMV333IbU1lVDKzrLQ0iaEgAo2oAa.pdf.enc', 'Diproses', 6, '2024-12-27 00:21:10', '2025-01-05 13:24:35', 'L6x/ubSDBeB07C4Fd0ZEJg=='),
(38, 'bS7w5/cDfOB20k4VarB7hg==', 'DSQCE7ZK3EkYPrWyLCp6jdKq2Is8E/65o8IgDbZktCk=', '9zj8o1w7Rz9R/p4ZqT96rA==', 'f0VIdKC9TFWW4KjQWIZbdA==', 'i7o+N58r0RlzmRQxU9qS52JC0/FJsJdFRIMPziEqnwI=', 'CMGzkDc3kTHfQedmEzygFA==', 'AHBcDHMZvAxO0DOuWcWVyQ==', 'public/proposals/FDAK2BSxBFMAgE24wCkzpHJD9RYMoGli3mnpsvHu.pdf.enc', 'Diproses', 6, '2024-12-27 10:12:43', '2024-12-27 10:15:28', 'L6x/ubSDBeB07C4Fd0ZEJg=='),
(39, 'FyZz/Xb3Y8Px0qdZVXVD6Q==', 'tzO3WNgvfKJdOJj9b5G0FXhgar1A8bzjd+vEv0GzQlg=', 'iTW44ijW+p0CeqAJma6VQg==', 'rHIzdKg5QQraP/Y6zSKIrA==', 'i7o+N58r0RlzmRQxU9qS52JC0/FJsJdFRIMPziEqnwI=', 'xG//9FiesPB1YeZEGLAtgw==', 'tlSOmhQKMdFnWjHwirnQdg==', 'public/proposals/kyqkRhZeqEldH2F2LguZTqSTpiWit8DWn8H7Yktx.pdf.enc', 'Diproses', 6, '2025-01-06 07:28:47', '2025-01-06 07:30:21', 'lblg3lAAKIv7Kg0fkeqMbw=='),
(40, 'SHQviBEul2pXkNrOzkMMNQ==', 'tzO3WNgvfKJdOJj9b5G0FXhgar1A8bzjd+vEv0GzQlg=', '9zj8o1w7Rz9R/p4ZqT96rA==', 'f0VIdKC9TFWW4KjQWIZbdA==', 'i7o+N58r0RlzmRQxU9qS52JC0/FJsJdFRIMPziEqnwI=', 'xG//9FiesPB1YeZEGLAtgw==', 'bS7w5/cDfOB20k4VarB7hg==', 'public/proposals/gbhMXj1NHZSPmZEW9dnMQj4LNt18ZGL9R6Eh3nIA.pdf.enc', 'Diproses', 6, '2025-01-07 00:59:23', '2025-01-07 01:01:27', 'UaQzJo+JojTUX9Mvcvr14A==');

-- --------------------------------------------------------

--
-- Table structure for table `pengabdians`
--

CREATE TABLE `pengabdians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `luaran_wajib` varchar(255) NOT NULL,
  `lama_penelitian` varchar(255) NOT NULL,
  `biaya_diusulkan` text DEFAULT NULL,
  `skema` varchar(255) NOT NULL,
  `luaran_tambahan` varchar(255) DEFAULT NULL,
  `ringkasan_proposal` text NOT NULL,
  `dokumen_proposal` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sinta_index` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengabdians`
--

INSERT INTO `pengabdians` (`id`, `judul`, `luaran_wajib`, `lama_penelitian`, `biaya_diusulkan`, `skema`, `luaran_tambahan`, `ringkasan_proposal`, `dokumen_proposal`, `status`, `user_id`, `created_at`, `updated_at`, `sinta_index`) VALUES
(8, 'CQaZd9UWh7Rsab1g52MXGIvBxMpBXgffY4o34B6Ttks=', 'Oqad5se4kTwfXlF3OTaN7ZAFgN/BaoCZ+tdnU+sf1rs=', '9zj8o1w7Rz9R/p4ZqT96rA==', 'zPJez9GqNn4sUVI7bQmGPQ==', 'i7o+N58r0RlzmRQxU9qS52JC0/FJsJdFRIMPziEqnwI=', 'DOzRb/Lw0Mh/u53ujke8Pw==', 'fWOsQDdCQkaTQEyeoA/glgUMFGoPw5zOubPiqkFupuM=', 'public/proposals/lUycSt8mbsJbn9orJ9nxN5MplNQfL5RYP60XgEBt.pdf', 'Diproses', 6, '2024-12-24 02:34:56', '2024-12-24 02:43:57', 'L6x/ubSDBeB07C4Fd0ZEJg==');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppm`
--

CREATE TABLE `ppm` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bidang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hibah_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pegawai_id` bigint(20) UNSIGNED DEFAULT NULL,
  `luaran_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `skema_id` bigint(20) UNSIGNED DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jumlah_dana` int(11) DEFAULT NULL,
  `tahapan` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppm_fokus_bidang`
--

CREATE TABLE `ppm_fokus_bidang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pegawai_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `singkatan` varchar(255) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `deskripsi_file` varchar(255) DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppm_hibah`
--

CREATE TABLE `ppm_hibah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_hibah_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `singkatan` varchar(255) DEFAULT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppm_jenis_skema`
--

CREATE TABLE `ppm_jenis_skema` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ppm_jenis_skema`
--

INSERT INTO `ppm_jenis_skema` (`id`, `kode`, `nama`, `is_shown`) VALUES
(1, 'internal', 'Internal ITH', 1),
(2, 'kemendikbud-ristek', 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi', 1),
(3, 'lain', 'Lainnya', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ppm_luaran`
--

CREATE TABLE `ppm_luaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ppm_luaran`
--

INSERT INTO `ppm_luaran` (`id`, `kode`, `nama`, `perihal`, `is_shown`) VALUES
(1, 'hasil_penelitian', 'Hasil Penelitian', '', 1),
(2, 'hasil_pengabdian', 'Hasil Pengabdian', '', 1),
(3, 'buku_ajar', 'Buku Ajar', '', 1),
(4, 'publikasi_ilmiah', 'Publikasi Ilmiah', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ppm_skema`
--

CREATE TABLE `ppm_skema` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_skema_id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `is_research` int(11) NOT NULL DEFAULT 0,
  `is_shown` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ppm_skema`
--

INSERT INTO `ppm_skema` (`id`, `jenis_skema_id`, `kode`, `nama`, `perihal`, `is_research`, `is_shown`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'pki', 'Penelitian Kolaborasi Indonesia', NULL, 1, 1, NULL, NULL, NULL),
(2, 1, 'pdin', 'Penelitian Dasar ITH', NULL, 1, 1, NULL, NULL, NULL),
(3, 1, 'ptin', 'Penelitian Terapan ITH', NULL, 1, 1, NULL, NULL, NULL),
(4, 1, 'pipin', 'Penelitian Inovasi Pengembangan ITH', NULL, 1, 1, NULL, NULL, NULL),
(5, 1, 'pdpain', 'Penelitian Dosen Penasehat Akademik', NULL, 1, 1, NULL, NULL, NULL),
(6, 1, 'pdpin', 'Penelitian Dosen Pemula ITH', NULL, 1, 1, NULL, NULL, NULL),
(7, 1, 'pkin', 'Program Kemitraan ITH', NULL, 0, 1, NULL, NULL, NULL),
(8, 1, 'ppupiki', 'Program Pengembangan Usaha Intelektual Kampus ITH', NULL, 0, 1, NULL, NULL, NULL),
(9, 1, 'kkn-ppm', 'KuliahKerja Nyata Pembelajaran Pemberdayaan Masyarakat', NULL, 0, 1, NULL, NULL, NULL),
(10, 2, 'pd', 'Penelitian Dasar', NULL, 1, 1, NULL, NULL, NULL),
(11, 2, 'pdupt', 'Penelitian Dasar Unggulan Perguruan Tinggi', NULL, 1, 1, NULL, NULL, NULL),
(12, 2, 'pt', 'Penelitian Terapan', NULL, 1, 1, NULL, NULL, NULL),
(13, 2, 'ptupt', 'Penelitian Terapan Unggulan Perguruan Tinggi', NULL, 1, 1, NULL, NULL, NULL),
(14, 2, 'pp', 'Penelitian Pengembangan', NULL, 1, 1, NULL, NULL, NULL),
(15, 2, 'ppupt', 'Penelitian Pengembangan Unggulan Perguruan Tinggi', NULL, 1, 1, NULL, NULL, NULL),
(16, 2, 'ppd', 'Penelitian Pasca Doktor', NULL, 1, 1, NULL, NULL, NULL),
(17, 2, 'ptm', 'Penelitian Tesis Magister', NULL, 1, 1, NULL, NULL, NULL),
(18, 2, 'pdd', 'Penelitian Disertasi Doktor', NULL, 1, 1, NULL, NULL, NULL),
(19, 2, 'pmdsu', 'Pendidikan Magister menuju Doktor untuk Sarjana Unggul', NULL, 1, 1, NULL, NULL, NULL),
(20, 2, 'krupt', 'Konsorsium Riset Unggulan Perguruan Tinggi', NULL, 1, 1, NULL, NULL, NULL),
(21, 2, 'wcr', 'World Class Research', NULL, 1, 1, NULL, NULL, NULL),
(22, 2, 'prn', 'Prioritas Riset Nasional', NULL, 0, 1, NULL, NULL, NULL),
(23, 2, 'kd', 'Kemitraan Dasar', NULL, 0, 1, NULL, NULL, NULL),
(24, 2, 'pkm', 'Program Kreativitas Mahasiswa', NULL, 0, 1, NULL, NULL, NULL),
(25, 2, 'ppuik', 'Program Pengembangan Usaha Intelektual Kampus', NULL, 0, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `program_studi`
--

CREATE TABLE `program_studi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_studi`
--

INSERT INTO `program_studi` (`id`, `jurusan_id`, `kode`, `nama`, `tahun`, `urutan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'mtk', 'Matematika', '2022', 1, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(2, 1, 'ik', 'Ilmu Komputer', '2022', 2, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL),
(3, 2, 'si', 'Sistem Informasi', '2022', 3, '2024-10-04 08:33:58', '2024-10-04 08:33:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `skema` varchar(255) NOT NULL,
  `luaran_wajib` varchar(255) NOT NULL,
  `luaran_tambahan` varchar(255) DEFAULT NULL,
  `lama_penelitian` varchar(255) NOT NULL,
  `ringkasan_proposal` text NOT NULL,
  `biaya` decimal(15,2) NOT NULL,
  `dokumen_proposal` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `related_links`
--

CREATE TABLE `related_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `related_links`
--

INSERT INTO `related_links` (`id`, `nama`, `url`, `is_shown`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ITH', 'https://ith.ac.id/', 1, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(2, 'PDDikti', 'https://pddikti.kemdikbud.go.id/', 1, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(3, 'BIMA', 'https://bima.kemdikbud.go.id/', 1, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(4, 'SINTA', 'https://sinta.kemdikbud.go.id/', 1, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(5, 'ARJUNA', 'https://arjuna.kemdikbud.go.id/', 1, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(6, 'RAMA', 'https://rama.kemdikbud.go.id/', 1, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(7, 'GARUDA', 'https://garuda.kemdikbud.go.id/', 1, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(8, 'ANJANI', 'https://anjani.kemdikbud.go.id/', 1, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL),
(9, 'KEMENDIKBUD', 'https://www.kemdikbud.go.id/', 1, '2024-10-04 08:33:59', '2024-10-04 08:33:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `penelitian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pengabdian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `judul_kegiatan` varchar(255) DEFAULT NULL,
  `ketua_tim` varchar(255) DEFAULT NULL,
  `nidn` varchar(255) DEFAULT NULL,
  `biaya_usulan` decimal(15,2) DEFAULT NULL,
  `disarankan` text DEFAULT NULL,
  `skor_1` int(11) DEFAULT NULL,
  `skor_2` int(11) DEFAULT NULL,
  `skor_3` int(11) DEFAULT NULL,
  `skor_4` int(11) DEFAULT NULL,
  `skor_5` int(11) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `type` enum('penelitian','pengabdian') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reviewer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewer_name` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `scopus` varchar(255) DEFAULT NULL,
  `anggota` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `penelitian_id`, `pengabdian_id`, `judul_kegiatan`, `ketua_tim`, `nidn`, `biaya_usulan`, `disarankan`, `skor_1`, `skor_2`, `skor_3`, `skor_4`, `skor_5`, `komentar`, `type`, `created_at`, `updated_at`, `reviewer_id`, `reviewer_name`, `jabatan`, `scopus`, `anggota`) VALUES
(50, NULL, 8, 'Proposal Pengabdian #1', 'Danang', '11231231231', 3444444.00, NULL, 4, 5, 4, 3, 6, 'pe', 'penelitian', '2024-12-24 02:43:57', '2024-12-24 02:44:33', 5, 'review', 'Dosen', NULL, 'Noel'),
(51, 36, NULL, 'tes', 'Danang', '11231231231', 100000000.00, NULL, 7, 1, 3, 3, 4, 'p', 'penelitian', '2024-12-24 06:57:49', '2024-12-24 06:57:49', 5, 'review', 'Dosen', NULL, NULL),
(52, 36, NULL, 'tes', 'Danang', '11231231231', 100000000.00, NULL, 2, 2, 2, 2, 2, '2', 'penelitian', '2024-12-24 07:13:16', '2024-12-24 07:13:16', 2, 'reviewer1', 'Dosen', NULL, NULL),
(53, 38, NULL, 'tes', 'Danang', '11231231231', 100000000.00, NULL, 1, 1, 1, 1, 1, NULL, 'penelitian', '2024-12-27 10:15:28', '2024-12-27 10:15:28', 5, 'review', 'Dosen', NULL, 'Noel'),
(54, 37, NULL, 'Kriptografi', 'Noel', '221031002', 100000000.00, NULL, 4, 5, 4, 3, 2, 'tes 123', 'penelitian', '2025-01-05 13:24:35', '2025-01-05 13:24:35', 5, 'review', 'Dosen', NULL, 'Danang'),
(55, 39, NULL, 'wkdawodk', 'awdasdw', '2312323123', 27100000.00, 'tes', 3, 2, 3, 3, 3, 'waw', 'penelitian', '2025-01-06 07:30:21', '2025-01-06 07:30:21', 5, 'review', 'Dosen', 'tak tau', NULL),
(56, 40, NULL, 'judul', 'Danang', '11231231231', 100000000.00, NULL, 3, 1, 6, 5, 7, 'ok', 'penelitian', '2025-01-07 01:01:27', '2025-01-07 01:01:27', 5, 'review', 'Mahasiswa', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_agendas`
--

CREATE TABLE `sub_agendas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agenda_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `jadwal` timestamp NULL DEFAULT NULL,
  `jadwal_akhir` timestamp NULL DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `is_shown` int(11) NOT NULL DEFAULT 0,
  `tautan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timelines`
--

CREATE TABLE `timelines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `upload_start_date` datetime NOT NULL,
  `upload_end_date` datetime NOT NULL,
  `review_start_date` datetime NOT NULL,
  `review_end_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timelines`
--

INSERT INTO `timelines` (`id`, `upload_start_date`, `upload_end_date`, `review_start_date`, `review_end_date`, `created_at`, `updated_at`) VALUES
(4, '2025-02-03 15:00:00', '2025-02-03 15:03:00', '2025-02-03 15:04:00', '2025-02-03 15:07:00', '2025-02-03 07:01:14', '2025-02-03 07:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `avatar_path`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'dosen', 'dosen1@gmail.com', NULL, '$2y$10$6aBss/MhBojxvXPPtNtviuElGC2HYNtAf9E6q.y3D4lj2GVqtmKle', 'dosen', NULL, NULL, '2024-10-04 07:20:46', '2024-10-04 07:20:46'),
(2, 'reviewer1', 'reviewer1@gmail.com', NULL, '$2y$10$nNHXF7BdEbcWL.Le4cVPN.rsT44vOQr028gcRGd0miAciEJ6Ni026', 'reviewer', NULL, NULL, '2024-10-04 07:23:42', '2024-10-04 07:23:42'),
(3, 'admin1', 'admin1@gmail.com', NULL, '$2y$10$Wdkp6dVuzci1yYDLL5jIHuLEOdRj5GKJHkuqN2.SrZj9dG3QVmceK', 'admin', NULL, NULL, '2024-10-04 07:26:36', '2024-10-04 07:26:36'),
(4, 'Admin', 'adm-lppm@ith.ac.id', '2024-10-04 08:33:59', '$2y$10$tF2/QjM9o7baToYGukZChePoc1v4Yu4JG/Uztg.XaxtiwX2cb.OXW', 'admin', NULL, 'frTKGMqTb3', '2024-10-04 08:33:59', '2024-10-04 08:33:59'),
(5, 'review', 'reviewer@gmail.com', NULL, '$2y$10$7MkDv5FXwHyAn4w0Lq9YieRNismtTFX1nZX8fgoRrLJ490d4YvTAq', 'reviewer', NULL, NULL, '2024-10-24 05:41:44', '2024-10-24 05:41:44'),
(6, 'saya dosent', 'dosen@gmail.com', NULL, '$2y$10$Z/LsQ4tbv0G9qBvcn60LJOGtMN1GGsg/8ZggQXem8v8qtyv9qYPeS', 'dosen', 'avatars/78GyZn1m9HE8rsfGoTtkJJq21GCzG7e3WT6ytFn1.png', NULL, '2024-10-24 05:42:36', '2025-09-09 08:00:08'),
(7, 'saya atmin y', 'admin@gmail.com', NULL, '$2y$10$1KYMAvG/zJ89muH4Bxl/seq2tXmBEs4FBQkO5PtDfPctnZ4UiLkQu', 'admin', 'avatars/hycsYcYb1DHWO7tTmEkcGO35L5KNRy7BudAE1tnf.png', NULL, '2024-11-17 16:16:55', '2025-09-11 09:55:44'),
(8, 'auditor', 'auditor@gmail.com', NULL, '$2y$10$oFRBmtwt/.zBTt0iHnJ4OunSZLe0iWL2XqWIoy62J5/p46P2SHAhm', 'auditor', NULL, NULL, '2024-12-13 08:25:16', '2024-12-13 08:25:16'),
(9, 'kaprodi', 'kaprodi@gmail.com', NULL, '$2y$10$/IesdKy4.99Mk5FXfv55xeVMX8SHS93zgXFzSxv4kYGXyOIExe.Zq', 'kaprodi', NULL, NULL, '2025-02-03 07:35:17', '2025-02-03 07:35:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agendas_slug_unique` (`slug`),
  ADD KEY `agendas_user_id_foreign` (`user_id`);

--
-- Indexes for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggotas_penelitian_id_foreign` (`penelitian_id`);

--
-- Indexes for table `anggota_pengabdians`
--
ALTER TABLE `anggota_pengabdians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_pengabdians_pengabdian_id_foreign` (`pengabdian_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcements_slug_unique` (`slug`),
  ADD KEY `announcements_user_id_foreign` (`user_id`);

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bans_bannable_type_bannable_id_index` (`bannable_type`,`bannable_id`),
  ADD KEY `bans_created_by_type_created_by_id_index` (`created_by_type`,`created_by_id`),
  ADD KEY `bans_expired_at_index` (`expired_at`);

--
-- Indexes for table `dokumen_penting`
--
ALTER TABLE `dokumen_penting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dokumen_penting_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flags`
--
ALTER TABLE `flags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_user_id_foreign` (`user_id`);

--
-- Indexes for table `pangkat_golongan_ruang`
--
ALTER TABLE `pangkat_golongan_ruang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pegawai_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `pegawai_nip_unique` (`nip`),
  ADD KEY `pegawai_program_studi_id_foreign` (`program_studi_id`),
  ADD KEY `pegawai_jabatan_id_foreign` (`jabatan_id`),
  ADD KEY `pegawai_pangkat_golongan_ruang_id_foreign` (`pangkat_golongan_ruang_id`);

--
-- Indexes for table `penelitians`
--
ALTER TABLE `penelitians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penelitians_user_id_foreign` (`user_id`);

--
-- Indexes for table `pengabdians`
--
ALTER TABLE `pengabdians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengabdians_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ppm`
--
ALTER TABLE `ppm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ppm_slug_unique` (`slug`),
  ADD KEY `ppm_bidang_id_foreign` (`bidang_id`),
  ADD KEY `ppm_hibah_id_foreign` (`hibah_id`),
  ADD KEY `ppm_luaran_id_foreign` (`luaran_id`),
  ADD KEY `ppm_skema_id_foreign` (`skema_id`),
  ADD KEY `ppm_jurusan_id_foreign` (`jurusan_id`),
  ADD KEY `ppm_pegawai_id_foreign` (`pegawai_id`);

--
-- Indexes for table `ppm_fokus_bidang`
--
ALTER TABLE `ppm_fokus_bidang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ppm_fokus_bidang_slug_unique` (`slug`),
  ADD KEY `ppm_fokus_bidang_pegawai_id_foreign` (`pegawai_id`);

--
-- Indexes for table `ppm_hibah`
--
ALTER TABLE `ppm_hibah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ppm_hibah_jenis_hibah_id_foreign` (`jenis_hibah_id`);

--
-- Indexes for table `ppm_jenis_skema`
--
ALTER TABLE `ppm_jenis_skema`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppm_luaran`
--
ALTER TABLE `ppm_luaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppm_skema`
--
ALTER TABLE `ppm_skema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ppm_skema_jenis_skema_id_foreign` (`jenis_skema_id`);

--
-- Indexes for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_studi_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `related_links`
--
ALTER TABLE `related_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_penelitian_id_foreign` (`penelitian_id`),
  ADD KEY `reviews_pengabdian_id_foreign` (`pengabdian_id`),
  ADD KEY `reviews_reviewer_id_foreign` (`reviewer_id`);

--
-- Indexes for table `sub_agendas`
--
ALTER TABLE `sub_agendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_agendas_agenda_id_foreign` (`agenda_id`);

--
-- Indexes for table `timelines`
--
ALTER TABLE `timelines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `anggotas`
--
ALTER TABLE `anggotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `anggota_pengabdians`
--
ALTER TABLE `anggota_pengabdians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dokumen_penting`
--
ALTER TABLE `dokumen_penting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flags`
--
ALTER TABLE `flags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pangkat_golongan_ruang`
--
ALTER TABLE `pangkat_golongan_ruang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `penelitians`
--
ALTER TABLE `penelitians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pengabdians`
--
ALTER TABLE `pengabdians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppm`
--
ALTER TABLE `ppm`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppm_fokus_bidang`
--
ALTER TABLE `ppm_fokus_bidang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppm_hibah`
--
ALTER TABLE `ppm_hibah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppm_jenis_skema`
--
ALTER TABLE `ppm_jenis_skema`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ppm_luaran`
--
ALTER TABLE `ppm_luaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ppm_skema`
--
ALTER TABLE `ppm_skema`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `program_studi`
--
ALTER TABLE `program_studi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `related_links`
--
ALTER TABLE `related_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `sub_agendas`
--
ALTER TABLE `sub_agendas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timelines`
--
ALTER TABLE `timelines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `agendas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD CONSTRAINT `anggotas_penelitian_id_foreign` FOREIGN KEY (`penelitian_id`) REFERENCES `penelitians` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `anggota_pengabdians`
--
ALTER TABLE `anggota_pengabdians`
  ADD CONSTRAINT `anggota_pengabdians_pengabdian_id_foreign` FOREIGN KEY (`pengabdian_id`) REFERENCES `pengabdians` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`),
  ADD CONSTRAINT `pegawai_pangkat_golongan_ruang_id_foreign` FOREIGN KEY (`pangkat_golongan_ruang_id`) REFERENCES `pangkat_golongan_ruang` (`id`),
  ADD CONSTRAINT `pegawai_program_studi_id_foreign` FOREIGN KEY (`program_studi_id`) REFERENCES `program_studi` (`id`);

--
-- Constraints for table `penelitians`
--
ALTER TABLE `penelitians`
  ADD CONSTRAINT `penelitians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengabdians`
--
ALTER TABLE `pengabdians`
  ADD CONSTRAINT `pengabdians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ppm`
--
ALTER TABLE `ppm`
  ADD CONSTRAINT `ppm_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `ppm_fokus_bidang` (`id`),
  ADD CONSTRAINT `ppm_hibah_id_foreign` FOREIGN KEY (`hibah_id`) REFERENCES `ppm_hibah` (`id`),
  ADD CONSTRAINT `ppm_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`),
  ADD CONSTRAINT `ppm_luaran_id_foreign` FOREIGN KEY (`luaran_id`) REFERENCES `ppm_luaran` (`id`),
  ADD CONSTRAINT `ppm_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `ppm_skema_id_foreign` FOREIGN KEY (`skema_id`) REFERENCES `ppm_skema` (`id`);

--
-- Constraints for table `ppm_fokus_bidang`
--
ALTER TABLE `ppm_fokus_bidang`
  ADD CONSTRAINT `ppm_fokus_bidang_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`);

--
-- Constraints for table `ppm_hibah`
--
ALTER TABLE `ppm_hibah`
  ADD CONSTRAINT `ppm_hibah_jenis_hibah_id_foreign` FOREIGN KEY (`jenis_hibah_id`) REFERENCES `ppm_jenis_skema` (`id`);

--
-- Constraints for table `ppm_skema`
--
ALTER TABLE `ppm_skema`
  ADD CONSTRAINT `ppm_skema_jenis_skema_id_foreign` FOREIGN KEY (`jenis_skema_id`) REFERENCES `ppm_jenis_skema` (`id`);

--
-- Constraints for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD CONSTRAINT `program_studi_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_penelitian_id_foreign` FOREIGN KEY (`penelitian_id`) REFERENCES `penelitians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_pengabdian_id_foreign` FOREIGN KEY (`pengabdian_id`) REFERENCES `pengabdians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_agendas`
--
ALTER TABLE `sub_agendas`
  ADD CONSTRAINT `sub_agendas_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
