<?= view('parsial/navbar'); ?>
<?= view('parsial/sidebar'); ?>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-2">
                <div class="col-lg-3 col-5">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Monitoring Penyimpangan Data Air</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <h4 class="card-title mb-4">Monitoring Penyimpangan Data Air</h4>
                                <table id="datatable2" class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Site</th>
                                            <th>Nama Outlet</th>
                                            <th>No Outlet</th>
                                            <th>Tanggal Sampling</th>
                                            <th>Parameter TMS</th>
                                            <th>Keterangan</th>
                                            <th>Penyimpangan</th>
                                            <th>Status</th>
                                            <?php if ($session->get('jabatan') == 'Manager QA' || $session->get('jabatan') == 'Spv QA') : ?>
                                                <th>Aksi</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data_request as $no => $item) : ?>
                                            <tr>
                                                <td><?= $no + 1 ?></td>
                                                <td><?= esc($item['site']) ?></td>
                                                <td><?= esc($item['nama_outlet_sampling']) ?></td>
                                                <td><?= esc($item['no_outlet_sampling']) ?></td>
                                                <td><?= esc($item['tanggal_sampling']) ?></td>
                                                <td><?= esc($item['parameter_tms']) ?></td>
                                                <td><?= esc($item['keterangan']) ?></td>
                                                <td>
                                                    <?php if (empty($item['upload_penyimpangan'])) : ?>
                                                        <!-- Tombol Upload Penyimpangan -->
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#uploadPenyimpanganModal<?= $item['id'] ?>">
                                                            Upload Penyimpangan
                                                        </button>
                                                    <?php else : ?>
                                                        <!-- Link file yang bisa di klik -->
                                                        <a href="<?= base_url('uploads/penyimpangan_air/' . $item['upload_penyimpangan']) ?>" target="_blank">
                                                            <?= esc($item['upload_penyimpangan']) ?>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($item['upload_penyimpangan'])) : ?>
                                                        <span class="btn btn-success btn-sm">Complete</span>
                                                    <?php else : ?>
                                                        <span class="btn btn-warning btn-sm">Uncompleted</span>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if ($session->get('jabatan') == 'Manager QA' || $session->get('jabatan') == 'Spv QA') : ?>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" style="float: none;">
                                                            <a href="<?= base_url() ?>OosPenyimpanganAir/deletePenyimpangan/<?= $item['id'] ?>" onclick="return confirm('Yakin Ingin menghapus nya ?')" class="btn btn-sm btn-danger" style="margin: 5px;">
                                                                <span class="ti-trash"></span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <!-- Modal Upload Penyimpangan per row -->
                                <?php foreach ($data_request as $item) : ?>
                                    <div class="modal fade" id="uploadPenyimpanganModal<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="uploadPenyimpanganModalLabel<?= $item['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <form method="POST" action="<?= base_url('OosPenyimpanganAir/upload_penyimpangan/' . $item['id']) ?>" enctype="multipart/form-data">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="uploadPenyimpanganModalLabel<?= $item['id'] ?>">Upload Penyimpangan - <?= esc($item['nama_outlet_sampling']) ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert alert-danger" role="alert" style="font-weight: bold;">
                                                            ⚠️ File hanya dapat diupload satu kali dan <u>tidak dapat diganti</u> setelah disimpan.
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Parameter TMS</label>
                                                            <input type="text" class="form-control" value="<?= esc($item['parameter_tms']) ?>" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="keterangan<?= $item['id'] ?>">Keterangan</label>
                                                            <textarea name="keterangan" id="keterangan<?= $item['id'] ?>" class="form-control" rows="3" required><?= esc($item['keterangan']) ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="upload_penyimpangan<?= $item['id'] ?>">Upload File Penyimpangan (PDF/JPG/PNG max 5MB)</label>
                                                            <input type="file" name="upload_penyimpangan" id="upload_penyimpangan<?= $item['id'] ?>" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
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
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= view('parsial/footer'); ?>