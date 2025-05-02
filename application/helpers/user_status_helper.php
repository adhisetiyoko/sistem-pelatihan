<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_user_status')) {
    /**
     * Mendapatkan status pengguna dengan berbagai pengecekan
     * @param object $user Data user dari database
     * @return array [class, text, detail]
     */
    function get_user_status($user)
    {
        try {
            // Set timezone default
            date_default_timezone_set('Asia/Jakarta');
            $timezone = new DateTimeZone('Asia/Jakarta');
            $now = new DateTime('now', $timezone);

            // Validasi data user
            if (!is_object($user)) {
                throw new Exception("Data user harus berupa object");
            }

            // Cek status aktif
            $is_active = isset($user->is_active) ? (bool)$user->is_active : false;

            if (!$is_active) {
                return [
                    'class'  => 'danger',
                    'text'   => 'Nonaktif',
                    'detail' => 'Akun dinonaktifkan'
                ];
            }

            // Fungsi untuk parsing tanggal dengan error handling
            function safe_date_parse($dateString, $timezone)
            {
                if (empty($dateString)) {
                    try {
                        return new DateTime($dateString, $timezone);
                    } catch (Exception $e) {
                        log_message('error', 'Gagal parsing tanggal: ' . $dateString . ' - ' . $e->getMessage());
                        return null;
                    }
                }
            }

            // Parse waktu-waktu penting
            $last_login = safe_date_parse($user->last_login ?? null, $timezone);
            $last_logout = safe_date_parse($user->last_logout ?? null, $timezone);
            $last_activity = safe_date_parse($user->last_activity ?? null, $timezone);

            // Debug data - bisa di-comment setelah development
            /*
            log_message('debug', 'User Status Check: ' . ($user->id ?? 'unknown') . 
                ' | Login: ' . ($last_login ? $last_login->format('Y-m-d H:i:s') : 'null') .
                ' | Logout: ' . ($last_logout ? $last_logout->format('Y-m-d H:i:s') : 'null') .
                ' | Activity: ' . ($last_activity ? $last_activity->format('Y-m-d H:i:s') : 'null'));
            */

            // 1. Cek jika user masih login (last_login > last_logout)
            if ($last_login && (!$last_logout || $last_login > $last_logout)) {
                $inactive_seconds = $now->getTimestamp() - $last_login->getTimestamp();

                // Online dalam 60 detik terakhir
                if ($inactive_seconds < 60) {
                    return [
                        'class'  => 'success',
                        'text'   => 'Online',
                        'detail' => 'Aktif ' . $inactive_seconds . ' detik lalu'
                    ];
                }

                // Masih login tapi > 60 detik
                return [
                    'class'  => 'success',
                    'text'   => 'Aktif',
                    'detail' => 'Login: ' . $last_login->format('H:i')
                ];
            }

            // 2. Gunakan waktu terakhir yang tersedia
            $check_time = $last_activity ?: ($last_login ?: $last_logout);

            if (!$check_time) {
                return [
                    'class'  => 'secondary',
                    'text'   => 'Belum aktif',
                    'detail' => 'Tidak ada riwayat'
                ];
            }

            $inactive_seconds = $now->getTimestamp() - $check_time->getTimestamp();

            // 3. Tentukan status berdasarkan waktu inactive
            if ($inactive_seconds < 300) { // 5 menit
                return [
                    'class'  => 'info',
                    'text'   => 'Baru offline',
                    'detail' => $check_time->format('H:i')
                ];
            } elseif ($inactive_seconds < 3600) { // 1 jam
                $minutes = floor($inactive_seconds / 60);
                return [
                    'class'  => 'warning',
                    'text'   => 'Offline',
                    'detail' => $minutes . ' menit lalu'
                ];
            } elseif ($inactive_seconds < 86400) { // 1 hari
                return [
                    'class'  => 'warning',
                    'text'   => 'Offline',
                    'detail' => $check_time->format('H:i')
                ];
            } else { // > 1 hari
                return [
                    'class'  => 'secondary',
                    'text'   => 'Offline',
                    'detail' => $check_time->format('d M Y')
                ];
            }
        } catch (Exception $e) {
            log_message('error', 'Error in get_user_status: ' . $e->getMessage());
            return [
                'class'  => 'danger',
                'text'   => 'Error',
                'detail' => 'Sistem gagal memeriksa status'
            ];
        }
    }
}
