<?php

namespace App\Models;

use App\Libraries\ParameterAirDefinition;
use CodeIgniter\Model;

class MasterDataAirSyaratModel extends Model
{
    protected $table         = 'master_data_air_syarat';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'id_master_air', 'parameter', 'tipe', 'operator',
        'nilai_min', 'nilai_max', 'nilai_teks', 'satuan',
    ];
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    public function getByMasterId(int $idMaster): array
    {
        return $this->where('id_master_air', $idMaster)->findAll();
    }

    public function getIndexedByMasterId(int $idMaster): array
    {
        $rows    = $this->getByMasterId($idMaster);
        $indexed = [];
        foreach ($rows as $r) {
            $indexed[$r['parameter']] = $r;
        }
        return ParameterAirDefinition::normalizeSyaratIndexed($indexed);
    }

    public function replaceForMaster(int $idMaster, array $listSyarat): void
    {
        $this->where('id_master_air', $idMaster)->delete();

        $batch = [];
        foreach ($listSyarat as $param => $s) {
            $batch[] = [
                'id_master_air' => $idMaster,
                'parameter'     => $param,
                'tipe'          => $s['tipe'],
                'operator'      => $s['operator']   ?? null,
                'nilai_min'     => $s['nilai_min']  ?? null,
                'nilai_max'     => $s['nilai_max']  ?? null,
                'nilai_teks'    => $s['nilai_teks'] ?? null,
                'satuan'        => $s['satuan']     ?? null,
            ];
        }

        if (!empty($batch)) {
            $this->insertBatch($batch);
        }
    }
}