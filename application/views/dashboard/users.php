<!-- application/views/dashboard/users.php -->
<div class="container-fluid py-4">

    <div class="mb-4 d-flex justify-content-end">
        <div class="search-container position-relative">
            <!-- Ganti form search dengan ini -->
            <form action="<?= base_url('dashboard/users') ?>" method="GET" class="w-100" id="searchForm">
                <div class="input-group search-wrapper shadow rounded-pill overflow-hidden">
                    <span class="input-group-text border-0 bg-white ps-3">
                        <i class="fas fa-search text-primary"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 py-2"
                        placeholder="Cari pengguna..." aria-label="Search"
                        value="<?= html_escape($search ?? '') ?>" autocomplete="off">
                    <?php if (isset($search) && !empty($search)): ?>
                        <a href="<?= base_url('dashboard/users') ?>" class="btn clear-btn border-0">
                            <i class="fas fa-times text-muted"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-gradient-primary text-white py-3" style="border-radius: 15px 15px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light-primary me-3">
                        <i class="fas fa-users text-primary fs-4"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">Manajemen Pengguna Sistem</h3>
                        <p class="mb-0 opacity-75">Kelola semua akses pengguna aplikasi</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 60px;">No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th class="text-center" style="width: 150px;">Status</th>
                            <th class="text-center">Terakhir Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 + (($this->input->get('page') ? ($this->input->get('page') - 1) * $config['per_page'] : 0)); ?>
                        <?php foreach ($users as $u): ?>

                            <tr class="user-row hover-effect">
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <?= strtoupper(substr($u->username, 0, 1)) ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?= htmlspecialchars($u->username) ?></h6>
                                            <small class="text-muted">ID: <?= $u->id ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($u->email) ?></td>
                                <td class="text-center">
                                    <?php $status = get_user_status($u); ?>
                                    <span class="badge bg-<?= $status['class'] ?>">
                                        <?= $status['text'] ?>
                                    </span>
                                    <small class="d-block text-muted mt-1">
                                        <?= $status['detail'] ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">
                                        <?= $u->last_login ? date('d M Y H:i', strtotime($u->last_login)) : 'Belum pernah login' ?>
                                    </small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-light">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="text-muted small">
                    Menampilkan <span id="showingCount"><?= count($users) ?></span> dari <?= $total_rows ?> pengguna
                </div>
                <?php if ($total_rows > $config['per_page']): ?>
                    <nav aria-label="Page navigation">
                        <?= $pagination ?>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%) !important;
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

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    /* Styling untuk pencarian yang diperbarui - Tanpa dropdown */
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
</style>

<!-- // Ganti script yang ada dengan ini -->
<script>
    $(document).ready(function() {
        var searchTimer;

        // Tangani input live search
        $('input[name="search"]').on('input', function() {
            var searchTerm = $(this).val().trim();

            if (searchTerm.length > 0) {
                $('.search-container').addClass('has-value');
                performLiveSearch(searchTerm, 1); // Reset ke page 1 saat search baru
            } else {
                $('.search-container').removeClass('has-value');
                window.location.href = '<?= base_url('dashboard/users') ?>';
            }
        });

        // Fungsi untuk melakukan live search via AJAX
        function performLiveSearch(searchTerm, page = 1) {
            $.ajax({
                url: '<?= base_url('dashboard/users_ajax') ?>',
                type: 'GET',
                data: {
                    search: searchTerm,
                    page: page
                },
                beforeSend: function() {
                    $('tbody').html('<tr><td colspan="5" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></td></tr>');
                },
                success: function(response) {
                    $('tbody').html(response);
                },
                error: function() {
                    $('tbody').html('<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat data</td></tr>');
                    $('#showingCount').text(0);
                }
            });
        }

        // Handle clear button click
        $('.clear-btn').on('click', function(e) {
            e.preventDefault();
            $('input[name="search"]').val('').trigger('input');
        });

        // Initialize pagination
        initPagination(<?= $total_rows ?>);

        function initPagination(total) {
            $(".pagination").pagination({
                items: total,
                itemsOnPage: <?= $config['per_page'] ?>,
                currentPage: <?= ($this->input->get('page') ?: 1) ?>,
                cssStyle: "light-theme",
                hrefTextPrefix: "<?= site_url('dashboard/users?search=' . urlencode($search ?? '') . '&page=') ?>",
                onPageClick: function(pageNum) {
                    performLiveSearch($('input[name="search"]').val(), pageNum);
                }
            });
        }
    });
</script>