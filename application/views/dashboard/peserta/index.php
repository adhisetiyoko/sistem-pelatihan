<!-- application/views/dashboard/peserta/index.php -->
<div class="container-fluid py-4">

    <div class="mb-4 d-flex justify-content-end">
        <div class="search-container position-relative">
            <form action="<?= base_url('dashboard/peserta') ?>" method="GET" class="w-100" id="searchForm">
                <div class="input-group search-wrapper shadow rounded-pill overflow-hidden">
                    <span class="input-group-text border-0 bg-white ps-3">
                        <i class="fas fa-search text-primary"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 py-2"
                        placeholder="Cari peserta..." aria-label="Search"
                        value="<?= html_escape($search ?? '') ?>" autocomplete="off">
                    <?php if (isset($search) && !empty($search)): ?>
                        <a href="<?= base_url('dashboard/peserta') ?>" class="btn clear-btn border-0">
                            <i class="fas fa-times text-muted"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
        <!-- Perubahan pada card-header dengan gradasi -->
        <div class="card-header bg-gradient-primary text-white py-3" style="border-radius: 15px 15px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light-primary me-3">
                        <i class="fas fa-users text-white fs-4"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">Data Peserta Pelatihan</h3>
                        <p class="mb-0 opacity-75">Daftar seluruh peserta pelatihan</p>
                    </div>
                </div>
                <a href="<?= base_url('dashboard/tambah_peserta') ?>" class="btn btn-light btn-rounded px-3 py-2">
                    <i class="fas fa-user-plus me-1"></i> Tambah Peserta
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 60px;">No</th>
                            <th>NIK</th>
                            <th>No Induk</th>
                            <th>Nama Peserta</th>
                            <th class="text-center">Modul</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 + ($this->uri->segment(3) ? $this->uri->segment(3) : 0); ?>
                        <?php foreach ($peserta as $p): ?>
                            <tr class="user-row hover-effect">
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $p->nik_peserta ?></td>
                                <td><?= $p->no_induk_peserta ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <?= strtoupper(substr($p->nama_peserta, 0, 1)) ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?= $p->nama_peserta ?></h6>
                                            <!-- <small class="text-muted ">ID: <?= $p->id_peserta ?></small> -->
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-<?= ($p->modul_pelatihan == 'Pemrograman') ? 'info' : (($p->modul_pelatihan == 'Desain Grafis') ? 'warning' : 'success')
                                                            ?>">
                                        <?= $p->modul_pelatihan ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('dashboard/edit_peserta/' . $p->id_peserta) ?>" class="btn btn-outline-primary px-3" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('dashboard/hapus_peserta/' . $p->id_peserta) ?>" class="btn btn-outline-danger px-3" title="Hapus" onclick="return confirm('Yakin ingin menghapus peserta ini?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <a href="<?= base_url('dashboard/detail_peserta/' . $p->id_peserta) ?>" class="btn btn-outline-info px-3" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex flex-wrap align-items-between">
                <!-- Teks info -->
                <div class="text-muted small">
                    Menampilkan <span id="showingCount"><?= count($peserta) ?></span> dari <?= $this->Peserta_model->count_all() ?> peserta
                </div>
                <!-- Pagination -->
                <nav class="ms-auto" aria-label="Page navigation">
                    <?= $pagination ?>
                </nav>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tambahkan gradasi ke CSS */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%) !important;

    }

    /* Update warna icon circle */
    .icon-circle.bg-light-primary {
        background-color: rgba(255, 255, 255, 0.2) !important;
    }

    /* Warna teks untuk card header */
    .card-header.bg-gradient-primary h3,
    .card-header.bg-gradient-primary p {
        color: white !important;
    }

    /* Warna ikon dalam card header */
    .card-header.bg-gradient-primary .icon-circle i {
        color: white !important;
    }

    /* Tombol light dalam card header */
    .card-header.bg-gradient-primary .btn-light {
        background-color: rgba(255, 255, 255, 0.9) !important;
        color: #3a7bd5 !important;
        transition: all 0.3s ease;
    }

    .card-header.bg-gradient-primary .btn-light:hover {
        background-color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Styling untuk elemen yang sudah ada */
    .avatar-sm {
        width: 36px;
        height: 36px;
        line-height: 36px;
        font-weight: bold;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #495057;
    }

    .table td {
        vertical-align: middle;
    }

    .badge {
        padding: 6px 10px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-light-primary {
        background-color: rgba(58, 123, 213, 0.15);
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-rounded {
        border-radius: 50px;
        padding: 8px 20px;
    }

    .btn-outline-primary {
        color: #3a7bd5;
        border-color: #3a7bd5;
    }

    .btn-outline-primary:hover {
        background-color: #3a7bd5;
        color: white;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    .btn-outline-info {
        color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-outline-info:hover {
        background-color: #17a2b8;
        color: white;
    }

    .btn-light {
        background-color: white;
        color: #3a7bd5;
    }

    .btn-light:hover {
        background-color: #f8f9fa;
    }

    /* Styling untuk pencarian yang diperbarui */
    .search-container {
        width: 300px;
        transition: all 0.3s ease;
    }

    .search-container:focus-within {
        width: 350px;
    }

    .search-wrapper {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .search-container:focus-within .search-wrapper {
        box-shadow: 0 0.3rem 0.8rem rgba(58, 123, 213, 0.15) !important;
        border-color: rgba(58, 123, 213, 0.2);
    }

    #liveSearch {
        height: 46px;
        font-size: 0.95rem;
        padding-left: 0.25rem;
        background-color: transparent;
    }

    #liveSearch:focus {
        box-shadow: none;
    }

    .clear-btn {
        width: 46px;
        border-radius: 0;
        background: transparent;
        opacity: 0;
        pointer-events: none;
        transition: all 0.2s ease;
    }

    .search-container.has-value .clear-btn {
        opacity: 1;
        pointer-events: all;
    }

    .clear-btn:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }

    .clear-btn:active {
        background-color: rgba(0, 0, 0, 0.05);
    }

    /* Animasi pencarian */
    @keyframes searchPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(58, 123, 213, 0.4);
        }

        70% {
            box-shadow: 0 0 0 5px rgba(58, 123, 213, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(58, 123, 213, 0);
        }
    }

    .search-pulse {
        animation: searchPulse 1.5s infinite;
    }

    /* Efek hover pada baris tabel */
    .hover-effect {
        transition: background-color 0.2s ease;
    }

    .hover-effect:hover,
    .hover-highlight {
        background-color: rgba(58, 123, 213, 0.05);
    }

    .search-btn {
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background-color: #2a6cd5 !important;
    }
</style>

<!-- // Ganti script yang ada dengan ini -->
<script>
    $(document).ready(function() {
        var searchTimer;

        // Tangani input live search
        $('input[name="search"]').on('input', function() {
            var searchTerm = $(this).val().trim();

            // Toggle clear button
            if (searchTerm.length > 0) {
                $('.search-container').addClass('has-value');
            } else {
                $('.search-container').removeClass('has-value');
                // Jika search kosong, reload halaman
                window.location.href = '<?= base_url('dashboard/peserta') ?>';
                return;
            }

            // Clear timer sebelumnya
            clearTimeout(searchTimer);

            // Set timer baru (debounce 300ms)
            searchTimer = setTimeout(function() {
                performLiveSearch(searchTerm);
            }, 300);
        });

        // Fungsi untuk melakukan live search via AJAX
        function performLiveSearch(searchTerm) {
            $.ajax({
                url: '<?= base_url('dashboard/peserta_ajax') ?>',
                type: 'GET',
                data: {
                    search: searchTerm
                },
                beforeSend: function() {
                    // Tampilkan loading indicator
                    $('tbody').html('<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></td></tr>');
                },
                success: function(response) {
                    $('tbody').html(response);
                },
                error: function() {
                    $('tbody').html('<tr><td colspan="6" class="text-center text-danger py-4">Gagal memuat data</td></tr>');
                }
            });
        }

        // Handle clear button click
        $('.clear-btn').on('click', function(e) {
            e.preventDefault();
            $('input[name="search"]').val('');
            $('.search-container').removeClass('has-value');
            window.location.href = '<?= base_url('dashboard/peserta') ?>';
        });
    });
</script>