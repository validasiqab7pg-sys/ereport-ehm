<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="main-content">
    <?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="header-body">

                <!-- Breadcrumb -->
                <div class="row align-items-center py-2">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>DataAir"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>DataAir">Data Sampling Air</a></li>
                                <li class="breadcrumb-item"><a href="#" style="font-weight:bold; color:black;">Detail</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="mt-0 header-title">Detail Data Sampling Air</h4>

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
                                        <?php $s = $row['status']; ?>
                                        <?php if ($s == null || $s == 'On Progress'): ?>
                                            <span class="badge" style="background-color:#6c757d; color:#fff; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:bold;">
                                                <i class="fas fa-spinner fa-spin" style="margin-right:4px;"></i> On Progress
                                            </span>
                                        <?php elseif ($s == 'Selesai di QA'): ?>
                                            <span class="badge" style="background-color:#17a2b8; color:#fff; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:bold;">
                                                <i class="fas fa-check" style="margin-right:4px;"></i> Selesai di QA
                                            </span>
                                        <?php elseif ($s == 'Selesai di QC'): ?>
                                            <span class="badge" style="background-color:#fd7e14; color:#fff; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:bold;">
                                                <i class="fas fa-check" style="margin-right:4px;"></i> Selesai di QC
                                            </span>
                                        <?php elseif ($s == 'Selesai di Spv QA'): ?>
                                            <span class="badge" style="background-color:#007bff; color:#fff; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:bold;">
                                                <i class="fas fa-check-circle" style="margin-right:4px;"></i> Selesai di Spv QA
                                            </span>
                                        <?php elseif ($s == 'Selesai di Spv QC'): ?>
                                            <span class="badge" style="background-color:#28a745; color:#fff; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:bold;">
                                                <i class="fas fa-check-circle" style="margin-right:4px;"></i> Selesai di Spv QC
                                            </span>
                                        <?php endif; ?>
                                    </dd>
                                </dl>

                                <?php
                                $jabatan       = $session->get('jabatan');
                                $approved1     = $row['approve_1'];
                                $approvedKimia = $row['approve_qc_kimia'];
                                $approvedMikro = $row['approve_qc_mikro'];
                                $approvedSpvQC = $row['approve_spv_qc'];
                                $approvedSpvQA = $row['approve_spv_qa'];
                                $bothQCDone    = $approvedKimia && $approvedMikro;
                                ?>

                                <!-- Tombol PDF + Approve -->
                                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap" style="gap:8px;">

                                    <!-- Tombol Download PDF -->
                                    <a href="<?= base_url('DataAir/cetakPdf/' . $row['id']) ?>"
                                       target="_blank"
                                       class="btn btn-danger btn-sm">
                                        <i class="fa fa-file-pdf-o mr-1"></i> Download Report PDF
                                    </a>

                                    <!-- Tombol Approve per jabatan — pakai data-url + SweetAlert -->
                                    <div>
                                        <?php if ($jabatan == 'QA Analis'): ?>
                                            <?php if (!$approved1): ?>
                                                <a href="<?= base_url() ?>DataAir/acc1/<?= $row['id'] ?>"
                                                   class="btn btn-primary btn-sm swal-confirm"
                                                   data-title="Setujui Data Sampling?"
                                                   data-text="Titik sampling yang tersisa akan dikunci dan dikirim ke QC."
                                                   data-confirm="Ya, Approve">
                                                    <span class="ti-check"></span> Approve (QA Analis)
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <span class="ti-check"></span> Sudah Approve
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($jabatan == 'QC Analis' && $approved1): ?>
                                            <?php if (!$approvedKimia): ?>
                                                <a href="<?= base_url() ?>DataAir/acc2/<?= $row['id'] ?>"
                                                   class="btn btn-primary btn-sm swal-confirm ml-1"
                                                   data-title="Approve Fisik &amp; Kimia?"
                                                   data-text="Pastikan semua hasil Fisika & Kimia sudah benar."
                                                   data-confirm="Ya, Approve">
                                                    <span class="ti-check"></span> Approve Fisik &amp; Kimia
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm ml-1" disabled>Fisik &amp; Kimia ✓</button>
                                            <?php endif; ?>
                                            <?php if (!$approvedMikro): ?>
                                                <a href="<?= base_url() ?>DataAir/acc3/<?= $row['id'] ?>"
                                                   class="btn btn-primary btn-sm swal-confirm ml-1"
                                                   data-title="Approve Mikrobiologi?"
                                                   data-text="Pastikan semua hasil Mikrobiologi sudah benar."
                                                   data-confirm="Ya, Approve">
                                                    <span class="ti-check"></span> Approve Mikrobiologi
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm ml-1" disabled>Mikrobiologi ✓</button>
                                            <?php endif; ?>
                                        <?php elseif ($jabatan == 'QC Analis' && !$approved1): ?>
                                            <button class="btn btn-secondary btn-sm" disabled>Menunggu Approve QA Analis</button>
                                        <?php endif; ?>

                                        <?php if ($jabatan == 'Spv QC'): ?>
                                            <?php if ($bothQCDone && !$approvedSpvQC): ?>
                                                <a href="<?= base_url() ?>DataAir/acc4/<?= $row['id'] ?>"
                                                   class="btn btn-primary btn-sm swal-confirm ml-1"
                                                   data-title="Approve sebagai Spv QC?"
                                                   data-text="Data akan disetujui oleh Supervisor QC."
                                                   data-confirm="Ya, Approve">
                                                    <span class="ti-check"></span> Approve (Spv QC)
                                                </a>
                                            <?php elseif ($approvedSpvQC): ?>
                                                <button class="btn btn-secondary btn-sm ml-1" disabled>Sudah Approve</button>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm ml-1" disabled>Menunggu QC Analis</button>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($jabatan == 'Spv QA' || $jabatan == 'Manager QA'): ?>
                                            <?php if ($approvedSpvQC && !$approvedSpvQA): ?>
                                                <a href="<?= base_url() ?>DataAir/acc5/<?= $row['id'] ?>"
                                                   class="btn btn-primary btn-sm swal-confirm ml-1"
                                                   data-title="Approve Final sebagai Spv QA?"
                                                   data-text="Ini adalah persetujuan final. Data tidak dapat diubah setelah ini."
                                                   data-confirm="Ya, Approve Final">
                                                    <span class="ti-check"></span> Approve Final (Spv QA)
                                                </a>
                                            <?php elseif ($approvedSpvQA): ?>
                                                <button class="btn btn-secondary btn-sm ml-1" disabled>Sudah Approve</button>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm ml-1" disabled>Menunggu Spv QC</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Tabel Hasil -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">Hasil Pengujian Per Outlet</h5>
                                </div>

                                <?php
                                // ================================================================
                                // PERBAIKAN HAK AKSES:
                                // - QA Analis HANYA melakukan sampling (ambil sampel di titik outlet),
                                //   BUKAN yang menganalisa. Jadi dia hanya boleh MELIHAT hasil
                                //   pengujian (baik sebelum maupun sesudah approval apa pun), dan
                                //   hanya diizinkan menghapus titik sampling yang salah/tidak relevan
                                //   sebelum dia sendiri approve (acc1).
                                // - QC Analis adalah yang menganalisa Fisika/Kimia & Mikrobiologi
                                //   (lihat label "Dianalisa oleh (QC Analis)" di footer PDF), jadi
                                //   dialah yang berhak INPUT hasil pengujian — mulai setelah QA
                                //   Analis approve (acc1, titik sampling sudah terkunci/snapshot),
                                //   dan berhenti begitu dia sudah approve kedua bagian
                                //   (Fisik&Kimia + Mikrobiologi / $bothQCDone).
                                // ================================================================
                                $canEdit   = ($jabatan == 'QC Analis' && $approved1 && !$bothQCDone);
                                $canDelete = ($jabatan == 'QA Analis' && !$approved1);

                                // Field untuk hitung kesimpulan per baris
                                $fieldsFisKim = ['hasil_warna','hasil_bau','hasil_ph','hasil_suhu','hasil_conductivity','hasil_kesadahan','hasil_zat_padat_total','hasil_toc'];
                                $fieldsMikro  = ['hasil_tamc','hasil_tymc','hasil_coliform','hasil_e_coli','hasil_salmonella_sp','hasil_staphylococcus_aureus','hasil_pseudomonas_aeruginosa','hasil_shigella_sp','hasil_enterobacteriaceae','hasil_clostridia_sporogens'];
                                $allFields    = array_merge($fieldsFisKim, $fieldsMikro);
                                ?>

                                <?php if ($canEdit): ?>
                                <form method="POST" action="<?= base_url('DataAir/simpan/' . $row['id']) ?>">
                                <?php endif; ?>

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size:12px;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th rowspan="2" class="align-middle text-center">No</th>
                                                <th rowspan="2" class="align-middle">No Outlet</th>
                                                <th rowspan="2" class="align-middle">Nama Outlet</th>
                                                <th rowspan="2" class="align-middle">Lokasi</th>
                                                <th colspan="8" class="text-center" style="background-color:#17a2b8; color:#fff;">Fisika &amp; Kimia</th>
                                                <th colspan="11" class="text-center" style="background-color:#28a745; color:#fff;">Mikrobiologi</th>
                                                <th rowspan="2" class="align-middle text-center" style="min-width:110px;">Kesimpulan</th>
                                                <?php if ($canDelete): ?>
                                                    <th rowspan="2" class="align-middle text-center">Aksi</th>
                                                <?php endif; ?>
                                                <?php if ($jabatan == 'Spv QA' || $jabatan == 'Manager QA'): ?>
                                                    <th rowspan="2" class="align-middle text-center" style="min-width:140px;">Eskalasi</th>
                                                <?php endif; ?>
                                            </tr>
                                            <tr>
                                                <th>Warna</th><th>Bau</th><th>pH</th><th>Suhu</th>
                                                <th>Conductivity</th><th>Kesadahan</th><th>Zat Padat Total</th><th>TOC</th>
                                                <th>TAMC</th><th>TYMC</th><th>Coliform</th><th>E. coli</th>
                                                <th>Salmonella sp</th><th>Staphylococcus aureus</th>
                                                <th>Pseudomonas aeruginosa</th><th>Shigella sp</th>
                                                <th>Enterobacteriaceae</th><th>Clostridia sporogens</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($masterOutlet as $no => $outlet):
                                                $hasil = $hasilIndex[$outlet['id']] ?? [];

                                                $cell = function($field) use ($hasil, $canEdit, $outlet, $syaratIndex) {
                                                    // DITAMBAHKAN: cek status N/A dari syarat Master Data Air
                                                    $param  = substr($field, 6);
                                                    $syarat = $syaratIndex[$outlet['id']][$param] ?? null;
                                                    if (\App\Libraries\ParameterAirDefinition::isSyaratNA($syarat)) {
                                                        return '<span class="badge badge-light text-muted" style="font-size:11px; border:1px solid #ccc;">N/A</span>';
                                                    }

                                                    $rawVal = $hasil[$field] ?? null;
                                                    $name   = $field . '_' . $outlet['id'];
                                                    if ($canEdit) {
                                                        $val = esc($rawVal ?? '');
                                                        return '<input type="text" name="' . $name . '" class="form-control form-control-sm" style="min-width:70px;" value="' . $val . '">';
                                                    }
                                                    if ($rawVal === null || $rawVal === '') return '-';
                                                    return esc($rawVal);
                                                };

                                                // ===== Hitung Kesimpulan per baris =====
                                                // Ambil dari $kesimpulanIndex jika controller sudah menyediakan
                                                if (isset($kesimpulanIndex[$outlet['id']])) {
                                                    $kesimpulan = $kesimpulanIndex[$outlet['id']];
                                                } else {
                                                    // Fallback: cek apakah semua field terisi
                                                    $semuaTerisi = true;
                                                    foreach ($allFields as $f) {
                                                        $v = $hasil[$f] ?? null;
                                                        if ($v === null || trim((string)$v) === '') {
                                                            $semuaTerisi = false;
                                                            break;
                                                        }
                                                    }
                                                    // Jika semua terisi, default MS
                                                    // (logika TMS lebih detail dikerjakan di controller via $kesimpulanIndex)
                                                    $kesimpulan = $semuaTerisi ? 'MS' : 'BELUM_LENGKAP';
                                                }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= $no + 1 ?></td>
                                                <td><?= esc($outlet['no_outlet_sampling']) ?></td>
                                                <td><?= esc($outlet['nama_outlet_sampling']) ?></td>
                                                <td><?= esc($outlet['lokasi']) ?></td>
                                                <td><?= $cell('hasil_warna') ?></td>
                                                <td><?= $cell('hasil_bau') ?></td>
                                                <td><?= $cell('hasil_ph') ?></td>
                                                <td><?= $cell('hasil_suhu') ?></td>
                                                <td><?= $cell('hasil_conductivity') ?></td>
                                                <td><?= $cell('hasil_kesadahan') ?></td>
                                                <td><?= $cell('hasil_zat_padat_total') ?></td>
                                                <td><?= $cell('hasil_toc') ?></td>
                                                <td><?= $cell('hasil_tamc') ?></td>
                                                <td><?= $cell('hasil_tymc') ?></td>
                                                <td><?= $cell('hasil_coliform') ?></td>
                                                <td><?= $cell('hasil_e_coli') ?></td>
                                                <td><?= $cell('hasil_salmonella_sp') ?></td>
                                                <td><?= $cell('hasil_staphylococcus_aureus') ?></td>
                                                <td><?= $cell('hasil_pseudomonas_aeruginosa') ?></td>
                                                <td><?= $cell('hasil_shigella_sp') ?></td>
                                                <td><?= $cell('hasil_enterobacteriaceae') ?></td>
                                                <td><?= $cell('hasil_clostridia_sporogens') ?></td>
                                                <!-- Kolom Kesimpulan -->
                                                <td class="text-center" style="vertical-align:middle;">
                                                    <?php if ($kesimpulan === 'MS'): ?>
                                                        <span class="badge badge-success" style="font-size:11px; padding:5px 10px; border-radius:20px; white-space:nowrap;">
                                                            Memenuhi Syarat
                                                        </span>
                                                    <?php elseif ($kesimpulan === 'TMS'): ?>
                                                        <span class="badge badge-danger" style="font-size:11px; padding:5px 10px; border-radius:20px; white-space:nowrap;">
                                                            Tidak Memenuhi Syarat
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary" style="font-size:11px; padding:5px 10px; border-radius:20px; white-space:nowrap;">
                                                            Belum Lengkap
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if ($canDelete): ?>
                                                <td class="text-center">
                                                    <a href="<?= base_url() ?>DataAir/hapusOutlet/<?= $row['id'] ?>/<?= $outlet['id'] ?>"
                                                       onclick="return confirm('Hapus titik sampling ini dari daftar?')"
                                                       class="btn btn-sm btn-danger">
                                                        <span class="ti-trash"></span>
                                                    </a>
                                                </td>
                                                <?php endif; ?>
                                                <!-- Eskalasi OOS/Penyimpangan: kolom selalu ada untuk Spv QA/Manager QA
                                                     (supaya jumlah kolom konsisten dengan header), tapi tombolnya
                                                     hanya tampil kalau outlet ini berkesimpulan TMS -->
                                                <?php if ($jabatan == 'Spv QA' || $jabatan == 'Manager QA'): ?>
                                                <td class="text-center" style="white-space: nowrap;">
                                                    <?php if ($kesimpulan === 'TMS'): ?>
                                                        <button type="button" class="btn btn-sm btn-warning eskalasi-air"
                                                                data-jenis="oos"
                                                                data-id-sampling="<?= $row['id'] ?>"
                                                                data-id-outlet="<?= $outlet['id'] ?>">
                                                            OOS
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger eskalasi-air"
                                                                data-jenis="penyimpangan"
                                                                data-id-sampling="<?= $row['id'] ?>"
                                                                data-id-outlet="<?= $outlet['id'] ?>">
                                                            Penyimpangan
                                                        </button>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php if ($canEdit): ?>
                                <div class="text-right mt-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="ti-save"></span> Simpan Hasil
                                    </button>
                                </div>
                                </form>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php echo view('parsial/footer'); ?>

<!-- SweetAlert2 — dipanggil SETELAH footer agar jQuery sudah tersedia -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Tombol "OOS" / "Penyimpangan" per outlet TMS — kirim AJAX ke
    // DataAir/requestOOS atau DataAir/requestPenyimpangan, lalu tampilkan
    // feedback lewat SweetAlert. Tidak reload halaman supaya Spv QA bisa
    // eskalasi beberapa outlet sekaligus tanpa kehilangan posisi scroll.
    document.querySelectorAll('button.eskalasi-air').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var jenis      = btn.getAttribute('data-jenis'); // 'oos' atau 'penyimpangan'
            var idSampling = btn.getAttribute('data-id-sampling');
            var idOutlet   = btn.getAttribute('data-id-outlet');
            var url        = jenis === 'oos'
                ? "<?= base_url('DataAir/requestOOS') ?>"
                : "<?= base_url('DataAir/requestPenyimpangan') ?>";

            btn.disabled = true;

            fetch(url, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: new URLSearchParams({
                    id_sampling: idSampling,
                    id_master_air: idOutlet
                })
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#5664d2'
                    });
                } else {
                    btn.disabled = false;
                    Swal.fire({
                        title: 'Gagal',
                        text: data.message || 'Terjadi kesalahan',
                        icon: 'error',
                        confirmButtonColor: '#5664d2'
                    });
                }
            })
            .catch(function () {
                btn.disabled = false;
                Swal.fire({
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat mengirim request.',
                    icon: 'error',
                    confirmButtonColor: '#5664d2'
                });
            });
        });
    });

    // Intercept semua <a class="swal-confirm"> — cegat click, tampilkan SweetAlert,
    // lalu redirect ke href asli jika dikonfirmasi
    document.querySelectorAll('a.swal-confirm').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();

            var url         = el.getAttribute('href');
            var title       = el.getAttribute('data-title')   || 'Konfirmasi';
            var text        = el.getAttribute('data-text')    || '';
            var confirmText = el.getAttribute('data-confirm') || 'Ya, Lanjutkan';

            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5664d2',
                cancelButtonColor: '#6c757d',
                confirmButtonText: confirmText,
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

    <?php if (session()->getFlashdata('Toast')): ?>
    Swal.fire({
        title: "Success!",
        text: "<?= session()->getFlashdata('Toast') ?>",
        icon: "success",
        confirmButtonColor: "#5664d2"
    });
    <?php endif; ?>
});
</script>