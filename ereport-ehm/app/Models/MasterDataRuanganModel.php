<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterDataRuanganModel extends Model
{
    protected $table = 'master_data';
    protected $primaryKey = 'id';
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
        'Partikel_05AR',
        'Partikel_50AR',
        'Partikel_05IO',
        'Partikel_50IO',
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
}