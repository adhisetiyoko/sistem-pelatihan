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
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i> Keamanan Akun</h5>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 py-1">
                            <li class="breadcrumb-item"><a href="<?= base_url('settings') ?>">Pengaturan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Keamanan</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Password</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Ubah Password</h6>
                                    <p class="text-muted mb-0 small">Ubah password Anda secara berkala untuk keamanan yang lebih baik</p>
                                </div>
                                <a href="<?= base_url('profile/change_password') ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-key me-1"></i> Ubah Password
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Riwayat Login</h6>
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
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="2" class="text-center">Tidak ada riwayat login</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <a href="<?= base_url('profile/activity_log') ?>" class="btn btn-sm btn-outline-secondary mt-2">
                                <i class="fas fa-list me-1"></i> Lihat Semua Aktivitas
                            </a>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Tips Keamanan</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center px-0">
                                    <div class="icon-circle bg-primary text-white me-3">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Gunakan Password yang Kuat</h6>
                                        <p class="mb-0 small text-muted">Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol.</p>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center px-0">
                                    <div class="icon-circle bg-warning text-white me-3">
                                        <i class="fas fa-sync-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Perbarui Password Secara Berkala</h6>
                                        <p class="mb-0 small text-muted">Ubah password Anda minimal setiap 3 bulan sekali.</p>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center px-0">
                                    <div class="icon-circle bg-danger text-white me-3">
                                        <i class="fas fa-user-secret"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Jangan Bagikan Informasi Login</h6>
                                        <p class="mb-0 small text-muted">Lindungi username dan password Anda dari orang lain.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Verifikasi Dua Langkah</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Aktifkan Verifikasi Dua Langkah</h6>
                                    <p class="text-muted mb-0 small">Tambahkan lapisan keamanan ekstra untuk melindungi akun Anda</p>
                                </div>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#enable2faModal">
                                    <i class="fas fa-shield-alt me-1"></i> Aktifkan
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Sesi Aktif</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- Tambahkan di bagian Sesi Aktif -->
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Perangkat</th>
                                            <th>IP Address</th>
                                            <th>Lokasi</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <i class="fas fa-laptop text-primary me-2"></i>
                                                <?= $this->agent->browser() ?> (<?= $this->agent->platform() ?>)
                                            </td>
                                            <td><?= $current_ip ?></td>
                                            <td><?= $current_location ?></td>
                                            <td>Sekarang</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                        </tr>
                                        <?php if ($last_login_ip && $last_login_ip != $current_ip): ?>
                                            <tr>
                                                <td>
                                                    <i class="fas fa-desktop text-secondary me-2"></i>
                                                    Perangkat sebelumnya
                                                </td>
                                                <td><?= $last_login_ip ?></td>
                                                <td><?= $last_login_location ?></td>
                                                <td><?= date('d M Y H:i', strtotime($user->last_login)) ?></td>
                                                <td><span class="badge bg-secondary">Tidak aktif</span></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for 2FA -->
<div class="modal fade" id="enable2faModal" tabindex="-1" aria-labelledby="enable2faModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enable2faModalLabel">Aktifkan Verifikasi Dua Langkah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <?php if (isset($qrCodeUrl)): ?>
                            <img src="<?= $qrCodeUrl ?>" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                            <p class="mt-2 text-muted small"><?= $ga_secret ?></p>
                        <?php endif; ?>
                    </div>
                    <p>Pindai kode QR ini dengan aplikasi autentikator seperti Google Authenticator atau Authy</p>
                </div>

                <form action="<?= base_url('settings/enable_2fa') ?>" method="post">
                    <input type="hidden" name="secret" value="<?= $ga_secret ?>">
                    <div class="mb-3">
                        <label for="verificationCode" class="form-label">Kode Verifikasi</label>
                        <input type="text" class="form-control" name="code" id="verificationCode" placeholder="Masukkan kode 6 digit" required>
                        <div class="form-text">Masukkan kode 6 digit dari aplikasi autentikator Anda</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Verifikasi & Aktifkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Logout Semua Perangkat -->
<div class="modal fade" id="logoutAllModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan logout dari semua perangkat lain. Lanjutkan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= base_url('settings/logout_other_devices') ?>" class="btn btn-danger">Ya, Logout Semua</a>
            </div>
        </div>
    </div>
</div>