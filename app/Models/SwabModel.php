<?php

namespace App\Models;
use CodeIgniter\Model;

class SwabModel extends Model
{
    protected $table      = 'master_data_swab';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'site', 'ahu', 'kategori', 'nama_mesin_personil_alat', 'kelas',
        'nama_ruangan', 'departemen', 'lokasi_sampling', 'periode'
    ];

    public function getTotalTarget($periode, $kategori)
{
    return $this->select('nama_mesin_personil_alat')
                ->where('periode', $periode)
                ->where('kategori', $kategori)
                ->groupBy('nama_mesin_personil_alat')
                ->countAllResults(false); // false agar tidak reset builder
}

    public function getTrend($kategori)
    {
        return $this->select('periode, COUNT(*) as jumlah')
                    ->where('kategori', $kategori)
                    ->groupBy('periode')
                    ->orderBy('periode')
                    ->findAll();
    }
}
