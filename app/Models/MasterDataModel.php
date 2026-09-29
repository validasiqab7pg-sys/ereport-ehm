<?php
namespace App\Models;

use CodeIgniter\Model;

class MasterDataModel extends Model
{
    protected $table = 'master_data';      // Nama tabel database
    protected $primaryKey = 'id';          

    // Kolom yang diizinkan untuk insert/update
    protected $allowedFields = [
        'nama_ahu',
        'keterangan',
        'nama_ruangan',
        'kelas',
        'suhu_min',
        'suhu_max',
        'rh_min',
        'rh_max',
        'lux',
        'Perbedaan_Tekanan',
        'Pertukaran_Udara',
        'Partikel_0.5AR',
        'Partikel_5.0AR',
        'Partikel_0.5IO',
        'Partikel_5.0IO',
        'Volumetrik_TPC',
        'Volumetrik_KK',
        'Capar_TPC',
        'Capar_KK',
        'titik_suhu',
        'titik_rh',
        'titik_mikro',
        'titik_partikel',
        'titik_capar',
        'titik_flow',
        'titik_lux',
        'patogen',
        'volume_ruangan'
    ];

    // Fungsi mengambil syarat suhu berdasarkan nama_ahu dan nama_ruangan
    public function getSyaratSuhu($ahu, $nama_ruangan)
    {
        return $this->select('suhu_min, suhu_max')
                    ->where('nama_ahu', $ahu)
                    ->where('nama_ruangan', $nama_ruangan)
                     ->getRowArray();
    }
}
