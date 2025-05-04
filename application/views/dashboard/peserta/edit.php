<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-light-primary me-3">
                            <i class="fas fa-user-edit text-primary fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">Edit Peserta Pelatihan</h3>
                            <p class="mb-0 opacity-75">Perbarui data peserta pelatihan</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2 fs-4"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">Perhatian!</h5>
                                    <p class="mb-0">Terdapat kesalahan dalam pengisian form.</p>
                                    <?php echo validation_errors(); ?>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open('dashboard/edit_peserta/' . $peserta->id_peserta, ['class' => 'needs-validation', 'novalidate' => '']); ?>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="nik_peserta" class="form-control form-control-lg" id="nik_peserta"
                                    placeholder="NIK Peserta" value="<?php echo set_value('nik_peserta', $peserta->nik_peserta); ?>" required>
                                <label for="nik_peserta" class="text-muted">
                                    <i class="fas fa-id-card me-2"></i>NIK Peserta
                                </label>
                                <div class="invalid-feedback">Harap isi NIK peserta</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="no_induk_peserta" class="form-control form-control-lg" id="no_induk_peserta"
                                    placeholder="No Induk Peserta" value="<?php echo set_value('no_induk_peserta', $peserta->no_induk_peserta); ?>" required>
                                <label for="no_induk_peserta" class="text-muted">
                                    <i class="fas fa-hashtag me-2"></i>No Induk Peserta
                                </label>
                                <div class="invalid-feedback">Harap isi nomor induk</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="text" name="nama_peserta" class="form-control form-control-lg" id="nama_peserta"
                                    placeholder="Nama Peserta" value="<?php echo set_value('nama_peserta', $peserta->nama_peserta); ?>" required>
                                <label for="nama_peserta" class="text-muted">
                                    <i class="fas fa-user me-2"></i>Nama Peserta
                                </label>
                                <div class="invalid-feedback">Harap isi nama peserta</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select name="jenis_kelamin_id" class="form-select form-select-lg" id="jenis_kelamin" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" <?php echo set_select('jenis_kelamin_id', 'Laki-laki', ($peserta->jenis_kelamin_id == 'Laki-laki')); ?>>Laki-laki</option>
                                    <option value="Perempuan" <?php echo set_select('jenis_kelamin_id', 'Perempuan', ($peserta->jenis_kelamin_id == 'Perempuan')); ?>>Perempuan</option>
                                </select>
                                <label for="jenis_kelamin" class="text-muted">
                                    <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin
                                </label>
                                <div class="invalid-feedback">Harap pilih jenis kelamin</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" name="tempat_lahir" class="form-control form-control-lg" id="tempat_lahir"
                                    placeholder="Tempat Lahir" value="<?php echo set_value('tempat_lahir', $peserta->tempat_lahir); ?>" required>
                                <label for="tempat_lahir" class="text-muted">
                                    <i class="fas fa-map-marker-alt me-2"></i>Tempat Lahir
                                </label>
                                <div class="invalid-feedback">Harap isi tempat lahir</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="date" name="tanggal_lahir" class="form-control form-control-lg" id="tanggal_lahir"
                                    value="<?php echo set_value('tanggal_lahir', $peserta->tanggal_lahir); ?>" required>
                                <label for="tanggal_lahir" class="text-muted">
                                    <i class="fas fa-calendar-alt me-2"></i>Tanggal Lahir
                                </label>
                                <div class="invalid-feedback">Harap isi tanggal lahir</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="tel" name="no_telp" class="form-control form-control-lg" id="no_telp"
                                    placeholder="No Telepon" value="<?php echo set_value('no_telp', $peserta->no_telp); ?>" required>
                                <label for="no_telp" class="text-muted">
                                    <i class="fas fa-phone me-2"></i>No Telepon
                                </label>
                                <div class="invalid-feedback">Harap isi nomor telepon</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="id_modul" class="form-select form-select-lg" id="id_modul" required>
                                    <option value="" disabled selected>Pilih Modul Pelatihan</option>
                                    <option value="1" <?php echo set_select('id_modul', '1', ($peserta->id_modul == '1')); ?>>Pemrograman</option>
                                    <option value="2" <?php echo set_select('id_modul', '2', ($peserta->id_modul == '2')); ?>>Desain Grafis</option>
                                    <option value="3" <?php echo set_select('id_modul', '3', ($peserta->id_modul == '3')); ?>>Animasi</option>
                                </select>
                                <label for="id_modul" class="text-muted">
                                    <i class="fas fa-book me-2"></i>Modul Pelatihan
                                </label>
                                <div class="invalid-feedback">Harap pilih modul pelatihan</div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <textarea name="alamat" class="form-control form-control-lg" id="alamat"
                                    placeholder="Alamat" style="height: 120px" required><?php echo set_value('alamat', $peserta->alamat); ?></textarea>
                                <label for="alamat" class="text-muted">
                                    <i class="fas fa-map-marked-alt me-2"></i>Alamat Lengkap
                                </label>
                                <div class="invalid-feedback">Harap isi alamat</div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo base_url('dashboard/peserta'); ?>" class="btn btn-outline-secondary px-4 py-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%) !important;
    }

    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control-lg,
    .form-select-lg {
        padding: 1rem 1.25rem;
        font-size: 1rem;
    }

    .form-floating label {
        padding: 1rem 1.25rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3a7bd5;
        box-shadow: 0 0 0 0.25rem rgba(58, 123, 213, 0.25);
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }

    .btn-primary {
        background-color: #3a7bd5;
        border-color: #3a7bd5;
    }

    .btn-primary:hover {
        background-color: #2c5fb3;
        border-color: #2c5fb3;
    }

    .alert {
        border-radius: 8px;
    }
</style>

<script>
    $(document).ready(function() {
        // Data fallback jika API tidak tersedia
        const fallbackCities = [
            "Temanggung", "Magelang", "Semarang", "Surakarta", "Salatiga",
            "Pekalongan", "Tegal", "Brebes", "Cilacap", "Banyumas",
            "Purbalingga", "Banjarnegara", "Kebumen", "Purworejo", "Wonosobo",
            "Kendal", "Batang", "Pati", "Kudus", "Jepara",
            "Demak", "Grobogan", "Blora", "Rembang", "Sragen",
            "Boyolali", "Klaten", "Sukoharjo", "Wonogiri", "Karanganyar"
        ];

        // Inisialisasi autocomplete untuk tempat lahir
        $("#tempat_lahir").autocomplete({
            source: function(request, response) {
                // Cek cache di localStorage
                const cachedCities = localStorage.getItem('jawaTengahCities');
                if (cachedCities) {
                    const filteredCities = filterCities(JSON.parse(cachedCities), request.term);
                    response(filteredCities);
                    return;
                }

                // Jika belum ada di cache, ambil dari API
                fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/33.json`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(regencies => {
                        const cityNames = regencies.map(regency => regency.name);
                        // Simpan ke localStorage untuk penggunaan berikutnya
                        localStorage.setItem('jawaTengahCities', JSON.stringify(cityNames));
                        response(filterCities(cityNames, request.term));
                    })
                    .catch(error => {
                        console.error("Error fetching cities:", error);
                        // Tampilkan pesan error
                        document.getElementById('api-error-alert').classList.remove('d-none');
                        // Gunakan data fallback
                        response(filterCities(fallbackCities, request.term));
                    });
            },
            minLength: 2,
            delay: 300,
            select: function(event, ui) {
                // Validasi manual untuk Bootstrap
                $(this).removeClass('is-invalid').addClass('is-valid');
                // Set nilai ke input
                $(this).val(ui.item.value);
            }
        });

        // Fungsi untuk memfilter kota berdasarkan input
        function filterCities(cities, term) {
            const termLower = term.toLowerCase();
            return cities.filter(city =>
                    city.toLowerCase().includes(termLower))
                .slice(0, 15); // Batasi 15 hasil
        }

        // Validasi form
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
    });
</script>