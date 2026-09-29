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
                                
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>DataAir" style="font-weight: bold; color: black; font-size: 14px;">Data Sampling Air</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                        <button type="button" class="btn btn-primary mt-3 btn-animation"
                                            data-animation="slideInUp" style="float:right;"
                                            data-toggle="modal" data-target="#addModal">Add Data</button>
                                    <?php } ?>

                                    <h4 class="card-title mb-4">Data Sampling Air</h4>

                                    <div class="card-body table-responsive">
                                        <div class="">
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
                                                             <td><?= esc($row['note']) ?></td>
                                                            <td style="width: 160px; text-align: center;">
                                                                <?php if ($row['status'] == null || $row['status'] == 'On Progress') { ?>
                                                                    <div class="badge" style="background-color: #6c757d; color: #fff; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                                                        <i class="fas fa-spinner fa-spin" style="margin-right: 4px;"></i> On Progress
                                                                    </div>

                                                                <?php } elseif ($row['status'] == 'Selesai di QA') { ?>
                                                                    <div class="badge" style="background-color: #17a2b8; color: #fff; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                                                        <i class="fas fa-check" style="margin-right: 4px;"></i> Selesai di QA
                                                                    </div>

                                                                <?php } elseif ($row['status'] == 'Selesai di QC') { ?>
                                                                    <div class="badge" style="background-color: #fd7e14; color: #fff; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                                                        <i class="fas fa-check" style="margin-right: 4px;"></i> Selesai di QC
                                                                    </div>

                                                                <?php } elseif ($row['status'] == 'Selesai di Spv QA') { ?>
                                                                    <div class="badge" style="background-color: #007bff; color: #fff; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                                                        <i class="fas fa-check-circle" style="margin-right: 4px;"></i> Selesai di Spv QA
                                                                    </div>

                                                                <?php } elseif ($row['status'] == 'Selesai di Spv QC') { ?>
                                                                    <div class="badge" style="background-color: #28a745; color: #fff; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                                                        <i class="fas fa-check-circle" style="margin-right: 4px;"></i> Selesai di Spv QC
                                                                    </div>
                                                                <?php } ?>
                                                            </td>
                                                                                                                        <td>
                                                                <div class="btn-group btn-group-sm" style="float: none;">
                                                                    <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                                                        <a href="<?= base_url() ?>DataAir/hapus/<?= $row['id'] ?>"
                                                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                                            class="tabledit-delete-button btn btn-sm btn-danger"
                                                                            style="float: none; margin: 5px;">
                                                                            <span class="ti-trash"></span>
                                                                        </a>
                                                                    <?php } ?>
                                                                    <a href="<?= base_url() ?>DataAir/show/<?= $row['id'] ?>"
                                                                        class="tabledit-delete-button btn btn-sm btn-primary"
                                                                        style="float: none; margin: 5px;">
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
</div>

<!-- ===== Add Modal ===== -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="<?= base_url('DataAir/tambah') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Sampling Air</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Tanggal Sampling</label>
                        <input type="date" name="tanggal_sampling" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Site</label>
                        <select name="site" class="form-control" required>
                            <option value="">-- Pilih Site --</option>
                            <option value="Cikarang">Cikarang</option>
                            <option value="Pulogadung">Pulogadung</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Week</label>
                        <select name="week" class="form-control" required>
                            <option value="">-- Pilih Week --</option>
                            <option value="Week 1">Week 1</option>
                            <option value="Week 2">Week 2</option>
                            <option value="Week 3">Week 3</option>
                            <option value="Week 4">Week 4</option>
                            <option value="Week 5">Week 5</option>
                        </select>
                    </div>

                   <div class="form-group">
                    <label>Jenis Sampling</label>
                    <select name="jenis_sampling" class="form-control" required>
                        <option value="">-- Pilih Jenis Sampling --</option>
                        <?php foreach ($jenis_sampling_list as $js): ?>
                            <option value="<?= esc($js['jenis_sampling']) ?>">
                                <?= esc($js['jenis_sampling']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <select name="keterangan" id="keteranganAdd" class="form-control" required
                                onchange="toggleNoteAdd(this)">
                            <option value="">-- Pilih Keterangan --</option>
                            <option value="NA">NA</option>
                            <option value="Verifikasi">Verifikasi</option>
                            <option value="Sampling Ulang">Sampling Ulang</option>
                        </select>
                    </div>

                    <div class="form-group" id="noteAddWrapper" style="display:none;">
                        <label>Note</label>
                        <textarea name="note" id="noteAdd" class="form-control" rows="3"
                                placeholder="Tuliskan keterangan tambahan..."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- ===== End Add Modal ===== -->
<script>
function toggleNoteAdd(select) {
    const wrapper = document.getElementById('noteAddWrapper');
    const note    = document.getElementById('noteAdd');
    if (select.value === 'Verifikasi' || select.value === 'Sampling Ulang') {
        wrapper.style.display = 'block';
        note.required = true;
    } else {
        wrapper.style.display = 'none';
        note.required = false;
        note.value = '';
    }
}
</script>
<?php echo view('parsial/footer'); ?>