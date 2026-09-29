<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="page-content-wrapper ">

            <div class="container-fluid">

               
                <div class="header-body">
          <div class="row align-items-center py-2"> 
            <div class="col-lg-3 col-5">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home "></i></a></li>
                <li class="breadcrumb-item"><a href="#">Setting</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      <?= $getdata['username']; ?>
                    </li>
                </ol>
              </nav>
            </div>
           
          </div>
          <div>


          
<!-- Page content -->
<div class="container-fluid mt--6">
        <div class="card mb-4">
          <!-- Card header -->
          <div class="card-header">
            <h3 class="mb-0">Profile</h3>
          </div>
          <!-- Card body -->
          <?php
                    $session = session();
                    $repassword = $session->getFlashdata('repassword');
                    $password = $session->getFlashdata('password');
                ?>
        <div class="card-body">
            <!-- Form groups used in grid -->
            <form method="POST" action="<?php echo base_url()?>/Home/Update">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <!-- <label class="form-control-label" for="example2cols1Input" >NIK</label> -->
                  <input
                    type="hidden"
                    class="form-control"
                    id="example2cols1Input"
                    placeholder="Nik"
                    name="id"
                    value="<?= $getdata['id'] ?>" />
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="example2cols2Input">Username</label>
                  <input type="text" class="form-control" id="example2cols2Input" name="username" readonly value  ="<?= $getdata['username'] ?>"/>
                </div>
              </div>            
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="example2cols2Input">Departemen</label>
                  <input
                    type="text"
                    class="form-control"
                    id="example2cols2Input"
                    name="departemen" readonly
                    value  ="<?= $getdata['department'] ?>"/>
                </div>
              </div>           
            <!-- --- -->       
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="example2cols1Input">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    id="example2cols1Input"
                    name="email" readonly
                    value="<?= $getdata['email'] ?>" />
                </div>
              </div>              
            </div>
            <!--<input type="submit" class="btn btn-primary" style="float:right;" value ="Simpan">-->
        </form>
          </div>
        </div>        
        <div class="row">
          <div class="col-lg-12">
            <div class="card-wrapper">
              <!-- Form controls -->
              <div class="card">
                <!-- Card header -->
                <div class="card-header">
                  <h3 class="mb-0">Change Password</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                  <form method="POST"  action="<?php echo base_url()?>/Home/UpdatePassword">
                  <input
                    type="hidden"
                    class="form-control"
                    id="example2cols1Input"
                    name="id"
                    value="<?= $getdata['id'] ?>" />
                    <div class="form-group">
                      <label class="form-control-label" for="exampleFormControlInput1">Password</label>
                      
                      <input class="form-control <?= ($password)?'is-invalid':'' ?>" placeholder="Password" type="password" name="password">
                    <div class="invalid-feedback">
                              <?php if ($password) { 
                              echo $password;  } ?>
                        </div>  
                    </div>
                    <div class="form-group">
                      <label class="form-control-label" for="exampleFormControlInput1">New Password</label>
                      <input class="form-control" placeholder="New Password" type="password" name="newpassword">
                    </div>
                    <div class="form-group">
                      <label class="form-control-label" for="exampleFormControlInput1">Confirm Password</label>
                      <input class="form-control <?= ($repassword)?'is-invalid':'' ?>" placeholder="Confrim Password" type="password" name="repassword">
                      <div class="invalid-feedback">
                              <?php if ($repassword) { 
                              echo $repassword;  } ?>
                        </div>  
                    </div>
                    <input type="submit" class="btn btn-primary" style="float:right;" value ="Save">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
$session = session();
$toast = $session->getFlashdata('Toast');

// Safety: Pastikan bentuknya array
if (is_string($toast)) {
    $toast = ['message' => $toast, 'type' => 'error'];
}
?>

<script>
    <?php if (!empty($toast) && isset($toast['message'])): ?>
    Swal.fire({
        icon: "<?= $toast['type'] ?? 'info' ?>",
        title: "<?= ($toast['type'] === 'success') ? 'Sukses!' : 'Oops!' ?>",
        text: "<?= $toast['message'] ?>"
    });
    <?php endif; ?>
</script>
      
        
        <!-- Footer -->   
<?php echo view('parsial/footer'); ?>

