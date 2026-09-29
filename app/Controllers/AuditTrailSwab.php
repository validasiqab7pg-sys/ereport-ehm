<?php

namespace App\Controllers;
use App\Models\AuditTrailModelSwab;

class AuditTrailSwab extends BaseController
{
    public function index()
    {
        $auditModel = new AuditTrailModelSwab();

        $start = $this->request->getGet('start_date');
        $end = $this->request->getGet('end_date');

        $query = $auditModel;

        if ($start && $end) {
            $query = $query->where('timestamp >=', $start . ' 00:00:00')
                           ->where('timestamp <=', $end . ' 23:59:59');
        }

        $data['logs'] = $query->orderBy('timestamp', 'DESC')->findAll();

        return view('AtRest/audit_trail_swab', $data);
    }
}
