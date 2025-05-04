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
                        <a class="nav-link active" href="<?= base_url('profile') ?>">
                            <i class="fas fa-user me-2"></i> Profil Saya
                        </a>
                        <a class="nav-link" href="<?= base_url('profile/edit') ?>">
                            <i class="fas fa-edit me-2"></i> Edit Profil
                        </a>
                        <a class="nav-link" href="<?= base_url('profile/change_password') ?>">
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
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i> Profil Saya</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Informasi Akun</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Username</strong></td>
                                            <td><?= $user->username ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td><?= $user->email ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status</strong></td>
                                            <td>
                                                <?php if ($user->is_active): ?>
                                                    <span class="badge bg-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Terdaftar</strong></td>
                                            <td><?= date('d M Y', strtotime($user->created_at)) ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-footer bg-light border-0">
                                    <a href="<?= base_url('profile/edit') ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit me-1"></i> Edit Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Aktivitas Terakhir</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Login Terakhir</strong></td>
                                            <td><?= $user->last_login ? date('d M Y H:i', strtotime($user->last_login)) : 'Belum ada' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Logout Terakhir</strong></td>
                                            <td><?= $user->last_logout ? date('d M Y H:i', strtotime($user->last_logout)) : 'Belum ada' ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Aktivitas Terakhir</strong></td>
                                            <td><?= $user->last_activity ? date('d M Y H:i', strtotime($user->last_activity)) : 'Belum ada' ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-footer bg-light border-0">
                                    <a href="<?= base_url('profile/activity_log') ?>" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-history me-1"></i> Lihat Semua Aktivitas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Keamanan Akun</h6>
                                    <p class="card-text">Pastikan keamanan akun Anda dengan melakukan perubahan password secara berkala.</p>
                                    <a href="<?= base_url('profile/change_password') ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-key me-1"></i> Ubah Password
                                    </a>
                                    <a href="<?= base_url('settings/security') ?>" class="btn btn-sm btn-secondary ms-2">
                                        <i class="fas fa-shield-alt me-1"></i> Pengaturan Keamanan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>