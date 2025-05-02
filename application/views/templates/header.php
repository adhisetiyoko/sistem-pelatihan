<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Sistem Pelatihan</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #3a7bd5;
            --primary-dark: #2a6cd5;
            --secondary-color: #f8f9fc;
            --accent-color: #f6c23e;
            --text-dark: #5a5c69;
            --text-light: #858796;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --info-color: #36b9cc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
            color: var(--text-dark);
        }
        
        /* Modern Navbar with Gradient */
        .navbar {
            
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%) !important;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
            padding: 0.8rem 1rem;
            border: none;
        }
        
        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            color: white !important;
        }
        
        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.15rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        .nav-link:hover, 
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white !important;
        }
        
        .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }
        
        /* User dropdown */
        .user-dropdown {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            color: white;
            font-weight: 600;
        }
        
        .user-name {
            color: white;
            font-weight: 500;
            margin-right: 0.5rem;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }
        
        .dropdown-divider {
            margin: 0.25rem 0;
            border-color: rgba(0, 0, 0, 0.05);
        }
        
        /* Buttons */
        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-light:hover {
            background-color: white;
            color: var(--primary-color);
            border-color: white;
        }
        
        /* Active menu item style */
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
            font-weight: 600;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .navbar-collapse {
                padding: 1rem 0;
            }
            
            .nav-link {
                margin: 0.25rem 0;
                padding: 0.75rem 1rem;
            }
            
            .d-flex {
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>

<body>
    <?php
    // Get current segment
    $current_segment = $this->uri->segment(1);
    if ($current_segment === 'dashboard') {
        $current_segment = $this->uri->segment(2) ? $this->uri->segment(2) : 'dashboard';
    }
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-graduation-cap me-2"></i>
                <span>Sistem Pelatihan</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if ($this->session->userdata('logged_in')): ?>
                    <!-- Menu for logged in users -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= is_menu_active('dashboard', $current_segment) ?>" href="<?= base_url('dashboard') ?>">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= is_menu_active('peserta', $current_segment) ?>" href="<?= base_url('dashboard/peserta') ?>">
                                <i class="fas fa-users"></i> Peserta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= is_menu_active('users', $current_segment) ?>" href="<?= base_url('dashboard/users') ?>">
                                <i class="fas fa-user-cog"></i> Pengguna
                            </a>
                        </li>
                    </ul>
                    
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <div class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    <?= strtoupper(substr($this->session->userdata('username'), 0, 1)) ?>
                                </div>
                                <span class="user-name d-none d-lg-inline"><?= $this->session->userdata('username') ?></span>
                                <i class="fas fa-chevron-down text-white-50 d-none d-lg-inline"></i>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Akun</h6></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i> Profil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Pengaturan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Menu for guests -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= is_menu_active('auth', $current_segment) ?>" href="<?= base_url('auth') ?>">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= is_menu_active('register', $current_segment) ?>" href="<?= base_url('auth/register') ?>">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <div><?= $this->session->flashdata('success') ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div><?= $this->session->flashdata('error') ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>