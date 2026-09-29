<?= view('parsial/navbar'); ?>
<?= view('parsial/sidebar'); ?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-2">
                <div class="col-lg-3 col-5">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home "></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Master Data Ruangan </a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#addModal">Add Data</button>
                            <?php } ?>
                            <h4 class="card-title mb-4">Master Data Ruangan</h4>
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama AHU</th>
                                        <th>Keterangan</th>
                                        <th>Nama Ruangan</th>
                                        <th>Kelas</th>
                                        <th>Suhu Min</th>
                                        <th>Suhu Max</th>
                                        <th>rH Min</th>
                                        <th>rH Max</th>
                                        <th>Lux</th>
                                        <th>Syarat Perbedaan Tekanan</th>
                                        <th>Pertukaran Udara</th>
                                        <th>Partikel 0.5 at rest</th>
                                        <th>Partikel 5.0 at rest</th>
                                        <th>Partikel 0.5 in op</th>
                                        <th>Partikel 5.0 in op</th>
                                        <th>Volume TPC</th>
                                        <th>Volume KK</th>
                                        <th>Capar TPC</th>
                                        <th>Capar KK</th>
                                        <th>Titik Suhu</th>
                                        <th>Titik RH</th>
                                        <th>Titik Mikro</th>
                                        <th>Titik Partikel</th>
                                        <th>Titik Capar</th>
                                        <th>Titik Flow</th>
                                        <th>Titik Lux</th>
                                        <th>Patogen</th>
                                       
                                        <th>Volume Ruangan</th>
                                        <?php if ($session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA'or $session->get('jabatan') == 'Admin') { ?>
                                            <th>Aksi</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $no => $row) : ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>
                                            <td><?= esc($row['nama_ahu']) ?></td>
                                            <td><?= esc($row['keterangan']) ?></td>
                                            <td><?= esc($row['nama_ruangan']) ?></td>
                                            <td><?= esc($row['kelas']) ?></td>
                                            <td><?= esc($row['suhu_min']) ?></td>
                                            <td><?= esc($row['suhu_max']) ?></td>
                                            <td><?= esc($row['rh_min']) ?></td>
                                            <td><?= esc($row['rh_max']) ?></td>
                                            <td><?= esc($row['lux']) ?></td>
                                            <td><?= esc($row['Perbedaan_Tekanan']) ?></td>
                                            <td><?= esc($row['Pertukaran_Udara']) ?></td>
                                            <td><?= esc($row['Partikel_05AR']) ?></td>
                                            <td><?= esc($row['Partikel_50AR']) ?></td>
                                            <td><?= esc($row['Partikel_05IO']) ?></td>
                                            <td><?= esc($row['Partikel_50IO']) ?></td>
                                            <td><?= esc($row['Volumetrik_TPC']) ?></td>
                                            <td><?= esc($row['Volumetrik_KK']) ?></td>
                                            <td><?= esc($row['Capar_TPC']) ?></td>
                                            <td><?= esc($row['Capar_KK']) ?></td>
                                            <td><?= esc($row['titik_suhu']) ?></td>
                                            <td><?= esc($row['titik_rh']) ?></td>
                                            <td><?= esc($row['titik_mikro']) ?></td>
                                            <td><?= esc($row['titik_partikel']) ?></td>
                                            <td><?= esc($row['titik_capar']) ?></td>
                                            <td><?= esc($row['titik_flow']) ?></td>
                                            <td><?= esc($row['titik_lux']) ?></td>
                                            <td><?= esc($row['patogen']) ?></td>
                                           
                                            <td><?= esc($row['volume_ruangan']) ?></td>
                                            <?php if ($session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                                <td>
                                                    <div class="btn-group btn-group-sm" style="float: none;">
                                                        <button type="button" class="btn btn-sm btn-primary" style="float: none; margin: 5px;" data-toggle="modal" data-target="#editModal<?= $row['id'] ?>">
                                                            <span class="ti-pencil"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger" style="float: none; margin: 5px;" data-toggle="modal" data-target="#deleteModal<?= $row['id'] ?>">
                                                            <span class="ti-trash"></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
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

<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form method="POST" action="<?= base_url('masterdataruangan/create') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Ruangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama AHU</label>
                                <input type="text" name="nama_ahu" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" name="keterangan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Ruangan</label>
                                <input type="text" name="nama_ruangan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" name="kelas" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Suhu Min</label>
                                <input type="number" step="0.01" name="suhu_min" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Suhu Max</label>
                                <input type="number" step="0.01" name="suhu_max" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>rH Min</label>
                                <input type="number" step="0.01" name="rh_min" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>rH Max</label>
                                <input type="number" step="0.01" name="rh_max" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Lux</label>
                                <input type="number" step="0.01" name="lux" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Syarat Perbedaan Tekanan</label>
                                <input type="text" name="Perbedaan_Tekanan" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pertukaran Udara</label>
                                <input type="text" name="Pertukaran_Udara" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Partikel 0.5 at rest</label>
                                <input type="text" name="Partikel_05AR" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Partikel 5.0 at rest</label>
                                <input type="text" name="Partikel_50AR" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Partikel 0.5 in op</label>
                                <input type="text" name="Partikel_05IO" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Partikel 5.0 in op</label>
                                <input type="text" name="Partikel_50IO" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Volume TPC</label>
                                <input type="text" name="Volumetrik_TPC" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Volume KK</label>
                                <input type="text" name="Volumetrik_KK" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Capar TPC</label>
                                <input type="text" name="Capar_TPC" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Capar KK</label>
                                <input type="text" name="Capar_KK" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Titik Suhu</label>
                                <input type="text" name="titik_suhu" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Titik RH</label>
                                <input type="text" name="titik_rh" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Titik Mikro</label>
                                <input type="text" name="titik_mikro" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Titik Partikel</label>
                                <input type="text" name="titik_partikel" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Titik Capar</label>
                                <input type="text" name="titik_capar" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Titik Flow</label>
                                <input type="text" name="titik_flow" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Titik Lux</label>
                                <input type="text" name="titik_lux" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Patogen</label>
                                <input type="text" name="patogen" class="form-control" required>
                            </div>
                          
                            <div class="form-group">
                                <label>Volume Ruangan</label>
                                <input type="text" name="volume_ruangan" class="form-control" required>
                            </div>
                        </div>
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

<?php foreach ($data as $row) : ?>
    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <form method="POST" action="<?= base_url('masterdataruangan/edit/' . $row['id']) ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Ruangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama AHU</label>
                                    <input type="text" name="nama_ahu" class="form-control" value="<?= esc($row['nama_ahu']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" value="<?= esc($row['keterangan']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama Ruangan</label>
                                    <input type="text" name="nama_ruangan" class="form-control" value="<?= esc($row['nama_ruangan']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <input type="text" name="kelas" class="form-control" value="<?= esc($row['kelas']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Suhu Min</label>
                                    <input type="number" step="0.01" name="suhu_min" class="form-control" value="<?= esc($row['suhu_min']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Suhu Max</label>
                                    <input type="number" step="0.01" name="suhu_max" class="form-control" value="<?= esc($row['suhu_max']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>rH Min</label>
                                    <input type="number" step="0.01" name="rh_min" class="form-control" value="<?= esc($row['rh_min']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>rH Max</label>
                                    <input type="number" step="0.01" name="rh_max" class="form-control" value="<?= esc($row['rh_max']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Lux</label>
                                    <input type="number" step="0.01" name="lux" class="form-control" value="<?= esc($row['lux']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Syarat Perbedaan Tekanan</label>
                                    <input type="text" name="Perbedaan_Tekanan" class="form-control" value="<?= esc($row['Perbedaan_Tekanan']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pertukaran Udara</label>
                                    <input type="text" name="Pertukaran_Udara" class="form-control" value="<?= esc($row['Pertukaran_Udara']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Partikel 0.5 at rest</label>
                                    <input type="text" name="Partikel_05AR" class="form-control" value="<?= esc($row['Partikel_05AR']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Partikel 5.0 at rest</label>
                                    <input type="text" name="Partikel_50AR" class="form-control" value="<?= esc($row['Partikel_50AR']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Partikel 0.5 in op</label>
                                    <input type="text" name="Partikel_05IO" class="form-control" value="<?= esc($row['Partikel_05IO']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Partikel 5.0 in op</label>
                                    <input type="text" name="Partikel_50IO" class="form-control" value="<?= esc($row['Partikel_50IO']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Volume TPC</label>
                                    <input type="text" name="Volumetrik_TPC" class="form-control" value="<?= esc($row['Volumetrik_TPC']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Volume KK</label>
                                    <input type="text" name="Volumetrik_KK" class="form-control" value="<?= esc($row['Volumetrik_KK']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Capar TPC</label>
                                    <input type="text" name="Capar_TPC" class="form-control" value="<?= esc($row['Capar_TPC']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Capar KK</label>
                                    <input type="text" name="Capar_KK" class="form-control" value="<?= esc($row['Capar_KK']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Titik Suhu</label>
                                    <input type="text" name="titik_suhu" class="form-control" value="<?= esc($row['titik_suhu']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Titik RH</label>
                                    <input type="text" name="titik_rh" class="form-control" value="<?= esc($row['titik_rh']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Titik Mikro</label>
                                    <input type="text" name="titik_mikro" class="form-control" value="<?= esc($row['titik_mikro']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Titik Partikel</label>
                                    <input type="text" name="titik_partikel" class="form-control" value="<?= esc($row['titik_partikel']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Titik Capar</label>
                                    <input type="text" name="titik_capar" class="form-control" value="<?= esc($row['titik_capar']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Titik Flow</label>
                                    <input type="text" name="titik_flow" class="form-control" value="<?= esc($row['titik_flow']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Titik Lux</label>
                                    <input type="text" name="titik_lux" class="form-control" value="<?= esc($row['titik_lux']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Patogen</label>
                                    <input type="text" name="patogen" class="form-control" value="<?= esc($row['patogen']) ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Volume Ruangan</label>
                                    <input type="text" name="volume_ruangan" class="form-control" value="<?= esc($row['volume_ruangan']) ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ruangan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="<?= base_url() ?>masterdataruangan/delete/<?= $row['id'] ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?= view('parsial/footer'); ?>