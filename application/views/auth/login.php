<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-center mb-0">
                        <i class="fas fa-sign-in-alt me-2"></i>LOGIN SISTEM
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-3 py-2">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open('auth', ['class' => 'needs-validation', 'novalidate' => '']) ?>
                    <div class="mb-3">
                        <label for="username" class="form-label fw-medium">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" name="username" class="form-control"
                                placeholder="Masukkan username" required
                                value="<?= set_value('username') ?>">
                        </div>
                        <div class="invalid-feedback">Username wajib diisi</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukkan password" required>
                        </div>
                        <div class="invalid-feedback">Password wajib diisi</div>

                        <!-- Pindahkan "Lupa password" di sini -->
                        <div class="text-end mt-2">
                            <a href="<?= base_url('auth/forgot_password') ?>" class="text-decoration-none small">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mt-2">
                        <i class="fas fa-sign-in-alt me-2"></i>MASUK
                    </button>

                    <?= form_close() ?>

                    <div class="card-footer bg-light text-center py-3">
                        <span class="small">Belum punya akun? </span>
                        <a href="<?= base_url('auth/register') ?>" class="text-decoration-none fw-medium">
                            Daftar disini
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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