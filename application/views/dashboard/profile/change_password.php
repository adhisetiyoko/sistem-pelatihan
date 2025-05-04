<div class="container py-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <!-- Sidebar Menu -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar mb-3" style="width: 100px; height: 100px; background-color: #3a7bd5; color: white; display: inline-flex; align-items: center; justify-content: center; font-size: 2.5rem; border-radius: 50%;">
                            <?= strtoupper(substr($user->username, 0, 1)) ?>
                        </div>
                        <h5 class="mb-1"><?= $user->username ?></h5>
                        <p class="text-muted small mb-0"><?= $user->email ?></p>
                    </div>
                    
                    <hr>
                    
                    <div class="nav flex-column nav-pills">
                        <a class="nav-link" href="<?= base_url('profile') ?>">
                            <i class="fas fa-user me-2"></i> Profil Saya
                        </a>
                        <a class="nav-link" href="<?= base_url('profile/edit') ?>">
                            <i class="fas fa-edit me-2"></i> Edit Profil
                        </a>
                        <a class="nav-link active" href="<?= base_url('profile/change_password') ?>">
                            <i class="fas fa-key me-2"></i> Ubah Password
                        </a>
                        <a class="nav-link" href="<?= base_url('profile/activity_log') ?>">
                            <i class="fas fa-history me-2"></i> Riwayat Aktivitas
                        </a>
                        <a class="nav-link" href="<?= base_url('settings') ?>">
                            <i class="fas fa-cog me-2"></i> Pengaturan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-key me-2"></i> Ubah Password</h5>
                </div>
                <div class="card-body">
                    <?= form_open('profile/change_password'); ?>
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <div class="input-group">
                            <input type="password" class="form-control <?= form_error('current_password') ? 'is-invalid' : '' ?>" id="current_password" name="current_password">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="invalid-feedback">
                                <?= form_error('current_password') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control <?= form_error('new_password') ? 'is-invalid' : '' ?>" id="new_password" name="new_password">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="invalid-feedback">
                                <?= form_error('new_password') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                <i class="fas fa-eye"></i>
                            </button>
                            <div class="invalid-feedback">
                                <?= form_error('confirm_password') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Password harus memiliki minimal 6 karakter dan sebaiknya menggunakan kombinasi huruf, angka, dan simbol untuk keamanan yang lebih baik.
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Ubah Password
                        </button>
                    </div>
                    
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Toggle password visibility
    $('.toggle-password').click(function() {
        const target = $(this).data('target');
        const input = $('#' + target);
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
</script>