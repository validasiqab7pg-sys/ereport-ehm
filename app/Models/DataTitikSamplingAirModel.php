<?php

namespace App\Models;

use CodeIgniter\Model;

class DataTitikSamplingAirModel extends Model
{
    protected $table            = 'data_titik_sampling_air';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'id_sampling',
        'id_master_air',
        'no_outlet_sampling',
        'nama_outlet_sampling',
        'lokasi',
        'site',
        'jenis_sampling',
    ];

    /**
     * Ambil semua titik sampling berdasarkan id_sampling
     */
    public function getByIdSampling(int $id_sampling): array
    {
        return $this->where('id_sampling', $id_sampling)->findAll();
    }

    /**
     * Hitung jumlah titik per id_sampling
     * Return: array ['id_sampling' => jumlah, ...]
     */
    public function getJumlahPerSampling(): array
    {
        $rows = $this->db->table($this->table)
            ->select('id_sampling, COUNT(*) as jumlah')
            ->groupBy('id_sampling')
            ->get()->getResultArray();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['id_sampling']] = (int) $row['jumlah'];
        }
        return $result;
    }

    /**
     * Cek apakah snapshot sudah pernah dibuat untuk id_sampling ini
     */
    public function sudahSnapshot(int $id_sampling): bool
    {
        return $this->where('id_sampling', $id_sampling)->countAllResults() > 0;
    }
}