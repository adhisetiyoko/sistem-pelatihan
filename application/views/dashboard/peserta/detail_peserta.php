<div class="container-fluid py-4">
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex align-items-center">
                <div class="icon-circle bg-light-primary me-3">
                    <i class="fas fa-user text-primary fs-4"></i>
                </div>
                <div>
                    <h3 class="mb-0">Detail Peserta Pelatihan</h3>
                    <p class="mb-0 opacity-75">Informasi lengkap peserta pelatihan</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="avatar-lg bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center fs-1" style="width: 100px; height: 100px;">
                        <?= strtoupper(substr($peserta->nama_peserta, 0, 1)) ?>
                    </div>
                    <h5 class="mt-3 mb-1"><?= $peserta->nama_peserta ?></h5>
                    <small class="text-muted">ID: <?= $peserta->id_peserta ?></small>
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th style="width: 200px;">NIK</th>
                            <td>: <?= $peserta->nik_peserta ?></td>
                        </tr>
                        <tr>
                            <th>No Induk</th>
                            <td>: <?= $peserta->no_induk_peserta ?></td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>: <?= $peserta->nama_peserta ?></td>
                        </tr>
                        <tr>
                            <th>Modul Pelatihan</th>
                            <td>: <span class="badge bg-<?= 
                                ($peserta->modul_pelatihan == 'Pemrograman') ? 'info' : 
                                (($peserta->modul_pelatihan == 'Desain Grafis') ? 'warning' : 'success') 
                            ?>">
                                <?= $peserta->modul_pelatihan ?>
                            </span></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: <?= $peserta->alamat ?></td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td>: <?= $peserta->no_telp ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light text-end">
            <a href="<?= base_url('dashboard/peserta') ?>" class="btn btn-secondary px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<style>
    .avatar-lg {
        width: 100px;
        height: 100px;
        font-weight: bold;
        font-size: 2rem;
        line-height: 100px;
    }
    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%) !important;
    }
    .badge {
        padding: 6px 10px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        color: #495057;
    }
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
</style>
