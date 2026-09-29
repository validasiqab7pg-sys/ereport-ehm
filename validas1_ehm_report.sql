-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 29 Sep 2026 pada 03.54
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `validas1_ehm_report`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `audit_trail_swab`
--

CREATE TABLE `audit_trail_swab` (
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `username` varchar(100) NOT NULL,
  `action` varchar(10) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `record_id` int(11) NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `ip_address` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_ahu`
--

CREATE TABLE `data_ahu` (
  `id` int(11) NOT NULL,
  `ahu` varchar(100) NOT NULL,
  `tanggaldilakukan` date NOT NULL,
  `site` varchar(100) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `jenispemeriksaan` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `kondisi` varchar(123) NOT NULL,
  `approve_1` varchar(155) NOT NULL,
  `approve_1_date` date NOT NULL,
  `approve_2` varchar(155) NOT NULL,
  `approve_2_date` date NOT NULL,
  `approve_3` varchar(155) NOT NULL,
  `approve_3_date` date NOT NULL,
  `approve_4` varchar(155) NOT NULL,
  `approve_4_date` date NOT NULL,
  `statusSuhu` int(11) NOT NULL,
  `statusRh` int(11) NOT NULL,
  `statusDp` int(11) NOT NULL,
  `statusFlow` int(11) NOT NULL,
  `statusPartikel` int(11) NOT NULL,
  `statusLux` int(11) NOT NULL,
  `statusMas` int(11) NOT NULL,
  `statusCapar` int(11) NOT NULL,
  `statusPatogen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_awal_ppoj`
--

CREATE TABLE `data_awal_ppoj` (
  `id` int(11) NOT NULL,
  `no_ppoj` varchar(50) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `ahu` varchar(20) NOT NULL,
  `tanggaldilakukan` date NOT NULL,
  `site` varchar(20) NOT NULL,
  `nama_ruangan` varchar(50) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `kondisi` varchar(20) NOT NULL,
  `status` varchar(122) NOT NULL,
  `jenispemeriksaan` varchar(111) NOT NULL,
  `jumlah_pertukaran_udara` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_awal_swab`
--

CREATE TABLE `data_awal_swab` (
  `id` int(11) NOT NULL,
  `no_ppoj` varchar(50) NOT NULL,
  `tanggal_sampling` date DEFAULT NULL,
  `tanggal_dibersihkan` date DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `nama_mesin_personil_alat` varchar(150) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `departemen` varchar(100) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `ahu` varchar(100) DEFAULT NULL,
  `id_swab` int(11) DEFAULT NULL,
  `approve_1` varchar(100) DEFAULT NULL,
  `approve_1_date` datetime DEFAULT NULL,
  `approve_2` varchar(100) DEFAULT NULL,
  `approve_2_date` datetime DEFAULT NULL,
  `approve_3` varchar(100) DEFAULT NULL,
  `approve_3_date` datetime DEFAULT NULL,
  `approve_4` varchar(100) DEFAULT NULL,
  `approve_4_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_sampling_air`
--

CREATE TABLE `data_sampling_air` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal_sampling` date DEFAULT NULL,
  `site` varchar(10) DEFAULT NULL,
  `jenis_sampling` varchar(100) DEFAULT NULL,
  `week` varchar(10) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `approve_1` varchar(100) DEFAULT NULL,
  `approve_1_date` datetime DEFAULT NULL,
  `approve_qc_kimia` varchar(100) DEFAULT NULL,
  `approve_qc_kimia_date` datetime DEFAULT NULL,
  `approve_qc_mikro` varchar(100) DEFAULT NULL,
  `approve_qc_mikro_date` datetime DEFAULT NULL,
  `approve_spv_qc` varchar(100) DEFAULT NULL,
  `approve_spv_qa` varchar(100) DEFAULT NULL,
  `approve_spv_qa_date` datetime DEFAULT NULL,
  `approve_spv_qc_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_swab`
--

CREATE TABLE `data_swab` (
  `id` int(11) NOT NULL,
  `tanggal_sampling` date DEFAULT NULL,
  `ahu` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_ad` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `approve_1` varchar(100) NOT NULL,
  `approve_1_date` date NOT NULL,
  `approve_2` varchar(100) NOT NULL,
  `approve_2_date` date NOT NULL,
  `approve_3` varchar(100) NOT NULL,
  `approve_3_date` date NOT NULL,
  `approve_4` varchar(100) NOT NULL,
  `approve_4_date` date NOT NULL,
  `statusPatogen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_titik_sampling_air`
--

CREATE TABLE `data_titik_sampling_air` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_sampling` int(10) UNSIGNED NOT NULL COMMENT 'FK ke data_sampling_air.id',
  `id_master_air` int(10) UNSIGNED NOT NULL COMMENT 'FK ke master_data_air.id',
  `no_outlet_sampling` varchar(100) DEFAULT NULL,
  `nama_outlet_sampling` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `jenis_sampling` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dp`
--

CREATE TABLE `dp` (
  `id` int(11) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `terhadap_ruangan` varchar(100) DEFAULT NULL,
  `hasil_dp` varchar(15) DEFAULT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `tanggal_dilakukan` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `keterangan` varchar(123) NOT NULL,
  `editable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `flow`
--

CREATE TABLE `flow` (
  `id` int(11) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `hasil_flow` decimal(10,2) DEFAULT NULL,
  `volume_ruangan` int(11) NOT NULL,
  `keterangan` varchar(222) NOT NULL,
  `status` int(11) NOT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `tanggal_dilakukan` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_sampling_air`
--

CREATE TABLE `hasil_sampling_air` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_sampling` int(10) UNSIGNED DEFAULT NULL,
  `id_master_air` int(10) UNSIGNED DEFAULT NULL,
  `hasil_warna` varchar(100) DEFAULT NULL,
  `hasil_bau` varchar(100) DEFAULT NULL,
  `hasil_ph` varchar(50) DEFAULT NULL,
  `hasil_suhu` varchar(50) DEFAULT NULL,
  `hasil_conductivity` varchar(50) DEFAULT NULL,
  `hasil_kesadahan` varchar(50) DEFAULT NULL,
  `hasil_zat_padat_total` varchar(50) DEFAULT NULL,
  `hasil_toc` varchar(50) DEFAULT NULL,
  `hasil_tamc` varchar(50) DEFAULT NULL,
  `hasil_tymc` varchar(50) DEFAULT NULL,
  `hasil_coliform` varchar(50) DEFAULT NULL,
  `hasil_e_coli` varchar(50) DEFAULT NULL,
  `hasil_salmonella_sp` varchar(50) DEFAULT NULL,
  `hasil_staphylococcus_aureus` varchar(50) DEFAULT NULL,
  `hasil_pseudomonas_aeruginosa` varchar(50) DEFAULT NULL,
  `hasil_shigella_sp` varchar(50) DEFAULT NULL,
  `hasil_enterobacteriaceae` varchar(50) DEFAULT NULL,
  `hasil_clostridia` varchar(50) DEFAULT NULL,
  `hasil_sporogens` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kondisi`
--

CREATE TABLE `kondisi` (
  `kondisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lux`
--

CREATE TABLE `lux` (
  `id` int(11) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `hasil_lux` varchar(255) DEFAULT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `keterangan` varchar(222) NOT NULL,
  `tanggal_dilakukan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_data`
--

CREATE TABLE `master_data` (
  `id` int(11) NOT NULL,
  `nama_ahu` varchar(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `suhu_min` int(11) NOT NULL,
  `suhu_max` int(11) NOT NULL,
  `rh_min` int(11) NOT NULL,
  `rh_max` int(11) NOT NULL,
  `lux` int(11) NOT NULL,
  `Perbedaan_Tekanan` int(11) NOT NULL,
  `Pertukaran_Udara` int(11) NOT NULL,
  `Partikel_05AR` int(11) NOT NULL,
  `Partikel_50AR` int(11) NOT NULL,
  `Partikel_05IO` int(11) NOT NULL,
  `Partikel_50IO` int(11) NOT NULL,
  `Volumetrik_TPC` int(11) NOT NULL,
  `Volumetrik_KK` int(11) NOT NULL,
  `Capar_TPC` int(11) NOT NULL,
  `Capar_KK` int(11) NOT NULL,
  `titik_suhu` varchar(10) NOT NULL,
  `titik_rh` varchar(10) NOT NULL,
  `titik_mikro` int(11) NOT NULL,
  `titik_partikel` int(11) NOT NULL,
  `titik_capar` varchar(10) NOT NULL,
  `titik_flow` varchar(255) NOT NULL,
  `titik_lux` varchar(50) NOT NULL,
  `patogen` varchar(50) NOT NULL,
  `volume_ruangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_data_air`
--

CREATE TABLE `master_data_air` (
  `id` int(10) UNSIGNED NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `jenis_sampling` varchar(100) DEFAULT NULL,
  `no_outlet_sampling` varchar(50) DEFAULT NULL,
  `nama_outlet_sampling` varchar(255) DEFAULT NULL,
  `jadwal_minggu_ke` varchar(50) DEFAULT NULL,
  `syarat_warna` varchar(100) DEFAULT NULL,
  `syarat_bau` varchar(100) DEFAULT NULL,
  `syarat_ph` varchar(50) DEFAULT NULL,
  `syarat_suhu` varchar(50) DEFAULT NULL,
  `syarat_conductivity` varchar(50) DEFAULT NULL,
  `syarat_kesadahan` varchar(50) DEFAULT NULL,
  `syarat_zat_padat_total` varchar(50) DEFAULT NULL,
  `syarat_toc` varchar(50) DEFAULT NULL,
  `syarat_tamc` varchar(50) DEFAULT NULL,
  `syarat_tymc` varchar(50) DEFAULT NULL,
  `syarat_coliform` varchar(50) DEFAULT NULL,
  `syarat_e_coli` varchar(50) DEFAULT NULL,
  `syarat_salmonella_sp` varchar(50) DEFAULT NULL,
  `syarat_staphylococcus_aureus` varchar(50) DEFAULT NULL,
  `syarat_pseudomonas_aeruginosa` varchar(50) DEFAULT NULL,
  `syarat_shigella_sp` varchar(50) DEFAULT NULL,
  `syarat_enterobacteriaceae` varchar(50) DEFAULT NULL,
  `syarat_clostridia` varchar(50) DEFAULT NULL,
  `syarat_sporogens` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_data_air_syarat`
--

CREATE TABLE `master_data_air_syarat` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_master_air` int(10) UNSIGNED NOT NULL,
  `parameter` varchar(50) NOT NULL,
  `tipe` enum('numerik','teks') NOT NULL,
  `operator` varchar(50) DEFAULT NULL,
  `nilai_min` decimal(12,4) DEFAULT NULL,
  `nilai_max` decimal(12,4) DEFAULT NULL,
  `nilai_teks` varchar(100) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_data_dp`
--

CREATE TABLE `master_data_dp` (
  `id` int(11) NOT NULL,
  `ahu` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `nama_ruangan` varchar(200) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `terhadap_ruangan` varchar(200) NOT NULL,
  `kelas_pembanding` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_data_swab`
--

CREATE TABLE `master_data_swab` (
  `id` int(11) NOT NULL,
  `site` varchar(100) DEFAULT NULL,
  `ahu` varchar(100) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `nama_mesin_personil_alat` varchar(150) DEFAULT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `departemen` varchar(100) DEFAULT NULL,
  `lokasi_sampling` varchar(100) DEFAULT NULL,
  `periode` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_data_swab2`
--

CREATE TABLE `master_data_swab2` (
  `id` int(11) NOT NULL,
  `site` varchar(100) DEFAULT NULL,
  `ahu` varchar(100) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `nama_mesin_personil_alat` varchar(150) DEFAULT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `departemen` varchar(100) DEFAULT NULL,
  `lokasi_sampling` varchar(100) DEFAULT NULL,
  `periode` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_syarat`
--

CREATE TABLE `master_syarat` (
  `id` int(11) NOT NULL,
  `kelas` varchar(11) NOT NULL,
  `suhu_min` int(11) NOT NULL,
  `suhu_max` int(11) NOT NULL,
  `rh_min` int(11) NOT NULL,
  `rh_max` int(11) NOT NULL,
  `perbedaan_tekanan_ruangan` int(11) NOT NULL,
  `jumlah_pertukaran_udara` int(11) NOT NULL,
  `partikel_05_atrest` int(11) NOT NULL,
  `partikel_50_atrest` int(11) NOT NULL,
  `partikel_05_inop` varchar(11) NOT NULL,
  `partikel_50_inop` varchar(11) NOT NULL,
  `volumetrik_tpc` int(11) NOT NULL,
  `volumetrik_kk` int(11) NOT NULL,
  `capar_tpc` varchar(11) NOT NULL,
  `capar_kk` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-07-17-000001', 'App\\Database\\Migrations\\CreateScanHasilAir', 'default', 'App', 1784254817, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mikro_capar`
--

CREATE TABLE `mikro_capar` (
  `id` int(11) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `hasil_tpc` int(11) DEFAULT NULL,
  `hasil_kk` int(11) DEFAULT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `tanggal_dilakukan` datetime NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(50) NOT NULL,
  `tanggal_edit` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `editable` int(11) NOT NULL,
  `approve_edit` int(11) NOT NULL,
  `approve_edit_by` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mikro_volumetrik`
--

CREATE TABLE `mikro_volumetrik` (
  `id` int(11) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `hasil_tpc` int(11) DEFAULT NULL,
  `hasil_kk` int(11) DEFAULT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `tanggal_dilakukan` datetime NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(50) NOT NULL,
  `tanggal_edit` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `editable` int(11) NOT NULL,
  `approve_edit` int(11) NOT NULL,
  `approve_edit_by` varchar(122) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nama_ahu`
--

CREATE TABLE `nama_ahu` (
  `id` int(11) NOT NULL,
  `ahu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oos`
--

CREATE TABLE `oos` (
  `id` int(11) NOT NULL,
  `id_swab` int(11) NOT NULL,
  `nama_mesin_personil_alat` varchar(255) NOT NULL,
  `lokasi_sampling` varchar(255) NOT NULL,
  `tanggal_sampling` date NOT NULL,
  `tgl_analisa` date NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `upload_oos` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oos_air`
--

CREATE TABLE `oos_air` (
  `id` int(11) NOT NULL,
  `id_sampling` int(11) NOT NULL,
  `id_master_air` int(11) NOT NULL,
  `nama_outlet_sampling` varchar(255) DEFAULT NULL,
  `no_outlet_sampling` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `tanggal_sampling` date DEFAULT NULL,
  `parameter_tms` varchar(500) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `upload_oos` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `partikel`
--

CREATE TABLE `partikel` (
  `id` int(11) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `nama_ahu` varchar(222) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `hasil_partikel` varchar(255) DEFAULT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `keterangan` varchar(222) NOT NULL,
  `tanggal_dilakukan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `partikel_file`
--

CREATE TABLE `partikel_file` (
  `id` int(11) NOT NULL,
  `id_partikel` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `patogen`
--

CREATE TABLE `patogen` (
  `id` int(11) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `e_coli` varchar(10) DEFAULT NULL,
  `salmonella_sp` varchar(10) NOT NULL,
  `staphylococcus_aureus` varchar(10) NOT NULL,
  `pseudomonas_aeruginosa` varchar(10) NOT NULL,
  `shigella_sp` varchar(10) NOT NULL,
  `enterobacteriaceae` varchar(10) NOT NULL,
  `clostridia_sporogens` varchar(10) NOT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `tgl_analisa` date NOT NULL,
  `keterangan` varchar(222) NOT NULL,
  `tanggal_dilakukan` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `patogen_swab`
--

CREATE TABLE `patogen_swab` (
  `id` int(11) NOT NULL,
  `id_swab` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_mesin_personil_alat` varchar(100) DEFAULT NULL,
  `tanggal_dibersihkan` date NOT NULL,
  `lokasi_sampling` varchar(50) NOT NULL,
  `tanggal_sampling` date NOT NULL,
  `TAMC` int(11) NOT NULL,
  `TYMC` int(11) NOT NULL,
  `e_coli` varchar(10) DEFAULT NULL,
  `salmonella_sp` varchar(10) NOT NULL,
  `staphylococcus_aureus` varchar(10) NOT NULL,
  `pseudomonas_aeruginosa` varchar(10) NOT NULL,
  `shigella_sp` varchar(10) NOT NULL,
  `enterobacteriaceae` varchar(10) NOT NULL,
  `clostridia_sporogens` varchar(10) NOT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `tgl_analisa` date NOT NULL,
  `tgl_koloni` date NOT NULL,
  `keterangan` varchar(222) NOT NULL,
  `tanggal_dilakukan` datetime NOT NULL DEFAULT current_timestamp(),
  `editable` int(11) NOT NULL,
  `approve_edit` int(11) NOT NULL,
  `approve_edit_by` varchar(50) NOT NULL,
  `tanggal_edit` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyimpangan`
--

CREATE TABLE `penyimpangan` (
  `id` int(11) NOT NULL,
  `id_swab` int(11) NOT NULL,
  `nama_mesin_personil_alat` varchar(255) NOT NULL,
  `lokasi_sampling` varchar(255) NOT NULL,
  `tanggal_sampling` date NOT NULL,
  `tgl_analisa` date NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `upload_penyimpangan` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyimpangan_air`
--

CREATE TABLE `penyimpangan_air` (
  `id` int(11) NOT NULL,
  `id_sampling` int(11) NOT NULL,
  `id_master_air` int(11) NOT NULL,
  `nama_outlet_sampling` varchar(255) DEFAULT NULL,
  `no_outlet_sampling` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `tanggal_sampling` date DEFAULT NULL,
  `parameter_tms` varchar(500) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `upload_penyimpangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rh`
--

CREATE TABLE `rh` (
  `id` int(11) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `kelas` varchar(12) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `rh_min` decimal(5,2) DEFAULT NULL,
  `rh_max` decimal(5,2) DEFAULT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `tanggal_dilakukan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `editable` int(11) NOT NULL,
  `approve_edit` int(11) NOT NULL,
  `approve_edit_by` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sampling_air_excluded_outlet`
--

CREATE TABLE `sampling_air_excluded_outlet` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_sampling` int(10) UNSIGNED NOT NULL,
  `id_master_air` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `scan_hasil_air`
--

CREATE TABLE `scan_hasil_air` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_sampling` int(10) UNSIGNED NOT NULL,
  `nama_asli` varchar(255) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `uploaded_by` varchar(100) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `site`
--

CREATE TABLE `site` (
  `id` int(11) NOT NULL,
  `site_code` varchar(10) NOT NULL,
  `site` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `site`
--

INSERT INTO `site` (`id`, `site_code`, `site`) VALUES
(1, 'CKR', 'Cikarang'),
(2, 'PLG', 'Pulogadung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suhu`
--

CREATE TABLE `suhu` (
  `id` int(11) NOT NULL,
  `id_ahu` int(11) NOT NULL,
  `id_ppoj` int(11) NOT NULL,
  `no_ppoj` varchar(50) DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `kelas` varchar(123) NOT NULL,
  `suhu_min` decimal(5,2) DEFAULT NULL,
  `suhu_max` decimal(5,2) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `analis` varchar(100) DEFAULT NULL,
  `keterangan` varchar(100) NOT NULL,
  `tanggal_dilakukan` timestamp NULL DEFAULT NULL,
  `editable` int(11) NOT NULL,
  `approve_edit` int(11) NOT NULL,
  `approve_edit_by` varchar(122) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `department` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `department`, `jabatan`, `status`) VALUES
(104, 'fajar.oktavianto', '$2y$10$HcGDR6b/TXUUj33ByreG6.ZhahjoaF4Ofk0zB7n8KPcFYz2lgvCnq', 'fajar.oktavianto@bintang7.com', 'QA', 'administrator', 'approved'),
(107, 'fajar.analys', '$2y$10$HcGDR6b/TXUUj33ByreG6.ZhahjoaF4Ofk0zB7n8KPcFYz2lgvCnq', 'fajar.oktavianto@bintang7.com', 'QA', 'QA Analis', 'approved'),
(108, 'fajar qa', '$2y$10$hyieqNywzKw7tSG36tw/b.ifiR2kTgvDtywUDy4NEPzyYnpPQOK.W', 'fajars.oktav@gmail.com', 'QA', 'Spv QA', 'approved'),
(109, 'CSV', '$2y$12$4KjJoGaS4b9.3R/8ClbMOuLKwDg2PxuaXIgsvTyvTLOvtka6NM6US', 'analis.csv@B7', 'QA', 'QA Analis', 'approved');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_bak`
--

CREATE TABLE `user_bak` (
  `id` int(11) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `jabatan` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_bak`
--

INSERT INTO `user_bak` (`id`, `username`, `password`, `email`, `department`, `jabatan`) VALUES
(1, 'miarosmeida', 'mia123', '', '', 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `audit_trail_swab`
--
ALTER TABLE `audit_trail_swab`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_ahu`
--
ALTER TABLE `data_ahu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_awal_ppoj`
--
ALTER TABLE `data_awal_ppoj`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_awal_swab`
--
ALTER TABLE `data_awal_swab`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_sampling_air`
--
ALTER TABLE `data_sampling_air`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_swab`
--
ALTER TABLE `data_swab`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_titik_sampling_air`
--
ALTER TABLE `data_titik_sampling_air`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_sampling_outlet` (`id_sampling`,`id_master_air`),
  ADD KEY `fk_titik_sampling` (`id_sampling`),
  ADD KEY `fk_titik_master` (`id_master_air`);

--
-- Indeks untuk tabel `dp`
--
ALTER TABLE `dp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `flow`
--
ALTER TABLE `flow`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hasil_sampling_air`
--
ALTER TABLE `hasil_sampling_air`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_sampling` (`id_sampling`),
  ADD KEY `fk_id_master_air` (`id_master_air`);

--
-- Indeks untuk tabel `lux`
--
ALTER TABLE `lux`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_data`
--
ALTER TABLE `master_data`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_data_air`
--
ALTER TABLE `master_data_air`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_data_air_syarat`
--
ALTER TABLE `master_data_air_syarat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_master_param` (`id_master_air`,`parameter`),
  ADD KEY `idx_master` (`id_master_air`);

--
-- Indeks untuk tabel `master_data_dp`
--
ALTER TABLE `master_data_dp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_data_swab`
--
ALTER TABLE `master_data_swab`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_data_swab2`
--
ALTER TABLE `master_data_swab2`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_syarat`
--
ALTER TABLE `master_syarat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mikro_capar`
--
ALTER TABLE `mikro_capar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mikro_volumetrik`
--
ALTER TABLE `mikro_volumetrik`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nama_ahu`
--
ALTER TABLE `nama_ahu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `oos`
--
ALTER TABLE `oos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `oos_air`
--
ALTER TABLE `oos_air`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `partikel`
--
ALTER TABLE `partikel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `partikel_file`
--
ALTER TABLE `partikel_file`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `patogen`
--
ALTER TABLE `patogen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `patogen_swab`
--
ALTER TABLE `patogen_swab`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_ppoj` (`id_ppoj`,`lokasi_sampling`);

--
-- Indeks untuk tabel `penyimpangan`
--
ALTER TABLE `penyimpangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penyimpangan_air`
--
ALTER TABLE `penyimpangan_air`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rh`
--
ALTER TABLE `rh`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sampling_air_excluded_outlet`
--
ALTER TABLE `sampling_air_excluded_outlet`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `scan_hasil_air`
--
ALTER TABLE `scan_hasil_air`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sampling` (`id_sampling`);

--
-- Indeks untuk tabel `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `suhu`
--
ALTER TABLE `suhu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `audit_trail_swab`
--
ALTER TABLE `audit_trail_swab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_ahu`
--
ALTER TABLE `data_ahu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_awal_ppoj`
--
ALTER TABLE `data_awal_ppoj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_awal_swab`
--
ALTER TABLE `data_awal_swab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_sampling_air`
--
ALTER TABLE `data_sampling_air`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_swab`
--
ALTER TABLE `data_swab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT untuk tabel `data_titik_sampling_air`
--
ALTER TABLE `data_titik_sampling_air`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dp`
--
ALTER TABLE `dp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1513;

--
-- AUTO_INCREMENT untuk tabel `flow`
--
ALTER TABLE `flow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2722;

--
-- AUTO_INCREMENT untuk tabel `hasil_sampling_air`
--
ALTER TABLE `hasil_sampling_air`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lux`
--
ALTER TABLE `lux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT untuk tabel `master_data`
--
ALTER TABLE `master_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT untuk tabel `master_data_air`
--
ALTER TABLE `master_data_air`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_data_air_syarat`
--
ALTER TABLE `master_data_air_syarat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_data_dp`
--
ALTER TABLE `master_data_dp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT untuk tabel `master_data_swab`
--
ALTER TABLE `master_data_swab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1519;

--
-- AUTO_INCREMENT untuk tabel `master_data_swab2`
--
ALTER TABLE `master_data_swab2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `master_syarat`
--
ALTER TABLE `master_syarat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `mikro_capar`
--
ALTER TABLE `mikro_capar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT untuk tabel `mikro_volumetrik`
--
ALTER TABLE `mikro_volumetrik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2639;

--
-- AUTO_INCREMENT untuk tabel `nama_ahu`
--
ALTER TABLE `nama_ahu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `oos`
--
ALTER TABLE `oos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `oos_air`
--
ALTER TABLE `oos_air`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `partikel`
--
ALTER TABLE `partikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT untuk tabel `partikel_file`
--
ALTER TABLE `partikel_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `patogen`
--
ALTER TABLE `patogen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;

--
-- AUTO_INCREMENT untuk tabel `patogen_swab`
--
ALTER TABLE `patogen_swab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=768;

--
-- AUTO_INCREMENT untuk tabel `penyimpangan`
--
ALTER TABLE `penyimpangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `penyimpangan_air`
--
ALTER TABLE `penyimpangan_air`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rh`
--
ALTER TABLE `rh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sampling_air_excluded_outlet`
--
ALTER TABLE `sampling_air_excluded_outlet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `scan_hasil_air`
--
ALTER TABLE `scan_hasil_air`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `suhu`
--
ALTER TABLE `suhu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `master_data_air_syarat`
--
ALTER TABLE `master_data_air_syarat`
  ADD CONSTRAINT `fk_syarat_master` FOREIGN KEY (`id_master_air`) REFERENCES `master_data_air` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `scan_hasil_air`
--
ALTER TABLE `scan_hasil_air`
  ADD CONSTRAINT `scan_hasil_air_id_sampling_foreign` FOREIGN KEY (`id_sampling`) REFERENCES `data_sampling_air` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
