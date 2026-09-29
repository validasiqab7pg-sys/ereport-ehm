<?php

namespace App\Models;

use App\Models\BaseModel;

class MasterDataAirModel extends BaseModel
{
    protected $table      = 'master_data_air';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        // Identitas
        'lokasi',
        'site',
        'jenis_sampling',
        

        'no_outlet_sampling',
        'nama_outlet_sampling',
        'jadwal_minggu_ke',
        // Syarat Fisika & Kimia
        'syarat_warna',
        'syarat_bau',
        'syarat_ph',
        'syarat_suhu',
        'syarat_conductivity',
        'syarat_kesadahan',
        'syarat_zat_padat_total',
        'syarat_toc',
        // Syarat Mikrobiologi
        'syarat_tamc',
        'syarat_tymc',
        'syarat_coliform',
        'syarat_e_coli',
        'syarat_salmonella_sp',
        'syarat_staphylococcus_aureus',
        'syarat_pseudomonas_aeruginosa',
        'syarat_shigella_sp',
        'syarat_enterobacteriaceae',
        'syarat_clostridia',
        'syarat_sporogens',
    ];
}