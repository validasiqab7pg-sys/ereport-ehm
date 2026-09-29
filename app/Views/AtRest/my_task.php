<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="header-body">

                <div class="row align-items-center py-2">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#" style="font-weight:bold; color:black;">My Task</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mt-0 header-title mb-0">
                                        My Task — Outstanding Approval
                                        <span class="badge badge-danger ml-2" style="font-size:12px; vertical-align:middle;">
                                            <?= count($tasks) ?>
                                        </span>
                                    </h4>
                                </div>

                                <?php if (!$jabatan): ?>
                                    <div class="alert alert-warning" style="font-size:13px;">
                                        Jabatan tidak terdeteksi pada akun Anda, sehingga tidak ada task approval yang bisa ditampilkan.
                                    </div>
                                <?php elseif (empty($tasks)): ?>
                                    <div class="alert alert-success" style="font-size:13px;">
                                        <i class="ti-check"></i> Tidak ada task approval yang menunggu Anda saat ini. Semua sudah beres!
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table id="datatableMyTask" class="table table-hover align-middle" style="font-size:13px;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width:50px;">No</th>
                                                    <th>No Dokumen</th>
                                                    <th>Jenis EHM</th>
                                                    <th>Tanggal</th>
                                                    <th>Pending</th>
                                                    <th style="width:120px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($tasks as $no => $task): ?>
                                                    <?php
                                                        $badgeColor = match ($task['jenis_ehm']) {
                                                            'EHM Air'              => '#17a2b8',
                                                            'EHM Ruangan'          => '#28a745',
                                                            'Kualifikasi Ruangan'  => '#6f42c1',
                                                            'EHM Swab'             => '#fd7e14',
                                                            default                => '#6c757d',
                                                        };
                                                        $tanggalDisplay = $task['tanggal']
                                                            ? date('d/m/Y', strtotime($task['tanggal']))
                                                            : '-';
                                                    ?>
                                                    <tr>
                                                        <td><?= $no + 1 ?></td>
                                                        <td><strong><?= esc($task['no_dokumen']) ?></strong></td>
                                                        <td>
                                                            <span class="badge" style="background-color:<?= $badgeColor ?>; color:#fff; padding:5px 10px; border-radius:20px; font-size:11px; font-weight:bold; white-space:nowrap;">
                                                                <?= esc($task['jenis_ehm']) ?>
                                                            </span>
                                                        </td>
                                                        <td><?= esc($tanggalDisplay) ?></td>
                                                        <td>
                                                            <span class="badge badge-warning" style="font-size:11px; padding:5px 10px; border-radius:20px;">
                                                                <i class="ti-time"></i> <?= esc($task['pending']) ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="<?= $task['url_detail'] ?>" class="btn btn-sm btn-primary">
                                                                <span class="ti-eye"></span> Proses
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
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

<script>
$(document).ready(function () {
    if ($.fn.DataTable && $('#datatableMyTask').length) {
        $('#datatableMyTask').DataTable({
            order: [], // biarkan urutan dari server (tanggal terlama dulu) tidak di-override datatable
            pageLength: 25,
        });
    }
});
</script>