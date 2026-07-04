<!DOCTYPE html>
<html>

<head>

    <title>Luxe Spa Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center mt-5">

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body">

                        <h3 class="text-center mb-4">
                            Luxe Spa Admin
                        </h3>

                        <?php if ($__flash_error = session()->getFlashdata('error')): ?>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({ icon: 'error', title: 'Login Failed', text: <?= json_encode($__flash_error) ?>, confirmButtonColor: '#0d6efd' });
                        });
                        </script>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/login/process') ?>" method="post">

                            <div class="mb-3">

                                <label>Email</label>

                                <input type="email" name="email" class="form-control" required>

                            </div>

                            <div class="mb-3">

                                <label>Password</label>

                                <div style="position:relative">
                                    <input type="password" name="password" id="adminPassword" class="form-control" style="padding-right:40px" required>
                                    <button type="button" tabindex="-1" onclick="togglePw('adminPassword',this)"
                                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;outline:none;cursor:pointer;padding:0;color:#6c757d;font-size:13px;line-height:1">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>

                            </div>

                            <button class="btn btn-primary w-100">

                                Login

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

<script>
function togglePw(id, btn) {
    var inp = document.getElementById(id);
    var icon = btn.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        inp.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>

</body>

</html>
