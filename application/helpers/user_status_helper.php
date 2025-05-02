<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * USER STATUS HELPER
 * 
 * Helper untuk menentukan status pengguna berdasarkan aktivitas terakhir
 * 
 * @author     Your Name <your.email@example.com>
 * @version    1.1
 * @last_modified 2023-11-15
 */

// Konstanta waktu untuk status user
define('STATUS_ONLINE_THRESHOLD', 60);      // 1 menit (dianggap masih online)
define('STATUS_RECENT_THRESHOLD', 300);     // 5 menit (dianggap baru offline)
define('STATUS_HOUR_THRESHOLD', 3600);      // 1 jam (dianggap offline < 1 hari)
define('STATUS_DAY_THRESHOLD', 86400);      // 1 hari (dianggap offline lama)
define('TIME_FORMAT', 'H:i');               // Format waktu pendek
define('DATE_FORMAT', 'd M Y');             // Format tanggal pendek

/**
 * Fungsi untuk parsing tanggal dengan error handling
 * 
 * @param string|null $dateString String tanggal dari database
 * @param DateTimeZone $timezone Timezone yang digunakan
 * @return DateTime|null Objek DateTime atau null jika gagal
 */
if (!function_exists('safe_date_parse')) {
    function safe_date_parse($dateString, $timezone)
    {
        // Jika data kosong atau null, return null
        if (empty($dateString)) {
            return null;
        }

        try {
            // Coba parsing tanggal
            $date = new DateTime($dateString, $timezone);
            
            // Validasi tahun (jangan terima tahun < 1970 atau > 2100)
            $year = (int)$date->format('Y');
            if ($year < 1970 || $year > 2100) {
                throw new Exception("Tahun tidak valid: {$year}");
            }
            
            return $date;
        } catch (Exception $e) {
            log_message('error', 'Gagal parsing tanggal: ' . $dateString . ' - ' . $e->getMessage());
            return null;
        }
    }
}

/**
 * Fungsi utama untuk mendapatkan status user
 * 
 * @param object|array $user Data user dari database
 * @return array Format: ['class' => string, 'text' => string, 'detail' => string]
 */
if (!function_exists('get_user_status')) {
    function get_user_status($user)
    {
        // Validasi input dasar
        if (empty($user)) {
            return invalid_status_response('Data user kosong');
        }

        // Konversi array ke object jika perlu
        if (is_array($user)) {
            $user = (object)$user;
        }

        if (!is_object($user)) {
            return invalid_status_response('Tipe data user tidak valid');
        }

        try {
            // Setup timezone
            $timezone = get_system_timezone();
            $now = new DateTime('now', $timezone);

            // Cek status aktif user
            if (!property_exists($user, 'is_active') || !$user->is_active) {
                return [
                    'class'  => 'danger',
                    'text'   => 'Nonaktif',
                    'detail' => 'Akun dinonaktifkan',
                    'icon'   => 'fa-user-slash'
                ];
            }

            // Parse waktu-waktu penting dengan safe method
            $last_login = safe_date_parse($user->last_login ?? null, $timezone);
            $last_logout = safe_date_parse($user->last_logout ?? null, $timezone);
            $last_activity = safe_date_parse($user->last_activity ?? null, $timezone);

            // Debug logging hanya di development environment
            log_status_debug($user, $now, $last_login, $last_logout, $last_activity);

            // 1. Cek jika user masih login (last_login > last_logout)
            if ($last_login && (!$last_logout || $last_login > $last_logout)) {
                return handle_active_user_status($last_login, $now);
            }

            // 2. Gunakan waktu terakhir yang tersedia
            $check_time = $last_activity ?: ($last_login ?: $last_logout);

            if (!$check_time) {
                return [
                    'class'  => 'secondary',
                    'text'   => 'Belum aktif',
                    'detail' => 'Tidak ada riwayat',
                    'icon'   => 'fa-user-clock'
                ];
            }

            // 3. Tentukan status berdasarkan waktu inactive
            return determine_inactive_status($check_time, $now);
        } catch (Exception $e) {
            log_message('error', 'Error in get_user_status: ' . $e->getMessage());
            return invalid_status_response('Sistem gagal memeriksa status');
        }
    }
}

/**
 * Mendapatkan timezone sistem
 * 
 * @return DateTimeZone
 * @throws Exception
 */
if (!function_exists('get_system_timezone')) {
    function get_system_timezone()
    {
        try {
            return new DateTimeZone('Asia/Jakarta');
        } catch (Exception $e) {
            log_message('error', 'Timezone invalid: ' . $e->getMessage());
            return new DateTimeZone(date_default_timezone_get());
        }
    }
}

/**
 * Handle status untuk user yang aktif/login
 */
if (!function_exists('handle_active_user_status')) {
    function handle_active_user_status($last_login, $now)
    {
        $inactive_seconds = $now->getTimestamp() - $last_login->getTimestamp();

        if ($inactive_seconds < STATUS_ONLINE_THRESHOLD) {
            return [
                'class'  => 'success',
                'text'   => 'Online',
                'detail' => 'Sedang aktif',
                'icon'   => 'fa-circle text-success'
            ];
        }

        return [
            'class'  => 'success',
            'text'   => 'Aktif',
            'detail' => 'Login: ' . $last_login->format(TIME_FORMAT),
            'icon'   => 'fa-circle-notch text-success'
        ];
    }
}

/**
 * Tentukan status untuk user yang inactive
 */
if (!function_exists('determine_inactive_status')) {
    function determine_inactive_status($check_time, $now)
    {
        $inactive_seconds = $now->getTimestamp() - $check_time->getTimestamp();

        if ($inactive_seconds < STATUS_RECENT_THRESHOLD) {
            return [
                'class'  => 'info',
                'text'   => 'Baru offline',
                'detail' => $check_time->format(TIME_FORMAT),
                'icon'   => 'fa-clock text-info'
            ];
        }

        if ($inactive_seconds < STATUS_HOUR_THRESHOLD) {
            $minutes = floor($inactive_seconds / 60);
            return [
                'class'  => 'warning',
                'text'   => 'Offline',
                'detail' => $minutes . ' menit lalu',
                'icon'   => 'fa-clock text-warning'
            ];
        }

        if ($inactive_seconds < STATUS_DAY_THRESHOLD) {
            return [
                'class'  => 'warning',
                'text'   => 'Offline',
                'detail' => $check_time->format(TIME_FORMAT),
                'icon'   => 'fa-clock text-warning'
            ];
        }

        return [
            'class'  => 'secondary',
            'text'   => 'Offline',
            'detail' => $check_time->format(DATE_FORMAT),
            'icon'   => 'fa-clock text-secondary'
        ];
    }
}

/**
 * Log debug info untuk status user
 */
if (!function_exists('log_status_debug')) {
    function log_status_debug($user, $now, $last_login, $last_logout, $last_activity)
    {
        if (ENVIRONMENT === 'development') {
            log_message('debug', 'User status check - User ID: ' . ($user->id ?? 'unknown'));
            log_message('debug', 'NOW: ' . $now->format('Y-m-d H:i:s'));
            log_message('debug', 'LOGIN: ' . ($last_login ? $last_login->format('Y-m-d H:i:s') : 'null'));
            log_message('debug', 'LOGOUT: ' . ($last_logout ? $last_logout->format('Y-m-d H:i:s') : 'null'));
            log_message('debug', 'ACTIVITY: ' . ($last_activity ? $last_activity->format('Y-m-d H:i:s') : 'null'));
        }
    }
}

/**
 * Response untuk status yang tidak valid
 */
if (!function_exists('invalid_status_response')) {
    function invalid_status_response($message)
    {
        log_message('error', 'Invalid user status: ' . $message);
        return [
            'class'  => 'danger',
            'text'   => 'Error',
            'detail' => $message,
            'icon'   => 'fa-exclamation-circle'
        ];
    }
}