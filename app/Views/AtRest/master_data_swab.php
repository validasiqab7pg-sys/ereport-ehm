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
                                <li class="breadcrumb-item"><a href="#">Master Data Swab </a></li>
                            </ol>
                        </nav>
                    </div>

                </div>
            <div>
            <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">    
                            <div class="card-body table-responsive">
                                                <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                                    <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#addModal">Add Data</button>
                                                    <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-success">Click me</button> -->
                                                <?php } ?>
                                                <h4 class="card-title mb-4">Master Data Swab Personnel/Machine Hygiene</h4> 
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Site</th>
                                        <th>AHU</th>
                                        <th>Kategori</th>
                                        <th>Nama Mesin/Personil/Alat</th>
                                        <th>Kelas</th>
                                        <th>Nama Ruangan</th>
                                        <th>Departemen</th>
                                        <th>Lokasi Sampling</th>
                                        <th>Periode</th>
                                        <?php if( $session->get('jabatan') == 'Manager QA' OR $session->get('jabatan') == 'Spv QA'){ ?>
                                        <th>Aksi</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $no => $row): ?>
                                    <tr>
                                        <td><?= $no + 1 ?></td>
                                        <td><?= esc($row['site']) ?></td>
                                        <td><?= esc($row['ahu']) ?></td>
                                        <td><?= esc($row['kategori']) ?></td>
                                        <td><?= esc($row['nama_mesin_personil_alat']) ?></td>
                                        <td><?= esc($row['kelas']) ?></td>
                                        <td><?= esc($row['nama_ruangan']) ?></td>
                                        <td><?= esc($row['departemen']) ?></td>
                                        <td><?= esc($row['lokasi_sampling']) ?></td>
                                        <td><?= esc($row['periode']) ?></td>
                                        <?php if( $session->get('jabatan') == 'Manager QA' OR $session->get('jabatan') == 'Spv QA'){ ?> 
                                        <td>
                                                <div class="btn-group btn-group-sm" style="float: none;">
                                                    <!-- <button type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;">
                                                        <span class="ti-pencil"></span>
                                                    </button> -->
                                                    <?php if( $session->get('jabatan') == 'Manager QA' OR $session->get('jabatan') == 'Spv QA'){ ?>
                                                    <a href="<?= base_url() ?>masterdataswab/delete/<?= $row['id'] ?>" onclick="return confirm('Yakin Ingin menghapus nya ?')"  class="tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;">
                                                        <span class="ti-trash"></span>
                                                    </a>
                                                   
                                                    <a href="<?= base_url() ?>masterdataswab/edit/<?= $row['id'] ?>" class="tabledit-delete-button btn btn-sm btn-primary" style="float: none; margin: 5px;" data-toggle="modal" data-target="#editModal<?= $row['id'] ?>">
                                                        <span class="ti-pencil"></span>
                                                    </button>
                                                    <?php } ?>
                                                </a>
                    
                                        </td>
                                        <?php } ?>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <form method="POST" action="<?= base_url('masterdataswab/edit/' . $row['id']) ?>">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Data Swab</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form fields -->
                                                        <div class="form-group">
                                                            <label>Site</label>
                                                            <input type="text" name="site" class="form-control" value="<?= esc($row['site']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>AHU</label>
                                                            <input type="text" name="ahu" class="form-control" value="<?= esc($row['ahu']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                            <input type="text" name="kategori" class="form-control" value="<?= esc($row['kategori']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Mesin/Personil/Alat</label>
                                                            <input type="text" name="nama_mesin_personil_alat" class="form-control" value="<?= esc($row['nama_mesin_personil_alat']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kelas</label>
                                                            <input type="text" name="kelas" class="form-control" value="<?= esc($row['kelas']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Ruangan</label>
                                                            <input type="text" name="nama_ruangan" class="form-control" value="<?= esc($row['nama_ruangan']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Departemen</label>
                                                            <input type="text" name="departemen" class="form-control" value="<?= esc($row['departemen']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Lokasi Sampling</label>
                                                            <input type="text" name="lokasi_sampling" class="form-control" value="<?= esc($row['lokasi_sampling']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Periode</label>
                                                            <input type="text" name="periode" class="form-control" value="<?= esc($row['periode']) ?>" required>
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
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             </div>
    
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="<?= base_url('masterdataswab/create') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Swab</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Site -->
                    <div class="form-group">
                        <label>Site</label>
                        <select name="site" class="form-control" required>
                            <option value="">-- Pilih Site --</option>
                            <option value="Cikarang">Cikarang</option>
                            <option value="Pulogadung">Pulogadung</option>
                        </select>
                    </div>

                    <!-- AHU -->
                    <div class="form-group">
                        <label>AHU</label>
                        <select name="ahu" class="form-control" required>
                            <option value="">-- Pilih AHU --</option>
                            <option value="1.01">1.01</option>
                            <option value="1.02">1.02</option>
                            <option value="1.03">1.03</option>
                            <option value="1.04">1.04</option>
                            <option value="2.01">2.01</option>
                            <option value="2.02">2.02</option>
                            <option value="2.03">2.03</option>
                            <option value="2.04">2.04</option>
                            <option value="2.05">2.05</option>
                            <option value="3.01">3.01</option>
                            <option value="3.02">3.02</option>
                            <option value="4.01">4.01</option>
                            <option value="4.02">4.02</option>
                            <option value="GF.01">GF.01</option>
                            <option value="GF.02">GF.02</option>
                            <option value="GF.03">GF.03</option>
                            <option value="GF.04">GF.04</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Mesin (Bagian Dalam)">Mesin (Bagian Dalam)</option>
                            <option value="Mesin (Bagian Luar)">Mesin (Bagian Luar)</option>
                            <option value="Alat Bagian Dalam">Alat Bagian Dalam</option>
                            <option value="Alat Bagian Luar">Alat Bagian Luar</option>
                            <option value="Personil">Personil</option>
			    <option value="Mesin (Bagian Dalam)">Mesin (Bagian Dalam) SU</option>
                            <option value="Mesin (Bagian Luar)">Mesin (Bagian Luar) SU</option>
                            <option value="Alat Bagian Dalam">Alat Bagian Dalam SU</option>
                            <option value="Alat Bagian Luar">Alat Bagian Luar SU</option>
                            <option value="Personil">Personil SU</option>
                        </select>
                    </div>

                    <!-- Nama Mesin/Personil/Alat -->
                    <div class="form-group">
                        <label>Nama Mesin/Personil/Alat</label>
                        <input type="text" name="nama_mesin_personil_alat" class="form-control" required>
                    </div>

                    <!-- Kelas -->
                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="kelas" class="form-control" required>
                            <option value="">-- Pilih Kelas --</option>
                            <option value="E">E</option>
                            <option value="E Khusus">E Khusus</option>
                            <option value="D">D</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="A">A</option>
                        </select>
                    </div>

                    <!-- Nama Ruangan -->
                    <div class="form-group">
                        <label>Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" class="form-control" required>
                    </div>

                    <!-- Departemen -->
                    <div class="form-group">
                        <label>Departemen</label>
                        <select name="departemen" class="form-control" required>
                            <option value="">-- Pilih Departemen --</option>
                            <option value="Produksi">Produksi</option>
                            <option value="QA">QA</option>
                            <option value="QC">QC</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Warehouse">Warehouse</option>
                            <option value="RND">RND</option>
                        </select>
                    </div>

                    <!-- Lokasi Sampling -->
                    <div class="form-group">
                        <label>Lokasi Sampling</label>
                        <input type="text" name="lokasi_sampling" class="form-control" required>
                    </div>

                    <!-- Periode -->
                    <div class="form-group">
                        <label>Periode</label>
                        <select name="periode" class="form-control" required>
                            <option value="">-- Pilih Periode --</option>
                            <option value="Caturwulan 1">Caturwulan 1</option>
                            <option value="Caturwulan 2">Caturwulan 2</option>
                            <option value="Caturwulan 3">Caturwulan 3</option>
                            <option value="Semester 1">Semester 1</option>
                            <option value="Semester 2">Semester 2</option>
                        </select>
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

<?= view('parsial/footer'); ?>
