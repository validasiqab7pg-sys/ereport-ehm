<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="main-content">
    <?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="header-body">

                <div class="row align-items-center py-2">
                    <div class="col-lg-12 col-5">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>MikroAir"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>MikroAir" style="font-weight:bold; color:black; font-size:14px;">Data Pemeriksaan Mikrobiologi</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title mb-4">Data Pemeriksaan Mikrobiologi</h4>

                                    <?php
                                    $approve = session()->getFlashdata('Toast');
                                    if ($approve): ?>
                                    <script>
                                        window.onload = function() {
                                            Swal.fire({
                                                title: "Success!",
                                                text: "<?= $approve ?>",
                                                icon: "success",
                                                confirmButtonColor: "#5664d2"
                                            });
                                        }
                                    </script>
                                    <?php endif; ?>

                                    <div class="card-body table-responsive">
                                        <table id="datatable2" class="table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Sampling</th>
                                                    <th>Site</th>
                                                    <th>Week</th>
                                                    <th>Jenis Sampling</th>
                                                    <th>Keterangan</th>
                                                    <th>Note</th>
                                                    <th>Jumlah Titik Sampling</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $no => $row): ?>
                                                <tr>
                                                    <td><?= $no + 1 ?></td>
                                                    <td><?= esc($row['tanggal_sampling']) ?></td>
                                                    <td><?= esc($row['site']) ?></td>
                                                    <td><?= esc($row['week']) ?></td>
                                                    <td><?= esc($row['jenis_sampling']) ?></td>
                                                    <td><?= esc($row['keterangan']) ?></td>
                                                    <td><?= esc($row['note']) ?: '-' ?></td>
                                                    <td><?= $row['jumlah_titik'] ?> titik</td>
                                                    <td style="width:130px;">
                                                        <?php if ($row['status'] == null || $row['status'] == 'On Progress' || $row['status'] == 'Selesai di QA'): ?>
                                                            <div class="badge bg-secondary">On Progress</div>
                                                        <?php else: ?>
                                                            <div class="badge bg-success">Selesai</div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" style="float:none;">
                                                            <a href="<?= base_url() ?>MikroAir/detail/<?= $row['id'] ?>"
                                                               class="btn btn-sm btn-primary"
                                                               style="float:none; margin:3px;"
                                                               title="Lihat Detail">
                                                                <span class="ti-eye"></span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
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
    </div>
</div>
<?php echo view('parsial/footer'); ?>