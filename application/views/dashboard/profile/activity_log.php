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
                        <a class="nav-link" href="<?= base_url('profile/change_password') ?>">
                            <i class="fas fa-key me-2"></i> Ubah Password
                        </a>
                        <a class="nav-link active" href="<?= base_url('profile/activity_log') ?>">
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
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i> Riwayat Aktivitas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Aktivitas</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($user->last_login): ?>
                                <tr>
                                    <td><i class="fas fa-sign-in-alt text-success me-2"></i> Login Terakhir</td>
                                    <td><?= date('d M Y H:i:s', strtotime($user->last_login)) ?></td>
                                </tr>
                                <?php endif; ?>
                                
                                <?php if ($user->last_logout): ?>
                                <tr>
                                    <td><i class="fas fa-sign-out-alt text-danger me-2"></i> Logout Terakhir</td>
                                    <td><?= date('d M Y H:i:s', strtotime($user->last_logout)) ?></td>
                                </tr>
                                <?php endif; ?>
                                
                                <?php if ($user->last_activity): ?>
                                <tr>
                                    <td><i class="fas fa-clock text-primary me-2"></i> Aktivitas Terakhir</td>
                                    <td><?= date('d M Y H:i:s', strtotime($user->last_activity)) ?></td>
                                </tr>
                                <?php endif; ?>
                                
                                <tr>
                                    <td><i class="fas fa-user-plus text-info me-2"></i> Terdaftar</td>
                                    <td><?= date('d M Y H:i:s', strtotime($user->created_at)) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i> Riwayat aktivitas menunjukkan interaksi terakhir Anda dengan sistem.
                    </div>
                    
                    <div class="d-flex justify-content-start mt-4">
                        <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>