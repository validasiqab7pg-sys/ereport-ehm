<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - E Report Kualifikasi EHM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/b7.png') ?>">

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet">

    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #007bff 0%, #e0f7ff 100%);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-register {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            transition: all 0.3s ease-in-out;
        }

        .card-register:hover {
            transform: scale(1.01);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .btn-primary {
            border-radius: 10px;
            background-color: #007bff;
            border: none;
            padding: 12px;
            font-weight: 600;
        }

        .logo {
            max-height: 70px;
            margin-bottom: 20px;
        }

        .footer-text {
            margin-top: 30px;
            text-align: center;
            color: #333;
        }

        .footer-text a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="card-register">
        <div class="text-center">
            <img src="<?= base_url('assets/images/logo-b7.png') ?>" alt="Logo" class="logo">
            <h4 class="text-dark">E-Report EHM</h4>
            <p class="text-muted mb-4">Silakan isi form untuk mendaftar</p>
        </div>
        <form action="<?= base_url('Register/Process') ?>" method="post">
            <div class="mb-3">
                <label class="form-label" for="useremail">Email</label>
                <input type="email" class="form-control" id="useremail" name="email" placeholder="Masukkan email" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="userpassword">Password</label>
                <input type="password" class="form-control" id="userpassword" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="userdept">Department</label>
                
                <select class="form-control" id="userdept" name="department" required>
                    <option selected disabled value="">Pilih Departemen...</option>
                    <option value="QA">QA</option>
                    <option value="QC">QC</option>
                    <option value="QS">QS</option> 
                </select>
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Position</label>
                <select class="form-control" id="jabatan" name="jabatan" required>
                    <option selected disabled value="">Pilih jabatan...</option>
                    <option value="QA Analis">QA Analis</option>
                    <option value="QC Analis">QC Analis</option>
                    <option value="Spv QA">Spv QA</option>
                    <option value="Spv QC">Spv QC</option>
                    <option value="Manager QA">Manager QA</option>
                    <option value="Manager QC">Manager QC</option>
                </select>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>

        <div class="footer-text">
            <p>Sudah punya akun? <a href="<?= base_url('Login') ?>">Login di sini</a></p>
            <p>© <script>document.write(new Date().getFullYear())</script> Digitalization</p>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>

    <?php
    $session = session();
    $toast = $session->getFlashdata('Toast');
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

</body>

</html>
