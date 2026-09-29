<?php

namespace App\Models;
use CodeIgniter\Model;

class AuditTrailModelSwab extends Model
{
    protected $table = 'audit_trail_swab';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'timestamp',
        'username',
        'action',
        'table_name',
        'record_id',
        'old_value',
        'new_value',
        'ip_address'
    ];
    public $useTimestamps       = false;
}
