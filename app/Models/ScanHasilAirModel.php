<?php
// app/Models/ScanHasilAirModel.php
namespace App\Models;

use CodeIgniter\Model;

class ScanHasilAirModel extends Model
{
    protected $table            = 'scan_hasil_air';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'id_sampling',
        'nama_asli',
        'nama_file',
        'uploaded_by',
        'uploaded_at',
    ];

    public function getBySampling(int $idSampling): array
    {
        return $this->where('id_sampling', $idSampling)
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }
}