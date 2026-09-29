-- PostgreSQL Database Dump
-- Generated from MySQL: validas1_ehm_report
-- Converted from MySQL to PostgreSQL format
-- Compatible with PostgreSQL 12+

-- Set default parameters
SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET default_table_access_method = heap;

-- Create sequences for auto-increment fields
CREATE SEQUENCE IF NOT EXISTS audit_trail_swab_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS data_ahu_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS data_awal_ppoj_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS data_awal_swab_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS data_sampling_air_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS data_swab_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS data_titik_sampling_air_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS dp_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS flow_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS hasil_sampling_air_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS lux_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS master_data_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS master_data_air_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS master_data_air_syarat_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS master_data_dp_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS master_data_swab_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS master_data_swab2_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS master_syarat_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS migrations_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS mikro_capar_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS mikro_volumetrik_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS nama_ahu_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS oos_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS oos_air_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS partikel_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS partikel_file_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS patogen_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS patogen_swab_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS penyimpangan_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS penyimpangan_air_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS rh_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS sampling_air_excluded_outlet_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS scan_hasil_air_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS site_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS suhu_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS "user_id_seq" START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
CREATE SEQUENCE IF NOT EXISTS user_bak_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

-- ============================================================
-- Create Tables
-- ============================================================

CREATE TABLE IF NOT EXISTS audit_trail_swab (
    id INTEGER NOT NULL DEFAULT nextval('audit_trail_swab_id_seq'),
    "timestamp" TIMESTAMP NOT NULL,
    username VARCHAR(100) NOT NULL,
    action VARCHAR(10) NOT NULL,
    table_name VARCHAR(100) NOT NULL,
    record_id INTEGER NOT NULL,
    old_value TEXT,
    new_value TEXT,
    ip_address VARCHAR(45) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS data_ahu (
    id INTEGER NOT NULL DEFAULT nextval('data_ahu_id_seq'),
    ahu VARCHAR(100) NOT NULL,
    tanggaldilakukan DATE NOT NULL,
    site VARCHAR(100) NOT NULL,
    keterangan VARCHAR(50) NOT NULL,
    jenispemeriksaan VARCHAR(100) NOT NULL,
    status VARCHAR(50) NOT NULL,
    kondisi VARCHAR(123) NOT NULL,
    approve_1 VARCHAR(155) NOT NULL,
    approve_1_date DATE NOT NULL,
    approve_2 VARCHAR(155) NOT NULL,
    approve_2_date DATE NOT NULL,
    approve_3 VARCHAR(155) NOT NULL,
    approve_3_date DATE NOT NULL,
    approve_4 VARCHAR(155) NOT NULL,
    approve_4_date DATE NOT NULL,
    statusSuhu INTEGER NOT NULL,
    statusRh INTEGER NOT NULL,
    statusDp INTEGER NOT NULL,
    statusFlow INTEGER NOT NULL,
    statusPartikel INTEGER NOT NULL,
    statusLux INTEGER NOT NULL,
    statusMas INTEGER NOT NULL,
    statusCapar INTEGER NOT NULL,
    statusPatogen INTEGER NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS data_awal_ppoj (
    id INTEGER NOT NULL DEFAULT nextval('data_awal_ppoj_id_seq'),
    no_ppoj VARCHAR(50) NOT NULL,
    id_ahu INTEGER NOT NULL,
    ahu VARCHAR(20) NOT NULL,
    tanggaldilakukan DATE NOT NULL,
    site VARCHAR(20) NOT NULL,
    nama_ruangan VARCHAR(50) NOT NULL,
    kelas VARCHAR(50) NOT NULL,
    kondisi VARCHAR(20) NOT NULL,
    status VARCHAR(122) NOT NULL,
    jenispemeriksaan VARCHAR(111) NOT NULL,
    jumlah_pertukaran_udara VARCHAR(11) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS data_awal_swab (
    id INTEGER NOT NULL DEFAULT nextval('data_awal_swab_id_seq'),
    no_ppoj VARCHAR(50) NOT NULL,
    tanggal_sampling DATE,
    tanggal_dibersihkan DATE,
    kategori VARCHAR(100),
    site VARCHAR(100),
    keterangan TEXT,
    status VARCHAR(50),
    nama_mesin_personil_alat VARCHAR(150),
    kelas VARCHAR(50),
    departemen VARCHAR(100),
    nama_ruangan VARCHAR(100),
    ahu VARCHAR(100),
    id_swab INTEGER,
    approve_1 VARCHAR(100),
    approve_1_date TIMESTAMP,
    approve_2 VARCHAR(100),
    approve_2_date TIMESTAMP,
    approve_3 VARCHAR(100),
    approve_3_date TIMESTAMP,
    approve_4 VARCHAR(100),
    approve_4_date TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS data_sampling_air (
    id INTEGER NOT NULL DEFAULT nextval('data_sampling_air_id_seq'),
    tanggal_sampling DATE,
    site VARCHAR(10),
    jenis_sampling VARCHAR(100),
    week VARCHAR(10),
    keterangan VARCHAR(50),
    note TEXT,
    status VARCHAR(50),
    approve_1 VARCHAR(100),
    approve_1_date TIMESTAMP,
    approve_qc_kimia VARCHAR(100),
    approve_qc_kimia_date TIMESTAMP,
    approve_qc_mikro VARCHAR(100),
    approve_qc_mikro_date TIMESTAMP,
    approve_spv_qc VARCHAR(100),
    approve_spv_qa VARCHAR(100),
    approve_spv_qa_date TIMESTAMP,
    approve_spv_qc_date TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS data_swab (
    id INTEGER NOT NULL DEFAULT nextval('data_swab_id_seq'),
    tanggal_sampling DATE,
    ahu VARCHAR(100),
    site VARCHAR(100),
    kategori VARCHAR(100),
    status VARCHAR(50),
    keterangan TEXT,
    created_ad TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    approve_1 VARCHAR(100) NOT NULL,
    approve_1_date DATE NOT NULL,
    approve_2 VARCHAR(100) NOT NULL,
    approve_2_date DATE NOT NULL,
    approve_3 VARCHAR(100) NOT NULL,
    approve_3_date DATE NOT NULL,
    approve_4 VARCHAR(100) NOT NULL,
    approve_4_date DATE NOT NULL,
    statusPatogen INTEGER NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS data_titik_sampling_air (
    id INTEGER NOT NULL DEFAULT nextval('data_titik_sampling_air_id_seq'),
    id_sampling INTEGER NOT NULL,
    id_master_air INTEGER NOT NULL,
    no_outlet_sampling VARCHAR(100),
    nama_outlet_sampling VARCHAR(255),
    lokasi VARCHAR(255),
    site VARCHAR(100),
    jenis_sampling VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE (id_sampling, id_master_air)
);

CREATE TABLE IF NOT EXISTS dp (
    id INTEGER NOT NULL DEFAULT nextval('dp_id_seq'),
    id_ahu INTEGER NOT NULL,
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_ruangan VARCHAR(100),
    terhadap_ruangan VARCHAR(100),
    hasil_dp VARCHAR(15),
    analis VARCHAR(100),
    status INTEGER NOT NULL,
    tanggal_dilakukan TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    keterangan VARCHAR(123) NOT NULL,
    editable INTEGER NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS flow (
    id INTEGER NOT NULL DEFAULT nextval('flow_id_seq'),
    id_ahu INTEGER NOT NULL,
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_ruangan VARCHAR(100),
    hasil_flow NUMERIC(10,2),
    volume_ruangan INTEGER NOT NULL,
    keterangan VARCHAR(222) NOT NULL,
    status INTEGER NOT NULL,
    analis VARCHAR(100),
    tanggal_dilakukan TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS hasil_sampling_air (
    id INTEGER NOT NULL DEFAULT nextval('hasil_sampling_air_id_seq'),
    id_sampling INTEGER,
    id_master_air INTEGER,
    hasil_warna VARCHAR(100),
    hasil_bau VARCHAR(100),
    hasil_ph VARCHAR(50),
    hasil_suhu VARCHAR(50),
    hasil_conductivity VARCHAR(50),
    hasil_kesadahan VARCHAR(50),
    hasil_zat_padat_total VARCHAR(50),
    hasil_toc VARCHAR(50),
    hasil_tamc VARCHAR(50),
    hasil_tymc VARCHAR(50),
    hasil_coliform VARCHAR(50),
    hasil_e_coli VARCHAR(50),
    hasil_salmonella_sp VARCHAR(50),
    hasil_staphylococcus_aureus VARCHAR(50),
    hasil_pseudomonas_aeruginosa VARCHAR(50),
    hasil_shigella_sp VARCHAR(50),
    hasil_enterobacteriaceae VARCHAR(50),
    hasil_clostridia VARCHAR(50),
    hasil_sporogens VARCHAR(50),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS kondisi (
    kondisi VARCHAR(50) NOT NULL,
    PRIMARY KEY (kondisi)
);

CREATE TABLE IF NOT EXISTS lux (
    id INTEGER NOT NULL DEFAULT nextval('lux_id_seq'),
    id_ahu INTEGER NOT NULL,
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_ruangan VARCHAR(100),
    hasil_lux VARCHAR(255),
    analis VARCHAR(100),
    status INTEGER NOT NULL,
    keterangan VARCHAR(222) NOT NULL,
    tanggal_dilakukan TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS master_data (
    id INTEGER NOT NULL DEFAULT nextval('master_data_id_seq'),
    nama_ahu VARCHAR(20) NOT NULL,
    keterangan VARCHAR(255) NOT NULL,
    nama_ruangan VARCHAR(255) NOT NULL,
    kelas VARCHAR(10) NOT NULL,
    suhu_min INTEGER NOT NULL,
    suhu_max INTEGER NOT NULL,
    rh_min INTEGER NOT NULL,
    rh_max INTEGER NOT NULL,
    lux INTEGER NOT NULL,
    "Perbedaan_Tekanan" INTEGER NOT NULL,
    "Pertukaran_Udara" INTEGER NOT NULL,
    "Partikel_05AR" INTEGER NOT NULL,
    "Partikel_50AR" INTEGER NOT NULL,
    "Partikel_05IO" INTEGER NOT NULL,
    "Partikel_50IO" INTEGER NOT NULL,
    "Volumetrik_TPC" INTEGER NOT NULL,
    "Volumetrik_KK" INTEGER NOT NULL,
    "Capar_TPC" INTEGER NOT NULL,
    "Capar_KK" INTEGER NOT NULL,
    titik_suhu VARCHAR(10) NOT NULL,
    titik_rh VARCHAR(10) NOT NULL,
    titik_mikro INTEGER NOT NULL,
    titik_partikel INTEGER NOT NULL,
    titik_capar VARCHAR(10) NOT NULL,
    titik_flow VARCHAR(255) NOT NULL,
    titik_lux VARCHAR(50) NOT NULL,
    patogen VARCHAR(50) NOT NULL,
    volume_ruangan VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS master_data_air (
    id INTEGER NOT NULL DEFAULT nextval('master_data_air_id_seq'),
    lokasi VARCHAR(255),
    site VARCHAR(255),
    jenis_sampling VARCHAR(100),
    no_outlet_sampling VARCHAR(50),
    nama_outlet_sampling VARCHAR(255),
    jadwal_minggu_ke VARCHAR(50),
    syarat_warna VARCHAR(100),
    syarat_bau VARCHAR(100),
    syarat_ph VARCHAR(50),
    syarat_suhu VARCHAR(50),
    syarat_conductivity VARCHAR(50),
    syarat_kesadahan VARCHAR(50),
    syarat_zat_padat_total VARCHAR(50),
    syarat_toc VARCHAR(50),
    syarat_tamc VARCHAR(50),
    syarat_tymc VARCHAR(50),
    syarat_coliform VARCHAR(50),
    syarat_e_coli VARCHAR(50),
    syarat_salmonella_sp VARCHAR(50),
    syarat_staphylococcus_aureus VARCHAR(50),
    syarat_pseudomonas_aeruginosa VARCHAR(50),
    syarat_shigella_sp VARCHAR(50),
    syarat_enterobacteriaceae VARCHAR(50),
    syarat_clostridia VARCHAR(50),
    syarat_sporogens VARCHAR(50),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS master_data_air_syarat (
    id INTEGER NOT NULL DEFAULT nextval('master_data_air_syarat_id_seq'),
    id_master_air INTEGER NOT NULL,
    parameter VARCHAR(50) NOT NULL,
    tipe VARCHAR(10) NOT NULL CHECK (tipe IN ('numerik', 'teks')),
    operator VARCHAR(50),
    nilai_min NUMERIC(12,4),
    nilai_max NUMERIC(12,4),
    nilai_teks VARCHAR(100),
    satuan VARCHAR(20),
    PRIMARY KEY (id),
    UNIQUE (id_master_air, parameter)
);

CREATE TABLE IF NOT EXISTS master_data_dp (
    id INTEGER NOT NULL DEFAULT nextval('master_data_dp_id_seq'),
    ahu VARCHAR(10) NOT NULL,
    keterangan VARCHAR(200) NOT NULL,
    nama_ruangan VARCHAR(200) NOT NULL,
    kelas VARCHAR(10) NOT NULL,
    terhadap_ruangan VARCHAR(200) NOT NULL,
    kelas_pembanding VARCHAR(10) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS master_data_swab (
    id INTEGER NOT NULL DEFAULT nextval('master_data_swab_id_seq'),
    site VARCHAR(100),
    ahu VARCHAR(100),
    kategori VARCHAR(100),
    nama_mesin_personil_alat VARCHAR(150),
    kelas VARCHAR(100),
    nama_ruangan VARCHAR(100),
    departemen VARCHAR(100),
    lokasi_sampling VARCHAR(100),
    periode VARCHAR(100),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS master_data_swab2 (
    id INTEGER NOT NULL DEFAULT nextval('master_data_swab2_id_seq'),
    site VARCHAR(100),
    ahu VARCHAR(100),
    kategori VARCHAR(100),
    nama_mesin_personil_alat VARCHAR(150),
    kelas VARCHAR(100),
    nama_ruangan VARCHAR(100),
    departemen VARCHAR(100),
    lokasi_sampling VARCHAR(100),
    periode VARCHAR(100),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS master_syarat (
    id INTEGER NOT NULL DEFAULT nextval('master_syarat_id_seq'),
    kelas VARCHAR(11) NOT NULL,
    suhu_min INTEGER NOT NULL,
    suhu_max INTEGER NOT NULL,
    rh_min INTEGER NOT NULL,
    rh_max INTEGER NOT NULL,
    perbedaan_tekanan_ruangan INTEGER NOT NULL,
    jumlah_pertukaran_udara INTEGER NOT NULL,
    partikel_05_atrest INTEGER NOT NULL,
    partikel_50_atrest INTEGER NOT NULL,
    partikel_05_inop VARCHAR(11) NOT NULL,
    partikel_50_inop VARCHAR(11) NOT NULL,
    volumetrik_tpc INTEGER NOT NULL,
    volumetrik_kk INTEGER NOT NULL,
    capar_tpc VARCHAR(11) NOT NULL,
    capar_kk VARCHAR(11) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS migrations (
    id BIGSERIAL NOT NULL,
    version VARCHAR(255) NOT NULL,
    class VARCHAR(255) NOT NULL,
    group VARCHAR(255) NOT NULL,
    namespace VARCHAR(255) NOT NULL,
    "time" INTEGER NOT NULL,
    batch INTEGER NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS mikro_capar (
    id INTEGER NOT NULL DEFAULT nextval('mikro_capar_id_seq'),
    id_ahu INTEGER NOT NULL,
    status INTEGER NOT NULL,
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_ruangan VARCHAR(100) NOT NULL,
    kelas VARCHAR(10) NOT NULL,
    hasil_tpc INTEGER,
    hasil_kk INTEGER,
    analis VARCHAR(100),
    tanggal_dilakukan TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    keterangan VARCHAR(50) NOT NULL,
    tanggal_edit TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    editable INTEGER NOT NULL,
    approve_edit INTEGER NOT NULL,
    approve_edit_by VARCHAR(123) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS mikro_volumetrik (
    id INTEGER NOT NULL DEFAULT nextval('mikro_volumetrik_id_seq'),
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_ruangan VARCHAR(100) NOT NULL,
    kelas VARCHAR(10) NOT NULL,
    hasil_tpc INTEGER,
    hasil_kk INTEGER,
    analis VARCHAR(100),
    tanggal_dilakukan TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    keterangan VARCHAR(50) NOT NULL,
    tanggal_edit TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    editable INTEGER NOT NULL,
    approve_edit INTEGER NOT NULL,
    approve_edit_by VARCHAR(122) NOT NULL,
    id_ahu INTEGER NOT NULL,
    status INTEGER NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS nama_ahu (
    id INTEGER NOT NULL DEFAULT nextval('nama_ahu_id_seq'),
    ahu VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS oos (
    id INTEGER NOT NULL DEFAULT nextval('oos_id_seq'),
    id_swab INTEGER NOT NULL,
    nama_mesin_personil_alat VARCHAR(255) NOT NULL,
    lokasi_sampling VARCHAR(255) NOT NULL,
    tanggal_sampling DATE NOT NULL,
    tgl_analisa DATE NOT NULL,
    keterangan VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    upload_oos VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS oos_air (
    id INTEGER NOT NULL DEFAULT nextval('oos_air_id_seq'),
    id_sampling INTEGER NOT NULL,
    id_master_air INTEGER NOT NULL,
    nama_outlet_sampling VARCHAR(255),
    no_outlet_sampling VARCHAR(100),
    site VARCHAR(100),
    tanggal_sampling DATE,
    parameter_tms VARCHAR(500),
    keterangan TEXT,
    status VARCHAR(50),
    upload_oos VARCHAR(255),
    created_at TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS partikel (
    id INTEGER NOT NULL DEFAULT nextval('partikel_id_seq'),
    id_ahu INTEGER NOT NULL,
    nama_ahu VARCHAR(222) NOT NULL,
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_ruangan VARCHAR(100),
    hasil_partikel VARCHAR(255),
    analis VARCHAR(100),
    keterangan VARCHAR(222) NOT NULL,
    tanggal_dilakukan TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS partikel_file (
    id INTEGER NOT NULL DEFAULT nextval('partikel_file_id_seq'),
    id_partikel INTEGER NOT NULL,
    file VARCHAR(255) NOT NULL,
    keterangan VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS patogen (
    id INTEGER NOT NULL DEFAULT nextval('patogen_id_seq'),
    id_ahu INTEGER NOT NULL,
    status INTEGER NOT NULL,
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_ruangan VARCHAR(100),
    e_coli VARCHAR(10),
    salmonella_sp VARCHAR(10) NOT NULL,
    staphylococcus_aureus VARCHAR(10) NOT NULL,
    pseudomonas_aeruginosa VARCHAR(10) NOT NULL,
    shigella_sp VARCHAR(10) NOT NULL,
    enterobacteriaceae VARCHAR(10) NOT NULL,
    clostridia_sporogens VARCHAR(10) NOT NULL,
    analis VARCHAR(100),
    tgl_analisa DATE NOT NULL,
    keterangan VARCHAR(222) NOT NULL,
    tanggal_dilakukan TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS patogen_swab (
    id INTEGER NOT NULL DEFAULT nextval('patogen_swab_id_seq'),
    id_swab INTEGER NOT NULL,
    status INTEGER NOT NULL,
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_mesin_personil_alat VARCHAR(100),
    tanggal_dibersihkan DATE NOT NULL,
    lokasi_sampling VARCHAR(50) NOT NULL,
    tanggal_sampling DATE NOT NULL,
    "TAMC" INTEGER NOT NULL,
    "TYMC" INTEGER NOT NULL,
    e_coli VARCHAR(10),
    salmonella_sp VARCHAR(10) NOT NULL,
    staphylococcus_aureus VARCHAR(10) NOT NULL,
    pseudomonas_aeruginosa VARCHAR(10) NOT NULL,
    shigella_sp VARCHAR(10) NOT NULL,
    enterobacteriaceae VARCHAR(10) NOT NULL,
    clostridia_sporogens VARCHAR(10) NOT NULL,
    analis VARCHAR(100),
    tgl_analisa DATE NOT NULL,
    tgl_koloni DATE NOT NULL,
    keterangan VARCHAR(222) NOT NULL,
    tanggal_dilakukan TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    editable INTEGER NOT NULL,
    approve_edit INTEGER NOT NULL,
    approve_edit_by VARCHAR(50) NOT NULL,
    tanggal_edit DATE NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS penyimpangan (
    id INTEGER NOT NULL DEFAULT nextval('penyimpangan_id_seq'),
    id_swab INTEGER NOT NULL,
    nama_mesin_personil_alat VARCHAR(255) NOT NULL,
    lokasi_sampling VARCHAR(255) NOT NULL,
    tanggal_sampling DATE NOT NULL,
    tgl_analisa DATE NOT NULL,
    keterangan VARCHAR(50) NOT NULL,
    upload_penyimpangan VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS penyimpangan_air (
    id INTEGER NOT NULL DEFAULT nextval('penyimpangan_air_id_seq'),
    id_sampling INTEGER NOT NULL,
    id_master_air INTEGER NOT NULL,
    nama_outlet_sampling VARCHAR(255),
    no_outlet_sampling VARCHAR(100),
    site VARCHAR(100),
    tanggal_sampling DATE,
    parameter_tms VARCHAR(500),
    keterangan TEXT,
    status VARCHAR(50),
    upload_penyimpangan VARCHAR(255),
    created_at TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS rh (
    id INTEGER NOT NULL DEFAULT nextval('rh_id_seq'),
    id_ahu INTEGER NOT NULL,
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_ruangan VARCHAR(100),
    kelas VARCHAR(12) NOT NULL,
    keterangan VARCHAR(20) NOT NULL,
    rh_min NUMERIC(5,2),
    rh_max NUMERIC(5,2),
    analis VARCHAR(100),
    status INTEGER NOT NULL,
    tanggal_dilakukan TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    editable INTEGER NOT NULL,
    approve_edit INTEGER NOT NULL,
    approve_edit_by VARCHAR(155) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS sampling_air_excluded_outlet (
    id INTEGER NOT NULL DEFAULT nextval('sampling_air_excluded_outlet_id_seq'),
    id_sampling INTEGER NOT NULL,
    id_master_air INTEGER NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS scan_hasil_air (
    id INTEGER NOT NULL DEFAULT nextval('scan_hasil_air_id_seq'),
    id_sampling INTEGER NOT NULL,
    nama_asli VARCHAR(255) NOT NULL,
    nama_file VARCHAR(255) NOT NULL,
    uploaded_by VARCHAR(100),
    uploaded_at TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS site (
    id INTEGER NOT NULL DEFAULT nextval('site_id_seq'),
    site_code VARCHAR(10) NOT NULL,
    site VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS suhu (
    id INTEGER NOT NULL DEFAULT nextval('suhu_id_seq'),
    id_ahu INTEGER NOT NULL,
    id_ppoj INTEGER NOT NULL,
    no_ppoj VARCHAR(50),
    nama_ruangan VARCHAR(100),
    kelas VARCHAR(123) NOT NULL,
    suhu_min NUMERIC(5,2),
    suhu_max NUMERIC(5,2),
    status INTEGER NOT NULL,
    analis VARCHAR(100),
    keterangan VARCHAR(100) NOT NULL,
    tanggal_dilakukan TIMESTAMP,
    editable INTEGER NOT NULL,
    approve_edit INTEGER NOT NULL,
    approve_edit_by VARCHAR(122) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS "user" (
    id INTEGER NOT NULL DEFAULT nextval('user_id_seq'),
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(200) NOT NULL,
    department VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending', 'approved', 'rejected')),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS user_bak (
    id INTEGER NOT NULL DEFAULT nextval('user_bak_id_seq'),
    username VARCHAR(25),
    password VARCHAR(25) NOT NULL,
    email VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    jabatan VARCHAR(25) NOT NULL,
    PRIMARY KEY (id)
);

-- ============================================================
-- Create Indexes
-- ============================================================

CREATE INDEX IF NOT EXISTS idx_data_titik_sampling_air_id_sampling ON data_titik_sampling_air(id_sampling);
CREATE INDEX IF NOT EXISTS idx_data_titik_sampling_air_id_master ON data_titik_sampling_air(id_master_air);
CREATE INDEX IF NOT EXISTS idx_hasil_sampling_air_id_sampling ON hasil_sampling_air(id_sampling);
CREATE INDEX IF NOT EXISTS idx_hasil_sampling_air_id_master_air ON hasil_sampling_air(id_master_air);
CREATE INDEX IF NOT EXISTS idx_master_data_air_syarat_master ON master_data_air_syarat(id_master_air);

-- ============================================================
-- Insert Data
-- ============================================================

-- Insert site data
INSERT INTO site (id, site_code, site) VALUES
(1, 'CKR', 'Cikarang'),
(2, 'PLG', 'Pulogadung')
ON CONFLICT (id) DO NOTHING;

-- Insert user data
INSERT INTO "user" (id, username, password, email, department, jabatan, status) VALUES
(104, 'fajar.oktavianto', '$2y$10$HcGDR6b/TXUUj33ByreG6.ZhahjoaF4Ofk0zB7n8KPcFYz2lgvCnq', 'fajar.oktavianto@bintang7.com', 'QA', 'administrator', 'approved'),
(107, 'fajar.analys', '$2y$10$HcGDR6b/TXUUj33ByreG6.ZhahjoaF4Ofk0zB7n8KPcFYz2lgvCnq', 'fajar.oktavianto@bintang7.com', 'QA', 'QA Analis', 'approved'),
(108, 'fajar qa', '$2y$10$hyieqNywzKw7tSG36tw/b.ifiR2kTgvDtywUDy4NEPzyYnpPQOK.W', 'fajars.oktav@gmail.com', 'QA', 'Spv QA', 'approved'),
(109, 'CSV', '$2y$12$4KjJoGaS4b9.3R/8ClbMOuLKwDg2PxuaXIgsvTyvTLOvtka6NM6US', 'analis.csv@B7', 'QA', 'QA Analis', 'approved')
ON CONFLICT (id) DO NOTHING;

-- Insert user_bak data
INSERT INTO user_bak (id, username, password, email, department, jabatan) VALUES
(1, 'miarosmeida', 'mia123', '', '', 'Staff')
ON CONFLICT (id) DO NOTHING;

-- Insert migrations data
INSERT INTO migrations (id, version, class, group, namespace, "time", batch) VALUES
(1, '2026-07-17-000001', 'App\\Database\\Migrations\\CreateScanHasilAir', 'default', 'App', 1784254817, 1)
ON CONFLICT (id) DO NOTHING;

-- ============================================================
-- Set Sequence Values
-- ============================================================

SELECT setval('site_id_seq', (SELECT MAX(id) FROM site) + 1);
SELECT setval('user_id_seq', (SELECT MAX(id) FROM "user") + 1);
SELECT setval('user_bak_id_seq', (SELECT MAX(id) FROM user_bak) + 1);
SELECT setval('migrations_id_seq', (SELECT MAX(id) FROM migrations) + 1);

-- ============================================================
-- End of PostgreSQL Database Dump
-- ============================================================
