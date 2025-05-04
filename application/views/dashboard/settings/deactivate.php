<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Nonaktifkan Akun</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-circle me-2"></i>Peringatan!</h6>
                        <p class="mb-0">Dengan menonaktifkan akun, Anda tidak akan bisa login lagi sampai diaktifkan oleh admin.</p>
                    </div>

                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <?= form_open('dashboard/settings/deactivate') ?>
                        <div class="mb-3">
                            <label for="confirmation" class="form-label">Konfirmasi</label>
                            <input type="text" class="form-control" name="confirmation" id="confirmation" 
                                   placeholder="Ketik NONAKTIFKAN" required>
                            <small class="form-text text-muted">Ketik "NONAKTIFKAN" (huruf besar semua) untuk konfirmasi</small>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Anda</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-ban me-2"></i> Nonaktifkan Akun
                            </button>
                            <a href="<?= site_url('dashboard/settings') ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>