<!-- application\views\dashboard\peserta\tambah.php -->
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-light-primary me-3">
                            <i class="fas fa-user-plus text-primary fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">Tambah Peserta Pelatihan</h3>
                            <p class="mb-0 opacity-75">Tambahkan data peserta pelatihan baru</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="alert alert-danger alert-dismissible fade show d-none" id="api-error-alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2 fs-4"></i>
                            <div>
                                <h5 class="alert-heading mb-1">Perhatian!</h5>
                                <p class="mb-0">Gagal memuat data wilayah. Menggunakan data default.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <?php echo form_open('dashboard/tambah_peserta', ['class' => 'needs-validation', 'novalidate' => '']); ?>
                    <div class="row g-4">

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <!-- NIK Peserta -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="nik_peserta"
                                    class="form-control form-control-lg <?= form_error('nik_peserta') ? 'is-invalid' : '' ?>" id="nik_peserta"
                                    placeholder="NIK Peserta" required
                                    value="<?= isset($form_data['nik_peserta']) ? html_escape($form_data['nik_peserta']) : '' ?>">
                                <label for="nik_peserta"><i class="fas fa-id-card me-2"></i>NIK Peserta</label>
                                <?= form_error('nik_peserta', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                        </div>

                        <!-- No Induk Peserta -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="no_induk_peserta"
                                    class="form-control form-control-lg <?= form_error('no_induk_peserta') ? 'is-invalid' : '' ?>"
                                    id="no_induk_peserta" placeholder="No Induk Peserta" required
                                    value="<?= isset($form_data['no_induk_peserta']) ? html_escape($form_data['no_induk_peserta']) : '' ?>">
                                <label for="no_induk_peserta"><i class="fas fa-hashtag me-2"></i>No Induk Peserta</label>
                                <?= form_error('no_induk_peserta', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                        </div>

                        <!-- Nama Peserta -->
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="text" name="nama_peserta"
                                    class="form-control form-control-lg <?= form_error('nama_peserta') ? 'is-invalid' : '' ?>"
                                    id="nama_peserta" placeholder="Nama Peserta" required
                                    value="<?= isset($form_data['nama_peserta']) ? html_escape($form_data['nama_peserta']) : '' ?>">
                                <label for="nama_peserta"><i class="fas fa-user me-2"></i>Nama Peserta</label>
                                <?= form_error('nama_peserta', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select name="jenis_kelamin_id"
                                    class="form-select form-select-lg <?= form_error('jenis_kelamin_id') ? 'is-invalid' : '' ?>"
                                    id="jenis_kelamin" required>
                                    <option value="" disabled <?= !isset($form_data['jenis_kelamin_id']) || $form_data['jenis_kelamin_id'] == '' ? 'selected' : '' ?>>
                                        Pilih Jenis Kelamin
                                    </option>
                                    <option value="Laki-laki" <?= isset($form_data['jenis_kelamin_id']) && $form_data['jenis_kelamin_id'] == 'Laki-laki' ? 'selected' : '' ?>>
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan" <?= isset($form_data['jenis_kelamin_id']) && $form_data['jenis_kelamin_id'] == 'Perempuan' ? 'selected' : '' ?>>
                                        Perempuan
                                    </option>
                                </select>
                                <label for="jenis_kelamin"><i class="fas fa-venus-mars me-2"></i>Jenis Kelamin</label>
                                <?= form_error('jenis_kelamin_id', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                        </div>

                        <!-- Tempat Lahir -->
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" name="tempat_lahir"
                                    class="form-control form-control-lg <?= form_error('tempat_lahir') ? 'is-invalid' : '' ?>"
                                    id="tempat_lahir" placeholder="Tempat Lahir" required
                                    value="<?= isset($form_data['tempat_lahir']) ? html_escape($form_data['tempat_lahir']) : '' ?>">
                                <label for="tempat_lahir"><i class="fas fa-map-marker-alt me-2"></i>Tempat Lahir</label>
                                <?= form_error('tempat_lahir', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="date" name="tanggal_lahir"
                                    class="form-control form-control-lg <?= form_error('tanggal_lahir') ? 'is-invalid' : '' ?>"
                                    id="tanggal_lahir" required
                                    value="<?= isset($form_data['tanggal_lahir']) ? html_escape($form_data['tanggal_lahir']) : '' ?>">
                                <label for="tanggal_lahir"><i class="fas fa-calendar-alt me-2"></i>Tanggal Lahir</label>
                                <?= form_error('tanggal_lahir', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                        </div>

                        <!-- No Telepon -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="tel" name="no_telp"
                                    class="form-control form-control-lg <?= form_error('no_telp') ? 'is-invalid' : '' ?>"
                                    pattern="^08\d{8,12}$" id="no_telp" placeholder="No Telepon" required
                                    value="<?= isset($form_data['no_telp']) ? html_escape($form_data['no_telp']) : '' ?>">
                                <label for="no_telp"><i class="fas fa-phone me-2"></i>No Telepon</label>
                                <?= form_error('no_telp', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                        </div>

                        <!-- Modul Pelatihan -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="id_modul"
                                    class="form-select form-select-lg <?= form_error('id_modul') ? 'is-invalid' : '' ?>"
                                    id="modul_pelatihan" required>
                                    <option value="" disabled selected>Pilih Modul Pelatihan</option>
                                    <option value="1" <?= (isset($form_data['id_modul']) && $form_data['id_modul'] == '1') ? 'selected' : '' ?>>Pemrograman</option>
                                    <option value="2" <?= (isset($form_data['id_modul']) && $form_data['id_modul'] == '2') ? 'selected' : '' ?>>Desain Grafis</option>
                                    <option value="3" <?= (isset($form_data['id_modul']) && $form_data['id_modul'] == '3') ? 'selected' : '' ?>>Animasi</option>
                                </select>
                                <label for="modul_pelatihan"><i class="fas fa-book me-2"></i>Modul Pelatihan</label>
                                <?= form_error('id_modul', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <textarea name="alamat"
                                    class="form-control form-control-lg <?= form_error('alamat') ? 'is-invalid' : '' ?>"
                                    id="alamat" placeholder="Alamat" style="height: 120px" required><?= isset($form_data['alamat']) ? html_escape($form_data['alamat']) : '' ?></textarea>
                                <label for="alamat"><i class="fas fa-map-marked-alt me-2"></i>Alamat Lengkap</label>
                                <?= form_error('alamat', '<div class="text-danger small mt-1">', '</div>') ?>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="col-12 mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo base_url('dashboard/peserta'); ?>" class="btn btn-outline-secondary px-4 py-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    <i class="fas fa-save me-2"></i>Simpan Data
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
    /* Tambahkan di bagian style */
    .text-danger small {
        display: block;
        margin-top: 0.25rem;
        font-size: 0.875em;
    }

    .is-invalid {
        border-color: #dc3545 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .is-valid {
        border-color: #198754 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

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

    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 0;
        background: white;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .ui-menu-item {
        padding: 8px 12px;
        cursor: pointer;
    }

    .ui-menu-item:hover {
        background-color: #f8f9fa;
    }

    .ui-state-active {
        background-color: #3a7bd5 !important;
        color: white !important;
        border: none !important;
    }

    /* Loading indicator */
    .loading-autocomplete {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%233a7bd5"><path d="M12 2a10 10 0 1 0 10 10h-2a8 8 0 1 1-8-8V2z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
    }
</style>

<script>
    $(document).ready(function() {
        const fallbackCities = [
            "KABUPATEN TEMANGGUNG", "KABUPATEN MAGELANG", "KABUPATEN SEMARANG", "KOTA SURAKARTA", "KOTA SALATIGA",
            "KOTA PEKALONGAN", "KOTA TEGAL", "KABUPATEN BREBES", "KABUPATEN CILACAP", "KABUPATEN BANYUMAS",
            "KABUPATEN PURBALINGGA", "KABUPATEN BANJARNEGARA", "KABUPATEN KEBUMEN", "KABUPATEN PURWOREJO", "KABUPATEN WONOSOBO",
            "KABUPATEN KENDAL", "KABUPATEN BATANG", "KABUPATEN PATI", "KABUPATEN KUDUS", "KABUPATEN JEPARA",
            "KABUPATEN DEMAK", "KABUPATEN GROBOGAN", "KABUPATEN BLORA", "KABUPATEN REMBANG", "KABUPATEN SRAGEN",
            "KABUPATEN BOYOLALI", "KABUPATEN KLATEN", "KABUPATEN SUKOHARJO", "KABUPATEN WONOGIRI", "KABUPATEN KARANGANYAR"
        ];

        // Simpan fallback ke cache awal jika tidak tersedia
        if (!localStorage.getItem('jawaTengahCities')) {
            localStorage.setItem('jawaTengahCities', JSON.stringify(fallbackCities));
        }

        // Inisialisasi autocomplete tempat lahir
        $("#tempat_lahir").autocomplete({
            source: function(request, response) {
                const cachedData = localStorage.getItem('jawaTengahCities');
                const cacheTime = localStorage.getItem('jawaTengahCities_time');
                const isCacheValid = cacheTime && (Date.now() - cacheTime < 86400000);

                if (cachedData && isCacheValid) {
                    console.log("Menggunakan data cache");
                    response(filterCities(JSON.parse(cachedData), request.term));
                    return;
                }

                const fetchTimeout = setTimeout(() => {
                    console.warn("Timeout - menggunakan fallback");
                    response(filterCities(fallbackCities, request.term));
                }, 3000);

                fetch('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/33.json')
                    .then(res => {
                        if (!res.ok) throw new Error(res.statusText);
                        return res.json();
                    })
                    .then(data => {
                        clearTimeout(fetchTimeout);
                        // Ubah format data menjadi huruf kapital semua
                        const cities = normalizeCitiesToUppercase(data.map(item => item.name));
                        localStorage.setItem('jawaTengahCities', JSON.stringify(cities));
                        localStorage.setItem('jawaTengahCities_time', Date.now());
                        console.log("Data dari API berhasil dimuat");
                        response(filterCities(cities, request.term));
                    })
                    .catch(err => {
                        clearTimeout(fetchTimeout);
                        console.error("Gagal fetch API:", err);
                        $("#api-error-alert").removeClass('d-none');
                        response(filterCities(fallbackCities, request.term));
                    });
            },
            minLength: 2,
            delay: 500,
            search: function() {
                $(this).addClass('loading-autocomplete');
            },
            response: function() {
                $(this).removeClass('loading-autocomplete');
            },
            close: function() {
                $(this).removeClass('loading-autocomplete');
            },
            select: function(event, ui) {
                $(this)
                    .val(ui.item.value)
                    .removeClass('is-invalid')
                    .addClass('is-valid');
                return false;
            }
        });

        // Fungsi filter nama kota/kabupaten
        function filterCities(cities, term) {
            if (!cities || !term) return [];
            const termUpper = term.toUpperCase().trim();
            return cities
                .filter(city => city && city.includes(termUpper))
                .slice(0, 15);
        }

        // Normalisasi: uppercase dan hilangkan duplikat
        function normalizeCitiesToUppercase(cities) {
            const seen = new Set();

            return cities
                .map(name => {
                    let cleanName = name.trim().toUpperCase();

                    if (cleanName.startsWith("KABUPATEN ")) {
                        return cleanName;
                    } else if (cleanName.startsWith("KOTA ")) {
                        return cleanName;
                    } else if (cleanName.toLowerCase().startsWith("kabupaten ")) {
                        return "KABUPATEN " + cleanName.substring(10).toUpperCase();
                    } else if (cleanName.toLowerCase().startsWith("kota ")) {
                        return "KOTA " + cleanName.substring(5).toUpperCase();
                    } else {
                        // fallback: tambahkan "KABUPATEN" di depan
                        return "KABUPATEN " + cleanName;
                    }
                })
                .filter(city => {
                    const key = city;
                    if (seen.has(key)) return false;
                    seen.add(key);
                    return true;
                });
        }

        // Validasi form bawaan Bootstrap
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                const forms = document.getElementsByClassName('needs-validation');
                Array.prototype.forEach.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
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