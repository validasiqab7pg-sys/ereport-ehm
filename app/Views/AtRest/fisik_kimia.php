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
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>FisikKimia"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>FisikKimia" style="font-weight: bold; color: black; font-size: 14px;">Data Pemeriksaan Fisika &amp; Kimia</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- Tombol Add Data (hanya QA Analis / Spv QA / Manager QA) -->
                                    <?php if (
                                        $session->get('jabatan') == 'QA Analis' ||
                                        $session->get('jabatan') == 'Manager QA' ||
                                        $session->get('jabatan') == 'Spv QA'
                                    ): ?>
                                        <button type="button"
                                            class="btn btn-primary mt-3 btn-animation"
                                            data-animation="slideInUp"
                                            style="float:right;"
                                            data-toggle="modal"
                                            data-target="#addModal">
                                            Add Data
                                        </button>
                                    <?php endif; ?>

                                    <h4 class="card-title mb-4">Data Pemeriksaan Fisika &amp; Kimia</h4>

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
                                                        <td><?= esc($row['jumlah_titik'] ?? '-') ?></td>
                                                        <td style="width: 160px;">
                                                            <?php
                                                            $st = $row['status'] ?? null;
                                                            if ($st == null || $st == 'On Progress'): ?>
                                                                <div class="badge bg-secondary">On Progress</div>
                                                            <?php elseif ($st == 'Selesai di QA'): ?>
                                                                <div class="badge bg-info">Selesai di QA</div>
                                                            <?php elseif ($st == 'Selesai di QC'): ?>
                                                                <div class="badge bg-warning">Selesai di QC</div>
                                                            <?php elseif ($st == 'Selesai di Spv QC'): ?>
                                                                <div class="badge bg-primary">Selesai di Spv QC</div>
                                                            <?php elseif ($st == 'Selesai di Spv QA'): ?>
                                                                <div class="badge bg-success">Selesai di Spv QA</div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" style="float:none;">

                                                                <!-- Tombol View Detail -->
                                                                <a href="<?= base_url() ?>FisikKimia/detail/<?= $row['id'] ?>"
                                                                    class="btn btn-sm btn-primary"
                                                                    style="float:none; margin:3px;"
                                                                    title="Lihat Detail">
                                                                    <span class="ti-eye"></span>
                                                                </a>

                                                                <!-- Tombol Edit (hanya QA Analis) -->
                                                                <?php if ($session->get('jabatan') == 'QA Analis'): ?>
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-warning"
                                                                        style="float:none; margin:3px;"
                                                                        data-toggle="modal"
                                                                        data-target="#editModal<?= $row['id'] ?>"
                                                                        title="Edit">
                                                                        <span class="ti-pencil"></span>
                                                                    </a>
                                                                <?php endif; ?>

                                                                <!-- Tombol Hapus (hanya QA Analis / Spv QA / Manager QA) -->
                                                                <?php if (
                                                                    $session->get('jabatan') == 'QA Analis' ||
                                                                    $session->get('jabatan') == 'Manager QA' ||
                                                                    $session->get('jabatan') == 'Spv QA'
                                                                ): ?>
                                                                    <a href="<?= base_url() ?>FisikKimia/hapus/<?= $row['id'] ?>"
                                                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                                        class="btn btn-sm btn-danger"
                                                                        style="float:none; margin:3px;"
                                                                        title="Hapus">
                                                                        <span class="ti-trash"></span>
                                                                    </a>
                                                                <?php endif; ?>

                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- ===== Modal Edit per baris ===== -->
                                                    <?php if ($session->get('jabatan') == 'QA Analis'): ?>
                                                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form method="POST" action="<?= base_url('FisikKimia/update/' . $row['id']) ?>">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Data Sampling Air</h5>
                                                                        <button type="button" class="close" data-dismiss="modal">
                                                                            <span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <div class="form-group">
                                                                            <label>Tanggal Sampling</label>
                                                                            <input type="date" name="tanggal_sampling" class="form-control"
                                                                                value="<?= esc($row['tanggal_sampling']) ?>" required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Site</label>
                                                                            <select name="site" class="form-control" required>
                                                                                <option value="">-- Pilih Site --</option>
                                                                                <option value="Cikarang" <?= $row['site'] == 'Cikarang' ? 'selected' : '' ?>>Cikarang</option>
                                                                                <option value="Pulogadung" <?= $row['site'] == 'Pulogadung' ? 'selected' : '' ?>>Pulogadung</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Week</label>
                                                                            <select name="week" class="form-control" required>
                                                                                <option value="">-- Pilih Week --</option>
                                                                                <?php foreach (['Week 1','Week 2','Week 3','Week 4','Week 5'] as $w): ?>
                                                                                    <option value="<?= $w ?>" <?= $row['week'] == $w ? 'selected' : '' ?>><?= $w ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Jenis Sampling</label>
                                                                            <select name="jenis_sampling" class="form-control" required>
                                                                                <option value="">-- Pilih Jenis Sampling --</option>
                                                                                <?php foreach ($jenis_sampling_list as $js): ?>
                                                                                    <option value="<?= esc($js['jenis_sampling']) ?>"
                                                                                        <?= $row['jenis_sampling'] == $js['jenis_sampling'] ? 'selected' : '' ?>>
                                                                                        <?= esc($js['jenis_sampling']) ?>
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Keterangan</label>
                                                                            <select name="keterangan" class="form-control" required
                                                                                onchange="toggleNoteEdit(this, <?= $row['id'] ?>)">
                                                                                <option value="">-- Pilih Keterangan --</option>
                                                                                <option value="NA" <?= $row['keterangan'] == 'NA' ? 'selected' : '' ?>>NA</option>
                                                                                <option value="Verifikasi" <?= $row['keterangan'] == 'Verifikasi' ? 'selected' : '' ?>>Verifikasi</option>
                                                                                <option value="Sampling Ulang" <?= $row['keterangan'] == 'Sampling Ulang' ? 'selected' : '' ?>>Sampling Ulang</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group" id="noteEditWrapper<?= $row['id'] ?>"
                                                                            style="display:<?= in_array($row['keterangan'], ['Verifikasi','Sampling Ulang']) ? 'block' : 'none' ?>;">
                                                                            <label>Note</label>
                                                                            <textarea name="note" class="form-control" rows="3"><?= esc($row['note']) ?></textarea>
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
    </div>
</div>

<!-- ===== Modal Add Data ===== -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="<?= base_url('FisikKimia/tambah') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pemeriksaan Fisika &amp; Kimia</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
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
<!-- ===== End Modal Add Data ===== -->

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

function toggleNoteEdit(select, id) {
    const wrapper = document.getElementById('noteEditWrapper' + id);
    if (select.value === 'Verifikasi' || select.value === 'Sampling Ulang') {
        wrapper.style.display = 'block';
    } else {
        wrapper.style.display = 'none';
    }
}
</script>

<?php echo view('parsial/footer'); ?>