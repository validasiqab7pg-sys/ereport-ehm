<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    public function insert($data = null, bool $returnID = true)
    {
        $id = parent::insert($data, $returnID);
        $this->logAudit('INSERT', $id, '-', json_encode($data));
        return $id;
    }

    public function update($id = null, $data = null): bool
{
    // Deteksi pemanggilan lewat builder-style
    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
    $caller = $trace[1]['function'] ?? null;

    // Jika bukan pemanggilan langsung (misal dari builder), lewati audit
    if ($caller === 'update' && $id === null && $data === null) {
        return parent::update();
    }

    // Jika hanya data tanpa ID, tetap proses
    if ($id === null && $data !== null) {
        return parent::update($id, $data);
    }

    // Jika ID dan data tersedia, lakukan audit log
    $oldData = $this->find($id);
    $result = parent::update($id, $data);
    $this->logAudit('UPDATE', $id, json_encode($oldData), json_encode($data));
    return $result;
}

    public function delete($id = null, bool $purge = false)
{
    // Dipanggil chainable: ->where(...)->delete() — $id null, builder sudah punya WHERE.
    // Jangan panggil find($id) di sini karena akan mereset builder dan
    // menghapus kondisi where yang sudah di-set sebelumnya.
    if ($id === null) {
        $oldRows = (clone $this->builder())->get()->getResultArray();
        $result  = parent::delete($id, $purge);
        $this->logAudit('DELETE', 'multi:' . count($oldRows), json_encode($oldRows), '-');
        return $result;
    }

    // Dipanggil langsung dengan id spesifik: aman untuk audit lengkap dengan oldData
    $oldData = $this->find($id);
    $result = parent::delete($id, $purge);
    $this->logAudit('DELETE', $id, json_encode($oldData), '-');
    return $result;
}

    protected function logAudit($action, $recordId, $oldValue, $newValue)
    {
        $auditModel = new \App\Models\AuditTrailModelSwab();

        $auditModel->save([
            'timestamp'  => date('Y-m-d H:i:s'),
            'username'       => session()->get('username') ?? 'guest',
            'action'     => $action,
            'table_name' => $this->table,
            'record_id'  => $recordId,
            'old_value'  => $oldValue,
            'new_value'  => $newValue,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
        ]);
    }
}
