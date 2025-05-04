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
                        <a class="nav-link" href="<?= base_url('profile/activity_log') ?>">
                            <i class="fas fa-history me-2"></i> Riwayat Aktivitas
                        </a>
                        <a class="nav-link active" href="<?= base_url('settings') ?>">
                            <i class="fas fa-cog me-2"></i> Pengaturan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i> Pengaturan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-primary text-white">
                                            <i class="fas fa-user-cog"></i>
                                        </div>
                                        <h5 class="ms-3 mb-0">Pengaturan Akun</h5>
                                    </div>
                                    <p class="card-text">Kelola pengaturan akun Anda, termasuk status aktivasi dan preferensi lainnya.</p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="<?= base_url('settings/account') ?>" class="btn btn-primary">
                                        <i class="fas fa-arrow-right me-1"></i> Kelola
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-warning text-white">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <h5 class="ms-3 mb-0">Keamanan</h5>
                                    </div>
                                    <p class="card-text">Kelola pengaturan keamanan akun Anda untuk meningkatkan perlindungan data.</p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="<?= base_url('settings/security') ?>" class="btn btn-warning">
                                        <i class="fas fa-arrow-right me-1"></i> Kelola
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-info text-white">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                        <h5 class="ms-3 mb-0">Notifikasi</h5>
                                    </div>
                                    <p class="card-text">Sesuaikan pengaturan notifikasi untuk mengontrol informasi yang Anda terima.</p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="<?= base_url('settings/notifications') ?>" class="btn btn-info">
                                        <i class="fas fa-arrow-right me-1"></i> Kelola
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-danger text-white">
                                            <i class="fas fa-user-slash"></i>
                                        </div>
                                        <h5 class="ms-3 mb-0">Nonaktifkan Akun</h5>
                                    </div>
                                    <p class="card-text">Nonaktifkan akun Anda untuk sementara atau secara permanen. Tindakan ini dapat dibalik.</p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <a href="<?= base_url('settings/deactivate') ?>" class="btn btn-danger">
                                        <i class="fas fa-arrow-right me-1"></i> Kelola
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

<style>
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>