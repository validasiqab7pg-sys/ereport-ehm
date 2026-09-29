<?php

namespace App\Models;

use App\Libraries\ParameterAirDefinition;
use App\Models\BaseModel;

class HasilSamplingAirModel extends BaseModel
{
    protected $table      = 'hasil_sampling_air';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_sampling',
        'id_master_air',
        // Fisika & Kimia
        'hasil_warna',
        'hasil_bau',
        'hasil_ph',
        'hasil_suhu',
        'hasil_conductivity',
        'hasil_kesadahan',
        'hasil_zat_padat_total',
        'hasil_toc',
        // Mikrobiologi
        'hasil_tamc',
        'hasil_tymc',
        'hasil_coliform',
        'hasil_e_coli',
        'hasil_salmonella_sp',
        'hasil_staphylococcus_aureus',
        'hasil_pseudomonas_aeruginosa',
        'hasil_shigella_sp',
        'hasil_enterobacteriaceae',
        'hasil_clostridia',
        'hasil_sporogens',
    ];

    public function findAll(int $limit = 0, int $offset = 0)
    {
        $rows = parent::findAll($limit, $offset);
        return array_map(fn(array $row) => ParameterAirDefinition::normalizeHasilRow($row), $rows);
    }
}