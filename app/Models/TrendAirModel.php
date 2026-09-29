<?php

namespace App\Models;

use CodeIgniter\Model;

class TrendAirModel extends Model
{
    /**
     * Ambil seluruh baris hasil pengujian untuk kombinasi site + kategori
     * (nama kategori jenis_sampling, tanpa suffix " - Mingguan/Bulanan")
     * dalam rentang tanggal tertentu, sudah digabung dengan info titik
     * sampling (nama/no outlet) dan minggu.
     *
     * Grain hasilnya: 1 baris = 1 outlet x 1 laporan sampling (id_sampling).
     * Kolom hasil_* dikembalikan mentah (varchar) — konversi ke angka
     * dilakukan di controller sesuai tipe tiap parameter.
     */
    public function ambilTrend(string $site, string $kategori, ?string $tanggalMulai, ?string $tanggalAkhir): array
    {
        $builder = $this->db->table('data_sampling_air ds');
        $builder->select('
            ds.id            AS id_sampling,
            ds.tanggal_sampling,
            ds.week,
            ds.site,
            ds.jenis_sampling,
            ds.status,
            dt.id_master_air,
            dt.no_outlet_sampling,
            dt.nama_outlet_sampling,
            hs.hasil_warna, hs.hasil_bau, hs.hasil_ph, hs.hasil_suhu,
            hs.hasil_conductivity, hs.hasil_kesadahan, hs.hasil_zat_padat_total, hs.hasil_toc,
            hs.hasil_tamc, hs.hasil_tymc, hs.hasil_coliform, hs.hasil_e_coli,
            hs.hasil_salmonella_sp, hs.hasil_staphylococcus_aureus, hs.hasil_pseudomonas_aeruginosa,
            hs.hasil_shigella_sp, hs.hasil_enterobacteriaceae, hs.hasil_clostridia, hs.hasil_sporogens
        ');
        $builder->join('data_titik_sampling_air dt', 'dt.id_sampling = ds.id', 'inner');
        $builder->join('hasil_sampling_air hs', 'hs.id_sampling = ds.id AND hs.id_master_air = dt.id_master_air', 'left');

        $builder->where('ds.site', $site);
        // jenis_sampling tersimpan sebagai "{kategori} - Mingguan/Bulanan",
        // jadi dicocokkan sebagai prefix ("kategori%")
        $builder->like('ds.jenis_sampling', $kategori, 'after');

        if ($tanggalMulai) {
            $builder->where('ds.tanggal_sampling >=', $tanggalMulai);
        }
        if ($tanggalAkhir) {
            $builder->where('ds.tanggal_sampling <=', $tanggalAkhir);
        }

        $builder->orderBy('ds.tanggal_sampling', 'ASC');
        $builder->orderBy('dt.id_master_air', 'ASC');

        return $builder->get()->getResultArray();
    }

    // Daftar site yang punya data sampling air (untuk dropdown filter)
    public function daftarSite(): array
    {
        return $this->db->table('data_sampling_air')
            ->select('site')
            ->distinct()
            ->where('site IS NOT NULL')
            ->orderBy('site', 'ASC')
            ->get()->getResultArray();
    }
}