<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - E Report EHM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/b7.png') ?>">

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet">

    <!-- Material Design Icons for eye toggle -->
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

        .card-login {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            transition: all 0.3s ease-in-out;
        }

        .card-login:hover {
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

        .toggle-btn {
            border: none;
            background: none;
            position: absolute;
            right: 15px;
            top: 35px;
            cursor: pointer;
            color: #007bff;
        }

        .position-relative {
            position: relative;
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

    <div class="card-login">
        <div class="text-center">
            <img src="<?= base_url('assets/images/logo-b7.png') ?>" alt="Logo" class="logo">
            <h4 class="text-dark">E-Report EHM</h4>
            <p class="text-muted mb-4">Silakan login untuk melanjutkan</p>
        </div>
        <form method="POST" action="<?= base_url('Auth/Process_Login') ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3 position-relative">
                <label for="userpassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="userpassword" name="password" placeholder="Masukkan password" required>
                <button type="button" class="toggle-btn" id="togglePassword" tabindex="-1">
                    <i class="mdi mdi-eye-off" id="eyeIcon"></i>
                </button>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>

        <div class="footer-text">
            <p>Belum punya akun? <a href="<?= base_url('Register') ?>">Daftar sekarang</a></p>
            <p>© <script>document.write(new Date().getFullYear())</script> Digitalization</p>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>

    <!-- Toggle password -->
    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            const passwordInput = document.getElementById("userpassword");
            const eyeIcon = document.getElementById("eyeIcon");
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            eyeIcon.classList.toggle("mdi-eye");
            eyeIcon.classList.toggle("mdi-eye-off");
        });
    </script>

    <!-- SweetAlert Login Error -->
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
