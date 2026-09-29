<?php

namespace App\Models;

use CodeIgniter\Model;

class FisikKimiaAirModel extends Model
{
    protected $table         = 'data_sampling_air';   // sama dengan DataSamplingAirModel
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $useSoftDeletes = false;

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
        'approve_qc_kimia',
        'approve_qc_kimia_date',
        'approve_qc_mikro',
        'approve_qc_mikro_date',
        'approve_spv_qc',
        'approve_spv_qc_date',
        'approve_spv_qa',
        'approve_spv_ya_date',
    ];

    protected $useTimestamps = false;

    /**
     * Ambil semua data sampling beserta jumlah titik sampling
     * (JOIN ke hasil_sampling_air)
     */
    public function getAllWithJumlahTitik()
    {
        return $this->db->table('data_sampling_air AS d')
            ->select('d.*, COUNT(DISTINCT h.id_master_air) AS jumlah_titik')
            ->join('hasil_sampling_air h', 'h.id_sampling = d.id', 'left')
            ->groupBy('d.id')
            ->orderBy('d.tanggal_sampling', 'DESC')
            ->get()
            ->getResultArray();
    }
}