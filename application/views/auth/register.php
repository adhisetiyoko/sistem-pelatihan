<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-center mb-0">
                        <i class="fas fa-user-plus me-2"></i>REGISTRASI AKUN
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-3 py-2">
                            <?php echo validation_errors(); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open('auth/register', ['class' => 'needs-validation', 'novalidate' => '']); ?>

                    <div class="mb-3">
                        <label for="username" class="form-label fw-medium">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="username" class="form-control"
                                value="<?php echo set_value('username'); ?>" required>
                        </div>
                        <div class="invalid-feedback">Harap isi username</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo set_value('email'); ?>" required>
                        </div>
                        <div class="invalid-feedback">Harap isi email yang valid</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Harap isi password</div>
                        <small class="form-text text-muted">Minimal 6 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label for="password2" class="form-label fw-medium">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password2" id="password2" class="form-control" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Harap konfirmasi password</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mt-2">
                        <i class="fas fa-user-plus me-2"></i>DAFTAR SEKARANG
                    </button>

                    <?php echo form_close(); ?>

                    <div class="text-center mt-3">
                        <span class="small">Sudah memiliki akun? </span>
                        <a href="<?php echo base_url('auth'); ?>" class="text-decoration-none fw-medium">
                            Masuk disini
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                this.setAttribute('title', 'Sembunyikan password');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                this.setAttribute('title', 'Tampilkan password');
            }
        });
    });

    // Validasi form Bootstrap
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>