<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_user_status')) {
    function get_user_status($user)
    {
        // Timezone lokal Indonesia
        $timezone = new DateTimeZone('Asia/Jakarta');
        $now = new DateTime('now', $timezone);

        $is_active = $user->is_active ?? 0;

        // Status jika akun dinonaktifkan
        if (!$is_active) {
            return [
                'class'  => 'danger',
                'text'   => 'Nonaktif',
                'detail' => 'Akun dinonaktifkan'
            ];
        }

        // Ambil aktivitas terakhir
        $last_login    = $user->last_login ?? null;
        $last_logout   = $user->last_logout ?? null;
        $last_activity = $user->last_activity ?? null;

        // Jika masih login (last_login > last_logout)
        if ($last_login && (!$last_logout || strtotime($last_login) > strtotime($last_logout))) {
            $login_time = new DateTime($last_login, $timezone);
            $inactive_seconds = $now->getTimestamp() - $login_time->getTimestamp();
            
            // Tampilkan "Online" hanya dalam 60 detik pertama
            if ($inactive_seconds < 60) {
                return [
                    'class'  => 'success',
                    'text'   => 'Online',
                    'detail' => 'Aktif ' . $inactive_seconds . ' detik lalu'
                ];
            }
            return [
                'class'  => 'success',
                'text'   => 'Aktif', // Diubah dari 'Online' menjadi 'Aktif'
                'detail' => 'Login: ' . $login_time->format('H:i')
            ];
        }

        // Gunakan waktu terakhir aktivitas yang tersedia
        $check_time = $last_activity ?: ($last_login ?: $last_logout);

        if (!$check_time) {
            return [
                'class'  => 'secondary',
                'text'   => 'Belum aktif',
                'detail' => 'Tidak ada riwayat'
            ];
        }

        $last_time = new DateTime($check_time, $timezone);
        $inactive_seconds = $now->getTimestamp() - $last_time->getTimestamp();

        // Status berdasarkan waktu terakhir aktivitas
        if ($inactive_seconds < 300) { // 5 menit
            return [
                'class'  => 'info',
                'text'   => 'Baru offline',
                'detail' => $last_time->format('H:i')
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
                'detail' => $last_time->format('H:i')
            ];
        } else {
            return [
                'class'  => 'secondary',
                'text'   => 'Offline',
                'detail' => $last_time->format('d M Y')
            ];
        }
    }
}