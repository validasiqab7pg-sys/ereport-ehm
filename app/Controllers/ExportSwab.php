<?php

namespace App\Controllers;

use App\Models\PatogenSwabModel;

class ExportSwab extends BaseController
{
    public function excel()
{
    $model = new PatogenSwabModel();

    $periode = $this->request->getGet('periode');
    $tahun = $this->request->getGet('tahun');
    $kategori = $this->request->getGet('kategori');

    $bulanList = $this->convertPeriodeToMonths($periode);

    $data = $model
        ->whereIn('MONTH(tanggal_sampling)', $bulanList)
        ->where('YEAR(tanggal_sampling)', $tahun)
         ->like('no_ppoj', $kategori)
        ->findAll();

    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=\"patogen_swab_filtered.csv\"");

    $output = fopen("php://output", "w");

    // Header CSV
    fputcsv($output, [
        'id', 'id_swab', 'status', 'id_ppoj', 'no_ppoj', 'nama_mesin_personil_alat',
        'tanggal_dibersihkan', 'lokasi_sampling', 'tanggal_sampling',
        'TAMC', 'TYMC', 'e_coli', 'salmonella_sp', 'staphylococcus_aureus',
        'pseudomonas_aeruginosa', 'shigella_sp', 'enterobacteriaceae',
        'clostridia_sporogens', 'analis', 'tgl_analisa', 'keterangan', 'tanggal_dilakukan'
    ]);

    // Isi data
    foreach ($data as $row) {
        fputcsv($output, array_values($row));
    }

    fclose($output);
    exit;
}
private function convertPeriodeToMonths($periode)
{
    $map = [
        'Caturwulan 1' => [1, 2, 3, 4],
        'Caturwulan 2' => [5, 6, 7, 8],
        'Caturwulan 3' => [9, 10, 11, 12],
        'Semester 1'    => [1, 2, 3, 4, 5, 6],
        'Semester 2'    => [7, 8, 9, 10, 11, 12]
    ];

    return $map[$periode] ?? [date('n')]; // fallback: bulan sekarang
}
}
