<?php

use App\Models\AuditTrailModel;

if (!function_exists('log_audit_trail')) {
    function log_audit_trail($username, $action, $table, $recordId, $oldValue, $newValue)
    {
        $audit = new AuditTrailModel();
        $audit->insert([
            'timestamp'   => date('Y-m-d H:i:s'),
            'username'    => $username,
            'action'      => $action,
            'table_name'  => $table,
            'record_id'   => $recordId,
            'old_value'   => $oldValue,
            'new_value'   => $newValue,
            'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? 'CLI'
        ]);
    }
}
