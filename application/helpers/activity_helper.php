<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('check_inactivity')) {
    function check_inactivity($timeout = 1800) // 30 menit
    {
        $CI = &get_instance();

        if ($CI->session->userdata('logged_in')) {
            $last_activity = $CI->session->userdata('last_activity');

            // Jika melebihi timeout
            if (time() - $last_activity > $timeout) {
                // Update last_logout
                $CI->load->model('User_model');
                $CI->User_model->update_last_logout($CI->session->userdata('user_id'));

                // Hapus session
                $CI->session->unset_userdata(['logged_in', 'user_id', 'username', 'last_activity']);
                $CI->session->set_flashdata('error', 'Session expired karena tidak aktif');
                redirect('auth');
            } else {
                // Update aktivitas terakhir
                $CI->session->set_userdata('last_activity', time());

                // Update last_activity di database
                $CI->db->set('last_activity', date('Y-m-d H:i:s'))
                    ->where('id', $CI->session->userdata('user_id'))
                    ->update('users');
            }
        }
    }
}
