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
                                <li class="breadcrumb-item"><a href="#">User Management </a></li>
                            </ol>
                        </nav>
                    </div>

                </div>
            <div>
            <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">    
                            <div class="card-body table-responsive">
                                                
                            <h4 class="card-title mb-4">User Management</h4> 
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr> 
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $no => $user): ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>
                                            <td><?= esc($user['username']) ?></td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td><?= esc($user['department']) ?></td>
                                            <td><?= esc($user['jabatan']) ?></td>

                                            <!-- Kolom Status -->
                                            <td>
                                                <?php if ($user['status'] === 'approved'): ?>
                                                    <!-- Jika sudah approved, hanya tampilkan teks -->
                                                    Approved
                                                <?php else: ?>
                                                    <!-- Jika belum approved, tampilkan tombol Approve dan Reject -->
                                                    <a href="<?= base_url('UserManagement/approve/'.$user['id']) ?>" class="btn btn-success btn-sm">Approve</a>
                                                    <a href="<?= base_url('UserManagement/reject/'.$user['id']) ?>" class="btn btn-danger btn-sm">Reject</a>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Kolom Aksi -->
                                            <td>
                                                <!-- Tombol Delete (selalu muncul) -->
                                                <a href="<?= base_url('UserManagement/delete/'.$user['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?');">Delete</a>
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
<?php
$session = session();
$toast = $session->getFlashdata('Toast');

// Jika $toast bukan array, ubah dulu
if (is_string($toast)) {
    $toast = ['message' => $toast, 'type' => 'error'];
}
?>
<script>
    <?php if ($toast): ?>
        Swal.fire({
            icon: "<?= $toast['type'] ?>",
            title: "<?= $toast['type'] === 'success' ? 'Sukses!' : 'Oops!' ?>",
            text: "<?= $toast['message'] ?>"
        });
    <?php endif; ?>
</script>
<!-- Add Modal -->


<?= view('parsial/footer'); ?>
