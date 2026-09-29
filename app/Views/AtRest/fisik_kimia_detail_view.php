<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
<style>
    .swiper-button-next, .swiper-button-prev { color: #007bff; top: 50%; transform: translateY(-50%); }
    .swiper-pagination-bullet-active { background: #007bff; }
    .swiper-container { width: 100%; padding-top: 20px; padding-bottom: 40px; }
    .swiper-slide {
        background-position: center;
        background-size: cover;
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
        background-color: #f9f9f9;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    .slide-status {
        display: none;
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        font-weight: bold;
        text-align: center;
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid transparent;
        border-radius: .25rem;
    }
    /* DITAMBAHKAN: badge N/A dipakai menggantikan input field */
    .badge-na {
        display: inline-block;
        font-size: 11px;
        color: #6c757d;
        border: 1px dashed #adb5bd;
        border-radius: 4px;
        padding: 5px 8px;
        background: #f8f9fa;
        width: 100%;
        text-align: center;
    }
</style>

<?php
// ================================================================
// DITAMBAHKAN: helper untuk cek apakah syarat parameter tertentu
// di-set N/A untuk outlet tertentu (dari $syaratIndex yang dikirim
// controller). $field bentuknya "hasil_xxx", param-nya "xxx".
// ================================================================
function isFieldNA(array $syaratIndex, $idMaster, string $field): bool
{
    $param  = substr($field, 6); // buang prefix "hasil_"
    $syarat = $syaratIndex[$idMaster][$param] ?? null;
    return \App\Libraries\ParameterAirDefinition::isSyaratNA($syarat);
}
?>

<div class="main-content">
    <?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="header-body">

                <div class="row align-items-center py-2">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>FisikKimiaAir"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>FisikKimiaAir">Data Pemeriksaan Fisika &amp; Kimia</a></li>
                                <li class="breadcrumb-item"><a href="#" style="font-weight:bold; color:black;">Detail</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <?php
                $jabatan       = $session->get('jabatan');
                $approved1     = $row['approve_1'];
                $approvedKimia = $row['approve_qc_kimia'];
                $approvedSpvQC = $row['approve_spv_qc'];
                $approvedSpvQA = $row['approve_spv_qa'];

                $requiredFields = [
                    'hasil_warna', 'hasil_bau', 'hasil_ph', 'hasil_suhu',
                    'hasil_conductivity', 'hasil_kesadahan',
                    'hasil_zat_padat_total', 'hasil_toc',
                ];

                // DIUBAH: field N/A dilewati dari perhitungan kelengkapan
                $allRowsComplete = count($masterOutlet) > 0;
                foreach ($masterOutlet as $outlet) {
                    $idMaster = $outlet['id_master_air'];
                    $hasil    = $hasilIndex[$idMaster] ?? [];
                    foreach ($requiredFields as $f) {
                        if (isFieldNA($syaratIndex, $idMaster, $f)) continue; // DITAMBAHKAN
                        $val = $hasil[$f] ?? null;
                        if ($val === null || trim((string)$val) === '') {
                            $allRowsComplete = false;
                            break 2;
                        }
                    }
                }

                $canEdit = ($jabatan == 'QC Analis' && $approved1 && !$approvedKimia);

                // DIUBAH: outlet yang SEMUA parameternya N/A dianggap sudah "terisi"
                // (tidak perlu diinput apa-apa), jadi tidak masuk hitungan "belum diinput"
                $adaBelumDiinput = false;
                foreach ($masterOutlet as $outlet) {
                    $idMaster = $outlet['id_master_air'];
                    $h = $hasilIndex[$idMaster] ?? [];
                    $filled     = false;
                    $adaFieldWajib = false;
                    foreach ($requiredFields as $f) {
                        if (isFieldNA($syaratIndex, $idMaster, $f)) continue;
                        $adaFieldWajib = true;
                        if (!empty($h[$f])) { $filled = true; break; }
                    }
                    if ($adaFieldWajib && !$filled) { $adaBelumDiinput = true; break; }
                }

                $opsiWarna = \App\Libraries\ParameterAirDefinition::opsiTeksDefault('warna');
                $opsiBau   = \App\Libraries\ParameterAirDefinition::opsiTeksDefault('bau');
                ?>

                <!-- Card Info + Tombol Approve -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Detail Pemeriksaan Fisika &amp; Kimia</h4>

                                <dl class="row mb-0" style="font-size:13px;">
                                    <dt class="col-sm-4">Tanggal Sampling</dt>
                                    <dd class="col-sm-8">: <?= esc($row['tanggal_sampling']) ?></dd>
                                    <dt class="col-sm-4">Site</dt>
                                    <dd class="col-sm-8">: <?= esc($row['site']) ?></dd>
                                    <dt class="col-sm-4">Week</dt>
                                    <dd class="col-sm-8">: <?= esc($row['week']) ?></dd>
                                    <dt class="col-sm-4">Jenis Sampling</dt>
                                    <dd class="col-sm-8">: <?= esc($row['jenis_sampling']) ?></dd>
                                    <dt class="col-sm-4">Keterangan</dt>
                                    <dd class="col-sm-8">: <?= esc($row['keterangan']) ?></dd>
                                    <?php if ($row['note']): ?>
                                    <dt class="col-sm-4">Note</dt>
                                    <dd class="col-sm-8">: <?= esc($row['note']) ?></dd>
                                    <?php endif; ?>
                                    <dt class="col-sm-4">Status</dt>
                                    <dd class="col-sm-8">:
                                        <?php
                                        $st = $row['status'];
                                        $isProgress = ($st == null || $st == 'On Progress' || $st == 'Selesai di QA');
                                        ?>
                                        <?php if ($isProgress): ?>
                                            <span class="badge" style="background-color:#6c757d; color:#fff; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:bold;">
                                                <i class="fas fa-spinner fa-spin" style="margin-right:4px;"></i> On Progress
                                            </span>
                                        <?php else: ?>
                                            <span class="badge" style="background-color:#28a745; color:#fff; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:bold;">
                                                <i class="fas fa-check-circle" style="margin-right:4px;"></i> Selesai
                                            </span>
                                        <?php endif; ?>
                                    </dd>
                                </dl>

                                <?php if ($jabatan == 'QC Analis' && $approved1): ?>
                                    <?php if (!$approvedKimia): ?>
                                        <?php if ($allRowsComplete): ?>
                                            <button type="button"
                                                class="btn btn-primary mt-3" style="float:right;"
                                                id="btn-approve-kimia"
                                                data-url="<?= base_url() ?>FisikKimiaAir/acc2/<?= $row['id'] ?>">
                                                <span class="ti-check"></span> Approve Fisika &amp; Kimia
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-secondary mt-3" style="float:right;" disabled
                                                title="Lengkapi hasil pemeriksaan semua titik sampling terlebih dahulu">
                                                <span class="ti-lock"></span> Lengkapi Hasil Dahulu
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Fisika & Kimia ✓" disabled>
                                    <?php endif; ?>
                                <?php elseif ($jabatan == 'QC Analis' && !$approved1): ?>
                                    <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Menunggu Approve QA Analis" disabled>
                                <?php endif; ?>

                                <?php if ($jabatan == 'Spv QC'): ?>
                                    <?php if ($approvedKimia && !$approvedSpvQC): ?>
                                        <button type="button"
                                            class="btn btn-primary mt-3" style="float:right;"
                                            id="btn-approve-spvqc"
                                            data-url="<?= base_url() ?>FisikKimiaAir/acc4/<?= $row['id'] ?>">
                                            <span class="ti-check"></span> Approve By QC Spv
                                        </button>
                                    <?php elseif ($approvedSpvQC): ?>
                                        <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Sudah Approve" disabled>
                                    <?php else: ?>
                                        <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Menunggu QC Analis" disabled>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($jabatan == 'Spv QA' || $jabatan == 'Manager QA'): ?>
                                    <?php if ($approvedSpvQC && !$approvedSpvQA): ?>
                                        <button type="button"
                                            class="btn btn-primary mt-3" style="float:right;"
                                            id="btn-approve-spvqa"
                                            data-url="<?= base_url() ?>FisikKimiaAir/acc5/<?= $row['id'] ?>">
                                            <span class="ti-check"></span> Approve By QA Spv
                                        </button>
                                    <?php elseif ($approvedSpvQA): ?>
                                        <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Sudah Approve" disabled>
                                    <?php else: ?>
                                        <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Menunggu Spv QC" disabled>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <a href="<?= base_url() ?>FisikKimiaAir" class="btn btn-secondary mt-3 btn-sm" style="float:right; margin-right:8px;">
                                    <span class="ti-arrow-left"></span> Kembali
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Scan Hasil Analisa -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mt-0 header-title mb-0">Scan Hasil Analisa</h4>
                                    <?php if ($canUploadScan): ?>
                                        <div>
                                            <label class="btn btn-sm btn-outline-primary mb-0" for="inputFileScan">
                                                <i class="fa fa-folder-open"></i> Pilih File
                                            </label>
                                            <label class="btn btn-sm btn-outline-primary mb-0" for="inputFotoScan">
                                                <i class="fa fa-camera"></i> Ambil Foto
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($canUploadScan): ?>
                                <form id="formUploadScan" method="POST"
                                    action="<?= base_url('FisikKimiaAir/uploadScan/' . $row['id']) ?>"
                                    enctype="multipart/form-data" style="display:none;">
                                    <?= csrf_field() ?>
                                    <input type="file" name="scan_file[]" id="inputFileScan" accept="image/*,.pdf" multiple>
                                    <input type="file" name="scan_file[]" id="inputFotoScan" accept="image/*" capture="environment">
                                </form>
                                <?php endif; ?>

                                <?php if (empty($scanList)): ?>
                                    <p class="text-muted" style="font-size:12px;">Belum ada file scan yang diupload.</p>
                                <?php else: ?>
                                    <div class="row">
                                        <?php foreach ($scanList as $scan):
                                            $ext     = strtolower(pathinfo($scan['nama_file'], PATHINFO_EXTENSION));
                                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png']);
                                            $fileUrl = base_url('uploads/scan_hasil_air/' . $scan['nama_file']);
                                        ?>
                                        <div class="col-md-2 col-sm-4 col-6 mb-3 text-center">
                                            <a href="<?= $fileUrl ?>" target="_blank" class="d-block mb-1">
                                                <?php if ($isImage): ?>
                                                    <img src="<?= $fileUrl ?>" style="width:100%; height:90px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
                                                <?php else: ?>
                                                    <div style="height:90px; display:flex; align-items:center; justify-content:center; background:#f1f1f1; border-radius:6px; border:1px solid #ddd;">
                                                        <i class="fa fa-file-pdf-o fa-2x text-danger"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </a>
                                            <div style="font-size:10px; word-break:break-all;"><?= esc($scan['nama_asli']) ?></div>
                                            <div style="font-size:9px; color:#888;">
                                                <?= esc($scan['uploaded_by']) ?> · <?= date('d/m/Y H:i', strtotime($scan['uploaded_at'])) ?>
                                            </div>
                                            <?php if ($canUploadScan): ?>
                                                <a href="<?= base_url('FisikKimiaAir/hapusScan/' . $scan['id']) ?>"
                                                class="btn-hapus-scan text-danger" style="font-size:10px;">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Tabel Hasil -->
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-body table-responsive">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title m-0">Hasil Pemeriksaan Fisika &amp; Kimia Per Titik Sampling</h4>
                                    <?php if ($canEdit && $adaBelumDiinput): ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#swiperModal">
                                            <i class="fa fa-plus-circle"></i> Input Semua Data
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <?php if ($canEdit && !$allRowsComplete): ?>
                                    <div class="alert alert-warning" style="font-size:12px;">
                                        <i class="ti-info-alt"></i> Tombol approve akan aktif setelah semua titik sampling memiliki hasil pemeriksaan lengkap.
                                    </div>
                                <?php endif; ?>

                                <table class="table table-hover align-middle" style="font-size:12px;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>No Outlet</th>
                                            <th>Nama Outlet</th>
                                            <th>Lokasi</th>
                                            <th>Warna</th>
                                            <th>Bau</th>
                                            <th>pH</th>
                                            <th>Suhu</th>
                                            <th>Conductivity</th>
                                            <th>Kesadahan</th>
                                            <th>Zat Padat Total</th>
                                            <th>TOC</th>
                                            <th>Kesimpulan</th>
                                            <?php if ($canEdit): ?><th>Aksi</th><?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($masterOutlet as $no => $outlet):
                                            $id_master = $outlet['id_master_air'];
                                            $hasil     = $hasilIndex[$id_master] ?? [];

                                            $sudahAdaHasil = false;
                                            foreach ($requiredFields as $f) {
                                                if (isFieldNA($syaratIndex, $id_master, $f)) continue;
                                                if (!empty($hasil[$f])) { $sudahAdaHasil = true; break; }
                                            }

                                            // DIUBAH: tampilkan badge N/A untuk field yang syaratnya N/A
                                            $show = function($field) use ($hasil, $syaratIndex, $id_master) {
                                                if (isFieldNA($syaratIndex, $id_master, $field)) {
                                                    return '<span class="badge-na">N/A</span>';
                                                }
                                                $val = $hasil[$field] ?? null;
                                                if ($val === null || $val === '') return '-';
                                                return esc($val);
                                            };

                                            $kesimpulan = $kesimpulanIndex[$id_master] ?? 'BELUM_LENGKAP';
                                        ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>
                                            <td><?= esc($outlet['no_outlet_sampling']) ?></td>
                                            <td><?= esc($outlet['nama_outlet_sampling']) ?></td>
                                            <td><?= esc($outlet['lokasi']) ?></td>
                                            <td><?= $show('hasil_warna') ?></td>
                                            <td><?= $show('hasil_bau') ?></td>
                                            <td><?= $show('hasil_ph') ?></td>
                                            <td><?= $show('hasil_suhu') ?></td>
                                            <td><?= $show('hasil_conductivity') ?></td>
                                            <td><?= $show('hasil_kesadahan') ?></td>
                                            <td><?= $show('hasil_zat_padat_total') ?></td>
                                            <td><?= $show('hasil_toc') ?></td>
                                            <td id="kesimpulan-cell-<?= $id_master ?>" class="text-center" style="vertical-align:middle;">
                                                <?php if ($kesimpulan === 'MS'): ?>
                                                    <span class="badge badge-success" style="font-size:11px; padding:5px 10px; border-radius:20px; white-space:nowrap;">Memenuhi Syarat</span>
                                                <?php elseif ($kesimpulan === 'TMS'): ?>
                                                    <span class="badge badge-danger" style="font-size:11px; padding:5px 10px; border-radius:20px; white-space:nowrap;">Tidak Memenuhi Syarat</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary" style="font-size:11px; padding:5px 10px; border-radius:20px; white-space:nowrap;">Belum Lengkap</span>
                                                <?php endif; ?>
                                            </td>
                                            <?php if ($canEdit): ?>
                                            <td id="action-cell-<?= $id_master ?>" class="text-center" style="vertical-align:middle;">
                                                <button type="button"
                                                    class="btn btn-sm btn-primary"
                                                    style="font-size:11px; padding:4px 10px;"
                                                    data-toggle="modal" data-target="#inputModal<?= $id_master ?>">
                                                    <span class="<?= $sudahAdaHasil ? 'ti-pencil' : 'ti-plus' ?>"></span>
                                                    <?= $sudahAdaHasil ? 'Edit' : 'Input' ?>
                                                </button>
                                            </td>
                                            <?php endif; ?>
                                        </tr>

                                        <!-- Modal Input/Edit per outlet -->
                                        <?php if ($canEdit): ?>
                                        <div class="modal fade" id="inputModal<?= $id_master ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form method="POST" action="<?= base_url('FisikKimiaAir/simpan/' . $row['id']) ?>">
                                                    <input type="hidden" name="id_master" value="<?= esc($id_master) ?>">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <?= $sudahAdaHasil ? 'Edit' : 'Input' ?> Hasil Pemeriksaan
                                                                <br><small><?= esc($outlet['nama_outlet_sampling']) ?></small>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Warna -->
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">Warna</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_warna')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <select name="hasil_warna_<?= $id_master ?>" class="form-control form-control-sm" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            <?php foreach ($opsiWarna as $opt): ?>
                                                                                <option value="<?= esc($opt) ?>" <?= ($hasil['hasil_warna'] ?? '') === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <!-- Bau -->
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">Bau</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_bau')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <select name="hasil_bau_<?= $id_master ?>" class="form-control form-control-sm" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            <?php foreach ($opsiBau as $opt): ?>
                                                                                <option value="<?= esc($opt) ?>" <?= ($hasil['hasil_bau'] ?? '') === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <!-- pH -->
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">pH</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_ph')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <input type="number" step="any" name="hasil_ph_<?= $id_master ?>" class="form-control form-control-sm"
                                                                            value="<?= esc($hasil['hasil_ph'] ?? '') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <!-- Suhu -->
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">Suhu (°C)</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_suhu')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <input type="number" step="any" name="hasil_suhu_<?= $id_master ?>" class="form-control form-control-sm"
                                                                            value="<?= esc($hasil['hasil_suhu'] ?? '') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <!-- Conductivity -->
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">Conductivity</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_conductivity')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <input type="number" step="any" name="hasil_conductivity_<?= $id_master ?>" class="form-control form-control-sm"
                                                                            value="<?= esc($hasil['hasil_conductivity'] ?? '') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <!-- Kesadahan -->
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">Kesadahan</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_kesadahan')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <input type="number" step="any" name="hasil_kesadahan_<?= $id_master ?>" class="form-control form-control-sm"
                                                                            value="<?= esc($hasil['hasil_kesadahan'] ?? '') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <!-- Zat Padat Total -->
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">Zat Padat Total</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_zat_padat_total')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <input type="number" step="any" name="hasil_zat_padat_total_<?= $id_master ?>" class="form-control form-control-sm"
                                                                            value="<?= esc($hasil['hasil_zat_padat_total'] ?? '') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <!-- TOC -->
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">TOC</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_toc')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <input type="number" step="any" name="hasil_toc_<?= $id_master ?>" class="form-control form-control-sm"
                                                                            value="<?= esc($hasil['hasil_toc'] ?? '') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ===== Swiper Modal (Input Semua Data Sekaligus) ===== -->
<?php if ($canEdit && $adaBelumDiinput): ?>
<div class="modal fade" id="swiperModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Input Data Fisika &amp; Kimia Secara Berurutan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($masterOutlet as $outlet):
                            $id_master = $outlet['id_master_air'];
                            $hasil     = $hasilIndex[$id_master] ?? [];

                            // DIUBAH: cek "sudahIsi" hanya berdasar field yang BUKAN N/A
                            $sudahIsi = true;
                            $adaFieldWajib = false;
                            foreach ($requiredFields as $f) {
                                if (isFieldNA($syaratIndex, $id_master, $f)) continue;
                                $adaFieldWajib = true;
                                if (empty($hasil[$f])) { $sudahIsi = false; }
                            }
                            // Kalau semua field N/A (tidak ada field wajib), anggap sudah "selesai" -> skip dari slider
                            if (!$adaFieldWajib) continue;
                            if ($sudahIsi) continue;
                        ?>
                        <div class="swiper-slide" data-id="<?= $id_master ?>">
                            <div class="slide-status">Data Tersimpan</div>
                            <form class="swiper-form" method="POST"
                                  action="<?= base_url('FisikKimiaAir/simpan/' . $row['id']) ?>"
                                  target="form-target-fisik">
                                <input type="hidden" name="id_master" value="<?= esc($id_master) ?>">

                                <h5 class="mb-0"><?= esc($outlet['nama_outlet_sampling']) ?></h5>
                                <p class="text-muted mb-2" style="font-size:12px;">
                                    <?= esc($outlet['no_outlet_sampling']) ?> — <?= esc($outlet['lokasi']) ?>
                                </p>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">Warna</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_warna')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <select name="hasil_warna_<?= $id_master ?>" class="form-control form-control-sm" required>
                                                <option value="">-- Pilih --</option>
                                                <?php foreach ($opsiWarna as $opt): ?>
                                                    <option value="<?= esc($opt) ?>"><?= esc($opt) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">Bau</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_bau')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <select name="hasil_bau_<?= $id_master ?>" class="form-control form-control-sm" required>
                                                <option value="">-- Pilih --</option>
                                                <?php foreach ($opsiBau as $opt): ?>
                                                    <option value="<?= esc($opt) ?>"><?= esc($opt) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">pH</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_ph')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <input type="number" step="any" name="hasil_ph_<?= $id_master ?>"
                                                class="form-control form-control-sm" placeholder="0" required>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">Suhu (°C)</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_suhu')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <input type="number" step="any" name="hasil_suhu_<?= $id_master ?>"
                                                class="form-control form-control-sm" placeholder="0" required>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">Conductivity</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_conductivity')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <input type="number" step="any" name="hasil_conductivity_<?= $id_master ?>"
                                                class="form-control form-control-sm" placeholder="0" required>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">Kesadahan</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_kesadahan')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <input type="number" step="any" name="hasil_kesadahan_<?= $id_master ?>"
                                                class="form-control form-control-sm" placeholder="0" required>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">Zat Padat Total</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_zat_padat_total')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <input type="number" step="any" name="hasil_zat_padat_total_<?= $id_master ?>"
                                                class="form-control form-control-sm" placeholder="0" required>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">TOC</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_toc')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <input type="number" step="any" name="hasil_toc_<?= $id_master ?>"
                                                class="form-control form-control-sm" placeholder="0" required>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary btn-block">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<iframe name="form-target-fisik" id="form-target-fisik" style="display:none;"></iframe>
<?php endif; ?>

<?php echo view('parsial/footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    var mySwiper    = null;
    var currentForm = null;

    function initSwiper() {
        if (mySwiper) { mySwiper.destroy(true, true); }
        mySwiper = new Swiper('.swiper-container', {
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            pagination: { el: '.swiper-pagination', clickable: true },
            autoHeight: true,
        });
    }

    $('#swiperModal').on('shown.bs.modal', function () { initSwiper(); });
    $('#swiperModal').on('hidden.bs.modal', function () { location.reload(); });

    $(document).on('submit', '.swiper-form', function () {
        var form = $(this);
        currentForm = form;
        form.find('button[type="submit"]')
            .prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
    });

    $('#form-target-fisik').on('load', function () {
        if (!currentForm) return;

        var form  = currentForm;
        var slide = form.closest('.swiper-slide');

        slide.find('.slide-status').slideDown();
        form.find('input, button, select').prop('disabled', true);
        form.find('button[type="submit"]').removeClass('btn-primary').addClass('btn-success').text('✓ Tersimpan');

        currentForm = null;

        var remaining = $('.swiper-form button[type=submit]:not(:disabled)');

        if (remaining.length > 0) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data Disimpan!',
                showConfirmButton: false,
                timer: 1200
            }).then(function () {
                if (mySwiper && !mySwiper.isEnd) { mySwiper.slideNext(); }
            });
        } else {
            Swal.fire({
                title: 'Selesai!',
                text: 'Semua data telah berhasil disimpan.',
                icon: 'success',
                confirmButtonColor: '#5664d2'
            }).then(function () {
                $('#swiperModal').modal('hide');
            });
        }
    });

    <?php if (session()->getFlashdata('Toast')): ?>
    Swal.fire({
        title: "Success!",
        text: "<?= session()->getFlashdata('Toast') ?>",
        icon: "success",
        confirmButtonColor: "#5664d2"
    });
    <?php endif; ?>

    var approveConfig = [
        {
            id: '#btn-approve-kimia',
            title: 'Approve Pemeriksaan Fisika & Kimia?',
            text: 'Pastikan semua hasil pemeriksaan sudah benar sebelum menyetujui.',
            confirmText: 'Ya, Approve'
        },
        {
            id: '#btn-approve-spvqc',
            title: 'Approve sebagai Spv QC?',
            text: 'Data pemeriksaan Fisika & Kimia akan disetujui oleh Spv QC.',
            confirmText: 'Ya, Approve'
        },
        {
            id: '#btn-approve-spvqa',
            title: 'Approve Final sebagai Spv QA?',
            text: 'Ini adalah persetujuan final. Data tidak dapat diubah setelah ini.',
            confirmText: 'Ya, Approve Final'
        }
    ];

    approveConfig.forEach(function (cfg) {
        $(document).on('click', cfg.id, function () {
            var url = $(this).data('url');
            Swal.fire({
                title: cfg.title,
                text: cfg.text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5664d2',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ti-check"></i> ' + cfg.confirmText,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: function () { Swal.showLoading(); }
                    });
                    window.location.href = url;
                }
            });
        });
    });

    $('#inputFileScan, #inputFotoScan').on('change', function () {
    if (this.files.length > 0) {
        $('#formUploadScan').submit();
    }
});

$(document).on('click', '.btn-hapus-scan', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    Swal.fire({
        title: 'Hapus file ini?',
        text: 'File yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then(function (result) {
        if (result.isConfirmed) window.location.href = url;
    });
});
});
</script>