<!-- application/views/dashboard/index.php -->
<div class="container py-4">
    <h2 class="text-center mb-4 fw-bold text-primary">Selamat Datang di Sistem Informasi Pelatihan</h2>

    <div class="row g-4">
        <!-- Card Peserta Pelatihan -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-lg h-100 hover-effect" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users me-2"></i> Peserta Pelatihan
                        </h5>
                        <i class="fas fa-chart-line fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-body text-center py-4">
                    <h2 class="display-5 fw-bold text-primary mb-3"><?= number_format($this->Peserta_model->count_all()) ?></h2>
                    <p class="text-muted">Total peserta terdaftar</p>
                    <a href="<?= base_url('dashboard/peserta') ?>" class="btn btn-outline-primary btn-rounded mt-2">
                        <i class="fas fa-list me-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Pengguna Sistem -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-lg h-100 hover-effect" style="border-radius: 15px;">
                <div class="card-header bg-success text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-shield me-2"></i> Pengguna Sistem
                        </h5>
                        <i class="fas fa-user-cog fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-body text-center py-4">
                    <h2 class="display-5 fw-bold text-success mb-3"><?= number_format(count($this->User_model->get_all_users())) ?></h2>
                    <p class="text-muted">Total pengguna terdaftar</p>
                    <a href="<?= base_url('dashboard/users') ?>" class="btn btn-outline-success btn-rounded mt-2">
                        <i class="fas fa-list me-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Card Tambahan (Opsional) -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-lg h-100 hover-effect" style="border-radius: 15px;">
                <div class="card-header bg-info text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-check me-2"></i> Aktivitas Terbaru
                        </h5>
                        <i class="fas fa-bell fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-body text-center py-4">
                    <h2 class="display-5 fw-bold text-info mb-3"><?= date('d M Y') ?></h2>
                    <p class="text-muted">Sistem terakhir diperbarui</p>
                    <button class="btn btn-outline-info btn-rounded mt-2">
                        <i class="fas fa-sync-alt me-1"></i> Perbarui
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .btn-rounded {
        border-radius: 50px;
        padding: 8px 20px;
    }

    .card {
        overflow: hidden;
    }
</style>