<?php

namespace App\Models;

use CodeIgniter\Model;

class OosModel extends Model
{
    protected $table = 'oos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_swab', 'nama_mesin_personil_alat', 'lokasi_sampling', 'tanggal_sampling', 'tgl_analisa','keterangan','status','upload_oos'];
}
