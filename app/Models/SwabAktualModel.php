<?php

namespace App\Models;
use CodeIgniter\Model;

class SwabAktualModel extends Model
{
    protected $table      = 'data_awal_swab';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'no_ppoj', 'tanggal_sampling', 'tanggal_dibersihkan', 'kategori',
        'site', 'keterangan', 'status', 'nama_mesin_personil_alat',
        'kelas', 'departemen', 'nama_ruangan', 'ahu', 'id_swab',
        'approve_1', 'approve_1_date', 'approve_2', 'approve_2_date',
        'approve_3', 'approve_3_date', 'approve_4', 'approve_4_date'
    ];

   public function getTotalAktual($periode, $kategori, $tahun)
{
    $start_date = '';
    $end_date = '';

    if ($periode == 'Caturwulan 1') {
        $start_date = "$tahun-01-01";
        $end_date   = "$tahun-04-30";
    } elseif ($periode == 'Caturwulan 2') {
        $start_date = "$tahun-05-01";
        $end_date   = "$tahun-08-31";
    } elseif ($periode == 'Caturwulan 3') {
        $start_date = "$tahun-09-01";
        $end_date   = "$tahun-12-31";
    } elseif ($periode == 'Semester 1') {
        $start_date = "$tahun-01-01";
        $end_date   = "$tahun-06-30";
    } elseif ($periode == 'Semester 2') {
        $start_date = "$tahun-07-01";
        $end_date   = "$tahun-12-31";
    }

    $kategoriCaturwulan = ['Mesin (Bagian Dalam)', 'Alat Bagian Dalam'];
    $kategoriSemester = ['Mesin (Bagian Luar)', 'Alat Bagian Luar', 'Personil'];

    if (
        (str_contains($periode, 'Caturwulan') && !in_array($kategori, $kategoriCaturwulan)) ||
        (str_contains($periode, 'Semester') && !in_array($kategori, $kategoriSemester))
    ) {
        return 0;
    }

    return $this->where('kategori', $kategori)
                ->where('tanggal_sampling >=', $start_date)
                ->where('tanggal_sampling <=', $end_date)
                ->whereNotIn('keterangan', ['Verifikasi', 'Sampling Ulang 1', 'Sampling Ulang 2'])
                ->countAllResults();
}






public function getTrendByCategory($kategori, $start_date, $end_date)
{
    // Query dengan placeholder ? untuk parameter binding
    $query = "
        SELECT 
    CASE
        WHEN MONTH(data_awal_swab.tanggal_sampling) BETWEEN 1 AND 4 THEN 'Caturwulan 1'
        WHEN MONTH(data_awal_swab.tanggal_sampling) BETWEEN 5 AND 8 THEN 'Caturwulan 2'
        WHEN MONTH(data_awal_swab.tanggal_sampling) BETWEEN 9 AND 12 THEN 'Caturwulan 3'
    END AS periode,
    data_awal_swab.nama_mesin_personil_alat,
    COUNT(DISTINCT patogen_swab.id_ppoj) AS jumlah
FROM patogen_swab
LEFT JOIN data_awal_swab 
    ON patogen_swab.id_ppoj = data_awal_swab.id
WHERE data_awal_swab.kategori = ?
    AND patogen_swab.keterangan = 'TMS'
    AND data_awal_swab.tanggal_sampling >= ?
    AND data_awal_swab.tanggal_sampling <= ?
GROUP BY periode, data_awal_swab.nama_mesin_personil_alat
ORDER BY periode, data_awal_swab.nama_mesin_personil_alat
    ";

    // Menjalankan query dengan parameter binding menggunakan array
    return $this->db->query($query, [
        $kategori,
        $start_date,
        $end_date
    ])->getResultArray();
}
}
