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
    .badge-na {
        display: inline-block;
        font-size: 11px;
        color: #6c757d;
        border: 1px dashed #adb5bd;
        border-radius: 4px;
        padding: 5px 8px;
        background: #f8f9fa;
    }
</style>

<?php
function isFieldNA(array $syaratIndex, $idMaster, string $field): bool
{
    $param  = substr($field, 6);
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
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>MikroAir"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>MikroAir">Data Pemeriksaan Mikrobiologi</a></li>
                                <li class="breadcrumb-item"><a href="#" style="font-weight:bold; color:black;">Detail</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <?php
                $jabatan       = $session->get('jabatan');
                $approved1     = $row['approve_1'];
                $approvedMikro = $row['approve_qc_mikro'];
                $approvedSpvQC = $row['approve_spv_qc'];
                $approvedSpvQA = $row['approve_spv_qa'];

                $requiredFields = [
                    'hasil_tamc', 'hasil_tymc', 'hasil_coliform', 'hasil_e_coli',
                    'hasil_salmonella_sp', 'hasil_staphylococcus_aureus',
                    'hasil_pseudomonas_aeruginosa', 'hasil_shigella_sp',
                    'hasil_enterobacteriaceae', 'hasil_clostridia_sporogens',
                ];

                // DIUBAH: field N/A dilewati dari perhitungan kelengkapan
                $allRowsComplete = count($masterOutlet) > 0;
                foreach ($masterOutlet as $outlet) {
                    $idMaster = $outlet['id_master_air'];
                    $h = $hasilIndex[$idMaster] ?? [];
                    foreach ($requiredFields as $f) {
                        if (isFieldNA($syaratIndex, $idMaster, $f)) continue;
                        $val = $h[$f] ?? null;
                        if ($val === null || trim((string)$val) === '') {
                            $allRowsComplete = false;
                            break 2;
                        }
                    }
                }

                $canEdit = ($jabatan == 'QC Analis' && $approved1 && !$approvedMikro);

                $adaBelumDiinput = false;
                foreach ($masterOutlet as $outlet) {
                    $idMaster = $outlet['id_master_air'];
                    $h = $hasilIndex[$idMaster] ?? [];
                    $filled = false;
                    $adaFieldWajib = false;
                    foreach ($requiredFields as $f) {
                        if (isFieldNA($syaratIndex, $idMaster, $f)) continue;
                        $adaFieldWajib = true;
                        if (!empty($h[$f])) { $filled = true; break; }
                    }
                    if ($adaFieldWajib && !$filled) { $adaBelumDiinput = true; break; }
                }

                $paramTeks = [
                     'hasil_coliform'                => 'Coliform',
                    'hasil_e_coli'                  => 'E. coli',
                    'hasil_salmonella_sp'          => 'Salmonella sp',
                    'hasil_staphylococcus_aureus'  => 'Staphylococcus aureus',
                    'hasil_pseudomonas_aeruginosa' => 'Pseudomonas aeruginosa',
                    'hasil_shigella_sp'            => 'Shigella sp',
                    'hasil_enterobacteriaceae'     => 'Enterobacteriaceae',
                    'hasil_clostridia_sporogens'   => 'Clostridia sporogens',
                ];
                ?>

                <!-- Card Info + Tombol Approve -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Detail Pemeriksaan Mikrobiologi</h4>

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
                                        <?php $st = $row['status']; ?>
                                        <?php if ($st == null || $st == 'On Progress' || $st == 'Selesai di QA'): ?>
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
                                    <?php if (!$approvedMikro): ?>
                                        <?php if ($allRowsComplete): ?>
                                            <button type="button"
                                                class="btn btn-primary mt-3" style="float:right;"
                                                id="btn-approve-mikro"
                                                data-url="<?= base_url() ?>MikroAir/acc3/<?= $row['id'] ?>">
                                                <span class="ti-check"></span> Approve Mikrobiologi
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-secondary mt-3" style="float:right;" disabled>
                                                <span class="ti-lock"></span> Lengkapi Hasil Dahulu
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Mikrobiologi ✓" disabled>
                                    <?php endif; ?>
                                <?php elseif ($jabatan == 'QC Analis' && !$approved1): ?>
                                    <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Menunggu Approve QA Analis" disabled>
                                <?php endif; ?>

                                <?php if ($jabatan == 'Spv QC'): ?>
                                    <?php if ($approvedMikro && !$approvedSpvQC): ?>
                                        <button type="button"
                                            class="btn btn-primary mt-3" style="float:right;"
                                            id="btn-approve-spvqc"
                                            data-url="<?= base_url() ?>MikroAir/acc4/<?= $row['id'] ?>">
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
                                            data-url="<?= base_url() ?>MikroAir/acc5/<?= $row['id'] ?>">
                                            <span class="ti-check"></span> Approve By QA Spv
                                        </button>
                                    <?php elseif ($approvedSpvQA): ?>
                                        <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Sudah Approve" disabled>
                                    <?php else: ?>
                                        <input type="button" class="btn btn-secondary mt-3" style="float:right;" value="Menunggu Spv QC" disabled>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <a href="<?= base_url() ?>MikroAir" class="btn btn-secondary mt-3 btn-sm" style="float:right; margin-right:8px;">
                                    <span class="ti-arrow-left"></span> Kembali
                                </a>

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
                                    <h4 class="card-title m-0">Hasil Pemeriksaan Mikrobiologi Per Titik Sampling</h4>
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

                                <table class="table table-hover align-middle" style="font-size:11px; white-space:nowrap;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>No Outlet</th>
                                            <th>Nama Outlet</th>
                                            <th>Lokasi</th>
                                            <th>TAMC</th>
                                            <th>TYMC</th>
                                            <th>Coliform</th>
                                            <th>E. coli</th>
                                            <th>Salmonella sp</th>
                                            <th>Staphylococcus aureus</th>
                                            <th>Pseudomonas aeruginosa</th>
                                            <th>Shigella sp</th>
                                            <th>Enterobacteriaceae</th>
                                            <th>Clostridia sporogens</th>
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
                                                if (isset($hasil[$f]) && $hasil[$f] !== '') { $sudahAdaHasil = true; break; }
                                            }

                                            $showVal = function($field) use ($hasil, $syaratIndex, $id_master) {
                                                if (isFieldNA($syaratIndex, $id_master, $field)) {
                                                    return '<span class="badge-na">N/A</span>';
                                                }
                                                $val = $hasil[$field] ?? null;
                                                if ($val === null || $val === '') return '-';
                                                return esc($val);
                                            };

                                            $kesimpulan = $kesimpulanIndex[$id_master] ?? 'BELUM_LENGKAP';
                                        ?>
                                        <tr id="row-<?= $id_master ?>">
                                            <td><?= $no + 1 ?></td>
                                            <td><?= esc($outlet['no_outlet_sampling']) ?></td>
                                            <td><?= esc($outlet['nama_outlet_sampling']) ?></td>
                                            <td><?= esc($outlet['lokasi']) ?></td>
                                            <td><?= $showVal('hasil_tamc') ?></td>
                                            <td><?= $showVal('hasil_tymc') ?></td>
                                            <td><?= $showVal('hasil_coliform') ?></td>
                                            <td><?= $showVal('hasil_e_coli') ?></td>
                                            <td><?= $showVal('hasil_salmonella_sp') ?></td>
                                            <td><?= $showVal('hasil_staphylococcus_aureus') ?></td>
                                            <td><?= $showVal('hasil_pseudomonas_aeruginosa') ?></td>
                                            <td><?= $showVal('hasil_shigella_sp') ?></td>
                                            <td><?= $showVal('hasil_enterobacteriaceae') ?></td>
                                            <td><?= $showVal('hasil_clostridia_sporogens') ?></td>
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
                                                    data-toggle="modal" data-target="#editModal<?= $id_master ?>">
                                                    <span class="<?= $sudahAdaHasil ? 'ti-pencil' : 'ti-plus' ?>"></span>
                                                    <?= $sudahAdaHasil ? 'Edit' : 'Input' ?>
                                                </button>
                                            </td>
                                            <?php endif; ?>
                                        </tr>

                                        <!-- Modal Edit per outlet -->
                                        <?php if ($canEdit): ?>
                                        <div class="modal fade" id="editModal<?= $id_master ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form method="POST" action="<?= base_url('MikroAir/simpan/' . $row['id']) ?>">
                                                    <input type="hidden" name="id_master" value="<?= esc($id_master) ?>">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <?= $sudahAdaHasil ? 'Edit' : 'Input' ?> Hasil Mikrobiologi
                                                                <br><small class="text-muted"><?= esc($outlet['nama_outlet_sampling']) ?></small>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">TAMC</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_tamc')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <input type="number" step="any" name="hasil_tamc_<?= $id_master ?>" class="form-control form-control-sm"
                                                                            value="<?= esc($hasil['hasil_tamc'] ?? '') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-md-6 mb-2">
                                                                    <label style="font-size:12px;">TYMC</label>
                                                                    <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_tymc')): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <input type="number" step="any" name="hasil_tymc_<?= $id_master ?>" class="form-control form-control-sm"
                                                                            value="<?= esc($hasil['hasil_tymc'] ?? '') ?>" required>
                                                                    <?php endif; ?>
                                                                </div>
                                                                
                                                            </div>
                                                            <hr class="my-2">
                                                            <p class="mb-2" style="font-size:12px; font-weight:bold;">Parameter Patogen</p>
                                                            <?php foreach ($paramTeks as $field => $label):
                                                                $currentVal = $hasil[$field] ?? '';
                                                                $fn = $field . '_' . $id_master;
                                                                $isNA = isFieldNA($syaratIndex, $id_master, $field);
                                                            ?>
                                                            <div class="form-group row align-items-center mb-1">
                                                                <label class="col-sm-5 col-form-label" style="font-size:12px;"><?= $label ?></label>
                                                                <div class="col-sm-7">
                                                                    <?php if ($isNA): ?>
                                                                        <div class="badge-na">N/A (tidak diperiksa)</div>
                                                                    <?php else: ?>
                                                                        <div class="d-flex" style="gap:12px; font-size:12px;">
                                                                            <label class="mb-0" style="font-weight:normal; cursor:pointer;">
                                                                                <input type="radio" name="<?= $fn ?>" value="Negatif" <?= $currentVal === 'Negatif' ? 'checked' : '' ?> required> (-)
                                                                            </label>
                                                                            <label class="mb-0" style="font-weight:normal; cursor:pointer;">
                                                                                <input type="radio" name="<?= $fn ?>" value="Positif" <?= $currentVal === 'Positif' ? 'checked' : '' ?>> (+)
                                                                            </label>
                                                                            <label class="mb-0" style="font-weight:normal; cursor:pointer;">
                                                                                <input type="radio" name="<?= $fn ?>" value="NA" <?= $currentVal === 'NA' ? 'checked' : '' ?>> NA
                                                                            </label>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
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
                <h5 class="modal-title mt-0">Input Data Mikrobiologi Secara Berurutan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($masterOutlet as $outlet):
                            $id_master  = $outlet['id_master_air'];
                            $hasil      = $hasilIndex[$id_master] ?? [];

                            $sudahIsi = true;
                            $adaFieldWajib = false;
                            foreach ($requiredFields as $f) {
                                if (isFieldNA($syaratIndex, $id_master, $f)) continue;
                                $adaFieldWajib = true;
                                if (empty($hasil[$f])) { $sudahIsi = false; }
                            }
                            if (!$adaFieldWajib) continue;
                            if ($sudahIsi) continue;
                        ?>
                        <div class="swiper-slide" data-id="<?= $id_master ?>">
                            <div class="slide-status">Data Tersimpan</div>
                            <form class="swiper-form" method="POST"
                                  action="<?= base_url('MikroAir/simpan/' . $row['id']) ?>"
                                  target="form-target-mikro">
                                <input type="hidden" name="id_master" value="<?= esc($id_master) ?>">

                                <h5 class="mb-0"><?= esc($outlet['nama_outlet_sampling']) ?></h5>
                                <p class="text-muted mb-2" style="font-size:12px;">
                                    <?= esc($outlet['no_outlet_sampling']) ?> — <?= esc($outlet['lokasi']) ?>
                                </p>
                                <hr>

                                <!-- Numerik -->
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">TAMC</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_tamc')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <input type="number" step="any" name="hasil_tamc_<?= $id_master ?>"
                                                class="form-control form-control-sm" placeholder="0" required>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label style="font-size:12px;">TYMC</label>
                                        <?php if (isFieldNA($syaratIndex, $id_master, 'hasil_tymc')): ?>
                                            <div class="badge-na">N/A</div>
                                        <?php else: ?>
                                            <input type="number" step="any" name="hasil_tymc_<?= $id_master ?>"
                                                class="form-control form-control-sm" placeholder="0" required>
                                        <?php endif; ?>
                                    </div>
                                    
                                </div>

                                <hr class="my-2">
                                <p class="mb-2" style="font-size:12px; font-weight:bold;">Parameter Patogen</p>

                                <div class="row">
                                    <?php
                                    $paramKiri  = array_slice($paramTeks, 0, 4, true);
                                    $paramKanan = array_slice($paramTeks, 4, null, true);
                                    ?>
                                    <div class="col-md-6">
                                        <?php foreach ($paramKiri as $field => $label):
                                            $fn = $field . '_' . $id_master;
                                            $isNA = isFieldNA($syaratIndex, $id_master, $field);
                                        ?>
                                        <div class="mb-2">
                                            <label class="d-block" style="font-size:12px; font-weight:bold;"><?= $label ?></label>
                                            <?php if ($isNA): ?>
                                                <div class="badge-na">N/A</div>
                                            <?php else: ?>
                                                <label class="mb-0 mr-2" style="font-weight:normal; font-size:12px; cursor:pointer;">
                                                    <input type="radio" name="<?= $fn ?>" value="Negatif" required> (-)
                                                </label>
                                                <label class="mb-0 mr-2" style="font-weight:normal; font-size:12px; cursor:pointer;">
                                                    <input type="radio" name="<?= $fn ?>" value="Positif"> (+)
                                                </label>
                                                <label class="mb-0" style="font-weight:normal; font-size:12px; cursor:pointer;">
                                                    <input type="radio" name="<?= $fn ?>" value="NA" checked> NA
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php foreach ($paramKanan as $field => $label):
                                            $fn = $field . '_' . $id_master;
                                            $isNA = isFieldNA($syaratIndex, $id_master, $field);
                                        ?>
                                        <div class="mb-2">
                                            <label class="d-block" style="font-size:12px; font-weight:bold;"><?= $label ?></label>
                                            <?php if ($isNA): ?>
                                                <div class="badge-na">N/A</div>
                                            <?php else: ?>
                                                <label class="mb-0 mr-2" style="font-weight:normal; font-size:12px; cursor:pointer;">
                                                    <input type="radio" name="<?= $fn ?>" value="Negatif" required> (-)
                                                </label>
                                                <label class="mb-0 mr-2" style="font-weight:normal; font-size:12px; cursor:pointer;">
                                                    <input type="radio" name="<?= $fn ?>" value="Positif"> (+)
                                                </label>
                                                <label class="mb-0" style="font-weight:normal; font-size:12px; cursor:pointer;">
                                                    <input type="radio" name="<?= $fn ?>" value="NA" checked> NA
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Simpan Data
                                    </button>
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

<iframe name="form-target-mikro" id="form-target-mikro" style="display:none;"></iframe>
<?php endif; ?>

<?php echo view('parsial/footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    var mySwiper   = null;
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

    $(document).on('submit', '.swiper-form', function (e) {
        var form = $(this);
        currentForm = form;

        form.find('button[type="submit"]')
            .prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');
    });

    $('#form-target-mikro').on('load', function () {
        if (!currentForm) return;

        var form      = currentForm;
        var slide     = form.closest('.swiper-slide');
        var id_master = slide.data('id');

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
            id: '#btn-approve-mikro',
            title: 'Approve Pemeriksaan Mikrobiologi?',
            text: 'Pastikan semua hasil pemeriksaan sudah benar sebelum menyetujui.',
            confirmText: 'Ya, Approve'
        },
        {
            id: '#btn-approve-spvqc',
            title: 'Approve sebagai Spv QC?',
            text: 'Data pemeriksaan Mikrobiologi akan disetujui oleh Spv QC.',
            confirmText: 'Ya, Approve'
        },
        {
            id: '#btn-approve-spvqa',
            title: 'Approve Final sebagai Spv QA?',
            text: 'Ini adalah persetujuan final. Data tidak dapat diubah setelah ini.',
            confirmText: 'Ya, Approve Final'
        }
    ];

    approveConfig.forEach(function(cfg) {
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
});
</script>