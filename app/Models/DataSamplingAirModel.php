<?php

namespace App\Models;

use App\Models\BaseModel;

class DataSamplingAirModel extends BaseModel
{
    protected $table      = 'data_sampling_air';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
    'tanggal_sampling',
    'site',
    'week',
    'jenis_sampling',
    'keterangan',
    'note',
    'status',
    'approve_1',
    'approve_1_date',
    'approve_qc_kimia',       // ← QC Fisik & Kimia
    'approve_qc_kimia_date',
    'approve_qc_mikro',       // ← QC Mikrobiologi
    'approve_qc_mikro_date',
    'approve_spv_qc',         // ← Spv QC (setelah keduanya selesai)
    'approve_spv_qc_date',
    'approve_spv_qa',         // ← Spv QA (final)
    'approve_spv_qa_date',
];
}