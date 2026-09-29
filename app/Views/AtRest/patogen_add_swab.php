<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<!-- Begin page -->
<?php $session = session(); ?>
<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
<style>
    /* Custom styles for better UI */
    .swiper-button-next,
    .swiper-button-prev {
        color: #007bff;
        top: 50%;
        transform: translateY(-50%);
    }

    .swiper-pagination-bullet-active {
        background: #007bff;
    }

    .swiper-container {
        width: 100%;
        padding-top: 20px;
        padding-bottom: 40px;
    }

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
</style>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <!-- Header -->
        <div class="header-body">
            <div class="row align-items-center py-2">
                <div class="col-lg-12 col-5">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpojSwab"><i class="fa fa-home "></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>PatogenSwab">Data Personnel/Machine Hygiene</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>PatogenSwab/ViewDetail/<?= $Detail_Ruangan['id_swab'] ?>">Detail Data Personnel/Machine Hygiene</a></li>
                            <li class="breadcrumb-item active" style="font-weight: bold; color: black; font-size: 14px;">Add Data Personnel/Machine Hygiene</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- End Header -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Description</h4>
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Kategori</dt>
                            <dd class="col-sm-8"><?= $Detail_Ruangan['kategori'] ?></dd>
                            <dt class="col-sm-4">Nama Mesin/Personil/Alat</dt>
                            <dd class="col-sm-8"><?= $Detail_Ruangan['nama_mesin_personil_alat'] ?></dd>
                            <dt class="col-sm-4">No Report</dt>
                            <dd class="col-sm-8"><?= $Detail_Ruangan['no_ppoj'] ?></dd>
                            <dt class="col-sm-4">Departemen</dt>
                            <dd class="col-sm-8"><?= $Detail_Ruangan['departemen'] ?></dd>
                            <dt class="col-sm-4">Kelas</dt>
                            <dd class="col-sm-8"><?= $Detail_Ruangan['kelas'] ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title m-0">Add Data Personnel/Machine Hygiene</h4>
                            <?php
                                $has_unfilled_data = false;
                                foreach ($List_Lokasi_Sampling as $row) {
                                    if (is_null($row['keterangan']) || $row['keterangan'] === '') {
                                        $has_unfilled_data = true;
                                        break;
                                    }
                                }
                            ?>
                            <?php if ($has_unfilled_data): ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#swiperModal">
                                <i class="fa fa-plus-circle"></i> Input Semua Data
                            </button>
                            <?php endif; ?>
                        </div>
                        
                        <table id="datatable2" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lokasi Sampling</th>
                                    <th>Tanggal Dibersihkan</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($List_Lokasi_Sampling as $no => $row) : ?>
                                    <tr id="row-<?= $row['id'] ?>">
                                        <td><?= $no + 1 ?></td>
                                        <td><?= $row['lokasi_sampling'] ?></td>
                                        <td><?= $row['tanggal_dibersihkan'] ?></td>
                                        <td id="keterangan-cell-<?= $row['id'] ?>">
                                            <?php
                                            $keterangan = $row['keterangan'];
                                            if (is_null($keterangan) || $keterangan === '') {
                                                echo '<span class="badge badge-secondary">Belum diinput</span>';
                                            } elseif (strtoupper($keterangan) === 'MS') {
                                                echo '<span class="badge badge-success">MS</span>';
                                            } elseif (strtoupper($keterangan) === 'TMS') {
                                                echo '<span class="badge badge-danger">TMS</span>';
                                            } else {
                                                echo '<span class="badge badge-dark">' . htmlspecialchars($keterangan) . '</span>';
                                            }
                                            ?>
                                        </td>
                                        <td id="action-cell-<?= $row['id'] ?>">
                                            <?php if (!is_null($row['keterangan']) && $row['keterangan'] !== '' && $row['editable'] == 0 && $row['approve_edit'] == 0 && ($session->get('username') == $row['analis'] || $session->get('jabatan') == 'Manager QC' || $session->get('jabatan') == 'Spv QC')) : ?>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#EditMas<?= $row['id'] ?>">
                                                    <span class="ti-pencil"></span> Edit
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <?php if (!is_null($row['keterangan']) && $row['keterangan'] !== '' && $row['editable'] == 0 && $row['approve_edit'] == 0 && ($session->get('username') == $row['analis'] || $session->get('jabatan') == 'Manager QC' || $session->get('jabatan') == 'Spv QC')) : ?>
                                        <div class="modal fade" id="EditMas<?= $row['id'] ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <form method="POST" action="<?= base_url() ?>PatogenSwab/Update">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0">Update Data Swab: <?= htmlspecialchars($row['lokasi_sampling']) ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Hidden Fields -->
                                                             <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                            <input type="hidden" class="form-control" name="ppoj" value="<?= $Detail_Ruangan['no_ppoj'] ?>">
                                                            <input type="hidden" class="form-control" name="nama_mesin_personil_alat" value="<?= $Detail_Ruangan['nama_mesin_personil_alat'] ?>">
                                                            <input type="hidden" class="form-control" name="id_ppoj" value="<?= $Detail_Ruangan['id'] ?>">
                                                            <input type="hidden" class="form-control" name="kelas" value="<?= $Detail_Ruangan['kelas'] ?>">
                                                            <input type="hidden" class="form-control" name="id_swab" value="<?= $Detail_Ruangan['id_swab'] ?>">
                                                            <input type="hidden" class="form-control" name="tanggal_sampling" value="<?= $Detail_Ruangan['tanggal_sampling'] ?>">
                                                            <input type="hidden" name="lokasi_sampling" value="<?= $row['lokasi_sampling'] ?>">
                                                            <input type="hidden" name="tanggal_dibersihkan" value="<?= $row['tanggal_dibersihkan'] ?>">
                                                            <input type="hidden" name="approve_edit_by" value="<?= $session->get('username') ?>">
                                                            <input type="hidden" name="tanggal_edit" value="<?= date('Y-m-d H:i:s') ?>">
                                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                           
                                                            
                                                            <!-- Visible fields -->
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3"><label>Nama Analis</label><input type="text" class="form-control" value="<?= $row['analis'] ?>" readonly></div>
                                                                <div class="col-md-6 mb-3"><label>Tanggal Analisa</label><input type="date" class="form-control" name="tgl_analisa" value="<?= $row['tgl_analisa']??'' ?>" required></div>
                                                                <div class="col-md-6 mb-3"><label>Tanggal Perhitungan Koloni</label><input type="date" class="form-control koloni" name="tgl_koloni" value="<?= $row['tgl_koloni'] ??''?>" required></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3"><label>TAMC</label><input type="number" class="form-control tamc" name="tamc" value="<?= $row['TAMC'] ?>" required></div>
                                                                <div class="col-md-6 mb-3"><label>TYMC</label><input type="number" class="form-control tymc" name="tymc" value="<?= $row['TYMC'] ?>" required></div>
                                                            </div>

                                                            <!-- Radio buttons -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-2"><label class="d-block">E. Coli</label><input type="radio" name="ecoli" value="(-)" <?= ($row['e_coli'] == '(-)') ? 'checked' : '' ?>> (-) <input type="radio" name="ecoli" value="(+)" <?= ($row['e_coli'] == '(+)') ? 'checked' : '' ?>> (+) <input type="radio" name="ecoli" value="NA" <?= ($row['e_coli'] == 'NA') ? 'checked' : '' ?>> NA</div>
                                                                    <div class="mb-2"><label class="d-block">Salmonella Sp.</label><input type="radio" name="salmonela" value="(-)" <?= ($row['salmonella_sp'] == '(-)') ? 'checked' : '' ?>> (-) <input type="radio" name="salmonela" value="(+)" <?= ($row['salmonella_sp'] == '(+)') ? 'checked' : '' ?>> (+) <input type="radio" name="salmonela" value="NA" <?= ($row['salmonella_sp'] == 'NA') ? 'checked' : '' ?>> NA</div>
                                                                    <div class="mb-2"><label class="d-block">Staphylococcus Aureus</label><input type="radio" name="staphylococcus" value="(-)" <?= ($row['staphylococcus_aureus'] == '(-)') ? 'checked' : '' ?>> (-) <input type="radio" name="staphylococcus" value="(+)" <?= ($row['staphylococcus_aureus'] == '(+)') ? 'checked' : '' ?>> (+) <input type="radio" name="staphylococcus" value="NA" <?= ($row['staphylococcus_aureus'] == 'NA') ? 'checked' : '' ?>> NA</div>
                                                                    <div class="mb-2"><label class="d-block">Pseudomonas Aeruginosa</label><input type="radio" name="pseudomonas" value="(-)" <?= ($row['pseudomonas_aeruginosa'] == '(-)') ? 'checked' : '' ?>> (-) <input type="radio" name="pseudomonas" value="(+)" <?= ($row['pseudomonas_aeruginosa'] == '(+)') ? 'checked' : '' ?>> (+) <input type="radio" name="pseudomonas" value="NA" <?= ($row['pseudomonas_aeruginosa'] == 'NA') ? 'checked' : '' ?>> NA</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-2"><label class="d-block">Shigella Sp.</label><input type="radio" name="shigella" value="(-)" <?= ($row['shigella_sp'] == '(-)') ? 'checked' : '' ?>> (-) <input type="radio" name="shigella" value="(+)" <?= ($row['shigella_sp'] == '(+)') ? 'checked' : '' ?>> (+) <input type="radio" name="shigella" value="NA" <?= ($row['shigella_sp'] == 'NA') ? 'checked' : '' ?>> NA</div>
                                                                    <div class="mb-2"><label class="d-block">Enterobacteriaceae</label><input type="radio" name="enterobacteria" value="(-)" <?= ($row['enterobacteriaceae'] == '(-)') ? 'checked' : '' ?>> (-) <input type="radio" name="enterobacteria" value="(+)" <?= ($row['enterobacteriaceae'] == '(+)') ? 'checked' : '' ?>> (+) <input type="radio" name="enterobacteria" value="NA" <?= ($row['enterobacteriaceae'] == 'NA') ? 'checked' : '' ?>> NA</div>
                                                                    <div class="mb-2"><label class="d-block">Clostridia sporogens</label><input type="radio" name="clostridia" value="(-)" <?= ($row['clostridia_sporogens'] == '(-)') ? 'checked' : '' ?>> (-) <input type="radio" name="clostridia" value="(+)" <?= ($row['clostridia_sporogens'] == '(+)') ? 'checked' : '' ?>> (+) <input type="radio" name="clostridia" value="NA" <?= ($row['clostridia_sporogens'] == 'NA') ? 'checked' : '' ?>> NA</div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 mt-2"><label>Keterangan</label><input type="text" class="form-control keterangan" name="keterangan" value="<?= $row['keterangan'] ?>" readonly></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                            <input type="submit" class="btn btn-primary" value="Simpan Perubahan">
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
        </div><!--end row-->
    </div><!-- container -->
</div> <!-- Page content Wrapper -->

<!-- Swiper Modal -->
<div class="modal fade" id="swiperModal" tabindex="-1" role="dialog" aria-labelledby="swiperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="swiperModalLabel">Input Data Swab Secara Berurutan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Swiper -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($List_Lokasi_Sampling as $row) : ?>
                            <?php if (is_null($row['keterangan']) || $row['keterangan'] === '') : ?>
                                <div class="swiper-slide">
                                    <div class="slide-status">Data Tersimpan</div>
                                    <form class="swiper-form" method="POST" action="<?= base_url() ?>PatogenSwab/Insert" target="form-target">
                                        <h5>Lokasi: <?= htmlspecialchars($row['lokasi_sampling']) ?></h5>
                                        <p class="text-muted">Tanggal Dibersihkan: <?= htmlspecialchars($row['tanggal_dibersihkan']) ?></p>
                                        <hr>
                                        <!-- Hidden fields -->
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>"><input type="hidden" name="ppoj" value="<?= $Detail_Ruangan['no_ppoj'] ?>"><input type="hidden" name="nama_mesin_personil_alat" value="<?= $Detail_Ruangan['nama_mesin_personil_alat'] ?>"><input type="hidden" name="id_ppoj" value="<?= $Detail_Ruangan['id'] ?>"><input type="hidden" name="kelas" value="<?= $Detail_Ruangan['kelas'] ?>"><input type="hidden" name="id_swab" value="<?= $Detail_Ruangan['id_swab'] ?>"><input type="hidden" name="tanggal_sampling" value="<?= $Detail_Ruangan['tanggal_sampling'] ?>"><input type="hidden" name="lokasi_sampling" value="<?= $row['lokasi_sampling'] ?>"><input type="hidden" name="tanggal_dibersihkan" value="<?= $row['tanggal_dibersihkan'] ?>">
                                        <input type="hidden" class="form-control" name="ppoj" value="<?= $Detail_Ruangan['no_ppoj'] ?>">
                                        <input type="hidden" class="form-control" name="nama_mesin_personil_alat" value="<?= $Detail_Ruangan['nama_mesin_personil_alat'] ?>">
                                        <input type="hidden" class="form-control" name="id_ppoj" value="<?= $Detail_Ruangan['id'] ?>">
                                        <input type="hidden" class="form-control" name="kelas" value="<?= $Detail_Ruangan['kelas'] ?>">
                                        <input type="hidden" class="form-control" name="id_swab" value="<?= $Detail_Ruangan['id_swab'] ?>">
                                        <input type="hidden" class="form-control" name="tanggal_sampling" value="<?= $Detail_Ruangan['tanggal_sampling'] ?>">
                                        <input type="hidden" name="lokasi_sampling" value="<?= $row['lokasi_sampling'] ?>">
                                        <input type="hidden" name="tanggal_dibersihkan" value="<?= $row['tanggal_dibersihkan'] ?>">
                                        <!-- Visible fields -->
                                        <div class="row">
                                            <div class="col-md-6 mb-3"><label>Nama Analis</label><input type="text" class="form-control" name="analis" value="<?= $session->get('username') ?>" readonly></div>
                                            <div class="col-md-6 mb-3"><label>Tanggal Analisa</label><input type="date" class="form-control" name="tgl_analisa" required></div>
                                            <div class="col-md-6 mb-3"><label>Tanggal Perhitungan Koloni</label><input type="date" class="form-control" name="tgl_koloni" required></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3"><label>TAMC</label><input type="number" class="form-control tamc" name="tamc" placeholder="0" required></div>
                                            <div class="col-md-6 mb-3"><label>TYMC</label><input type="number" class="form-control tymc" name="tymc" placeholder="0" required></div>
                                        </div>

                                        <!-- Radio buttons -->
                                        <div class="row">
                                            <div class="col-md-6"><div class="mb-2"><label class="d-block">E. Coli</label><input type="radio" name="ecoli" value="(-)"> (-) <input type="radio" name="ecoli" value="(+)"> (+) <input type="radio" name="ecoli" value="NA" checked> NA</div><div class="mb-2"><label class="d-block">Salmonella Sp.</label><input type="radio" name="salmonela" value="(-)"> (-) <input type="radio" name="salmonela" value="(+)"> (+) <input type="radio" name="salmonela" value="NA" checked> NA</div><div class="mb-2"><label class="d-block">Staphylococcus Aureus</label><input type="radio" name="staphylococcus" value="(-)"> (-) <input type="radio" name="staphylococcus" value="(+)"> (+) <input type="radio"name="staphylococcus" value="NA" checked> NA</div><div class="mb-2"><label class="d-block">Pseudomonas Aeruginosa</label><input type="radio" name="pseudomonas" value="(-)"> (-) <input type="radio" name="pseudomonas" value="(+)"> (+) <input type="radio" name="pseudomonas" value="NA" checked> NA</div></div>
                                            <div class="col-md-6"><div class="mb-2"><label class="d-block">Shigella Sp.</label><input type="radio" name="shigella" value="(-)"> (-) <input type="radio" name="shigella" value="(+)"> (+) <input type="radio" name="shigella" value="NA" checked> NA</div><div class="mb-2"><label class="d-block">Enterobacteriaceae</label><input type="radio" name="enterobacteria" value="(-)"> (-) <input type="radio" name="enterobacteria" value="(+)"> (+) <input type="radio" name="enterobacteria" value="NA" checked> NA</div><div class="mb-2"><label class="d-block">Clostridia sporogens</label><input type="radio" name="clostridia" value="(-)"> (-) <input type="radio" name="clostridia" value="(+)"> (+) <input type="radio" name="clostridia" value="NA" checked> NA</div></div>
                                        </div>
                                        <div class="mb-3 mt-2"><label>Keterangan</label><input type="text" class="form-control keterangan" name="keterangan" readonly></div>
                                        <div class="mt-4"><button type="submit" class="btn btn-primary btn-block">Simpan Data</button></div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                    <!-- Add Navigation -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
</div>

</div> <!-- content -->

<!-- Hidden iframe for form submission -->
<iframe name="form-target" id="form-target" style="display:none;"></iframe>

<?php echo view('parsial/footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        var mySwiper = null;
        var currentForm = null; // Variable to hold the form being submitted

        function initializeSwiper() {
            if (mySwiper) {
                mySwiper.destroy(true, true);
            }
            mySwiper = new Swiper('.swiper-container', {
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                pagination: { el: '.swiper-pagination', clickable: true },
                autoHeight: true, // Adjust height automatically
                on: {
                    init: function() {
                        $('.swiper-slide').each(function() {
                            cekKeterangan($(this));
                        });
                    },
                }
            });
        }

        $('#swiperModal').on('shown.bs.modal', function() {
            initializeSwiper();
        });

        $('#swiperModal').on('hidden.bs.modal', function() {
            location.reload(); // Reload page when modal is closed to ensure data is fresh
        });

        function cekKeterangan(container) { // Can be a slide or a modal
            let adaPositif = false;
            container.find('input[type="radio"][value="(+)"]:checked').each(function() {
                adaPositif = true;
            });

            let tamc = parseInt(container.find('.tamc').val()) || 0;
            let tymc = parseInt(container.find('.tymc').val()) || 0;
            let keteranganInput = container.find('.keterangan');
            
            let keterangan = (adaPositif || tamc > 80 || tymc > 80) ? 'TMS' : 'MS';
            keteranganInput.val(keterangan);
        }

        // Universal listener for swiper slides and edit modals
        $(document).on('change input', '.swiper-slide input, .modal[id^="EditMas"] input', function() {
            var container = $(this).closest('.swiper-slide, .modal-content');
            cekKeterangan(container);
        });
        
        // Initial check for edit modals when they are shown
        $('.modal[id^="EditMas"]').on('shown.bs.modal', function () {
            cekKeterangan($(this));
        });

        // Handle form submission via hidden iframe
        $('#form-target').on('load', function() {
            if (!currentForm) return; // Exit if no form was targeted

            var form = currentForm;
            var slide = form.closest('.swiper-slide');
            
            // --- UI Update for submitted form ---
            slide.find('.slide-status').slideDown();
            form.find('input, button, radio').prop('disabled', true);
            form.find('button[type="submit"]').removeClass('btn-primary').addClass('btn-success').text('Tersimpan');
            var rowId = form.find('input[name="id"]').val();
            var keteranganValue = form.find('input[name="keterangan"]').val();
            var newKeteranganHtml = (keteranganValue.toUpperCase() === 'MS') 
                ? '<span class="badge badge-success">MS</span>' 
                : '<span class="badge badge-danger">TMS</span>';
            $('#keterangan-cell-' + rowId).html(newKeteranganHtml);
            // --- End UI Update ---

            currentForm = null; // Reset for next submission

            // Check if any forms are left to be submitted
            var remainingForms = $('.swiper-form button[type=submit]:not(:disabled)');

            if (remainingForms.length > 0) {
                // If there are more forms, show a quick success toast and move to the next slide
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Data Disimpan!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (mySwiper && !mySwiper.isEnd) {
                        mySwiper.slideNext();
                    }
                });
            } else {
                // If all forms are submitted, show a final confirmation and close the modal
                Swal.fire({
                    title: 'Selesai!',
                    text: 'Semua data telah berhasil disimpan.',
                    icon: 'success',
                    confirmButtonColor: '#5664d2'
                }).then(() => {
                    $('#swiperModal').modal('hide');
                });
            }
        });

        $(document).on('submit', '.swiper-form', function() {
            var form = $(this);
            currentForm = form; // Track which form is being submitted
            cekKeterangan(form.closest('.swiper-slide')); // Final check before submission
            
            form.find('button[type="submit"]')
                .prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
            
            // The form will now submit to the hidden iframe due to the 'target' attribute
        });

        // Toast message from session
        <?php if ($session->getFlashdata('Toast')) : ?>
            Swal.fire({
                title: "Success !",
                text: "<?= $session->getFlashdata('Toast') ?>",
                icon: "success",
                confirmButtonColor: "#5664d2",
            });
        <?php endif; ?>
    });
</script>