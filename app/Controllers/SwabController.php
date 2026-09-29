<?php

namespace App\Controllers;
use App\Models\SwabModel;
use App\Models\SwabAktualModel;

class SwabController extends BaseController
{
    public function dashboard()
    {
        $periode = $this->request->getGet('periode') ?? 'Caturwulan 1';
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $kategori = $this->request->getGet('kategori') ?? 'Mesin (Bagian Luar)';

        $swabModel = new SwabModel();
        $aktualModel = new SwabAktualModel();

        // Debugging
        try {
            $start_date = $this->getPeriodStartDate($periode, $tahun);
            $end_date = $this->getPeriodEndDate($periode, $tahun);
            $total_target = $swabModel->getTotalTarget($periode, $kategori);
            $total_aktual = $aktualModel->getTotalAktual($periode, $kategori,$tahun);

            // Debug Output
           // var_dump($total_target);
            //var_dump($total_aktual);

            $persentase = $total_target > 0 ? round(($total_aktual / $total_target) * 100, 2) : 0;


            $trendMesinDalam = $aktualModel->getTrendByCategory('Mesin (Bagian Dalam)', $start_date, $end_date);
            $trendMesinLuar = $aktualModel->getTrendByCategory('Mesin (Bagian Luar)', $start_date, $end_date);
            $trendAlatDalam = $aktualModel->getTrendByCategory('Alat Bagian Dalam', $start_date, $end_date);
            $trendAlatLuar = $aktualModel->getTrendByCategory('Alat Bagian Luar', $start_date, $end_date);
            $trendPersonil = $aktualModel->getTrendByCategory('Personil', $start_date, $end_date);

            return view('AtRest/index_swab', [
                'periode' => $periode,
                'tahun' => $tahun,
                'kategori' => $kategori,
                'total_target' => $total_target,
                'total_aktual' => $total_aktual,
                'persentase' => $persentase,
                'trendMesinDalam' => $trendMesinDalam,
                'trendMesinLuar' => $trendMesinLuar,
                'trendAlatDalam' => $trendAlatDalam,
                'trendAlatLuar' => $trendAlatLuar,
                'trendPersonil' => $trendPersonil
            ]);
        } catch (\Exception $e) {
            // Catch error if any and output
            echo 'Error: ' . $e->getMessage();
        }
    }
    private function getPeriodStartDate($periode, $tahun)
    {
        switch ($periode) {
        case 'Caturwulan 1':
            return "$tahun-01-01";
        case 'Caturwulan 2':
            return "$tahun-05-01";
        case 'Caturwulan 3':
            return "$tahun-09-01";
        case 'Semester 1':
            return "$tahun-01-01";
        case 'Semester 2':
            return "$tahun-07-01";
        default:
            return "$tahun-01-01";
    }
    }

    // Fungsi untuk menentukan tanggal akhir berdasarkan periode
    private function getPeriodEndDate($periode, $tahun)
    {
        switch ($periode) {
        case 'Caturwulan 1':
            return "$tahun-04-30";
        case 'Caturwulan 2':
            return "$tahun-08-31";
        case 'Caturwulan 3':
            return "$tahun-12-31";
        case 'Semester 1':
            return "$tahun-06-30";
        case 'Semester 2':
            return "$tahun-12-31";
        default:
            return "$tahun-12-31";
    }
    }
    
}
