<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Pagination $pagination
 * @property CI_URI $uri
 * @property Peserta_model $Peserta_model
 * @property User_model $user_model
 * @property CI_Output $output
 * @property db $db

 */

class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('user_model');
        $this->load->library('user_agent');

        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Update last activity
        $this->user_model->update_last_login($this->session->userdata('user_id'));
    }

    public function index()
    {
        $data['title'] = 'Pengaturan Akun';
        $data['user'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/settings/index', $data);
        $this->load->view('templates/footer');
    }

    public function account()
    {
        $data['title'] = 'Pengaturan Akun';
        $data['user'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));

        $this->form_validation->set_rules('is_active', 'Status Akun', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/settings/account', $data);
            $this->load->view('templates/footer');
        } else {
            // Update account settings
            $is_active = $this->input->post('is_active') ? 1 : 0;

            $update_data = [
                'is_active' => $is_active
            ];

            $this->user_model->update_user($this->session->userdata('user_id'), $update_data);

            $this->session->set_flashdata('success', 'Pengaturan akun berhasil diperbarui.');
            redirect('dashboard/settings/account');
        }
    }

    public function security()
    {
        $this->load->library('user_agent');
        $this->load->helper('google_authenticator');
        $user_id = $this->session->userdata('user_id');
        $user = $this->user_model->get_user_by_id($user_id);

        // Inisialisasi $ga di sini, sebelum kondisi if/else
        $ga = new PHPGangsta_GoogleAuthenticator();

        // Generate secret key untuk 2FA (simpan di database saat pertama kali)
        if (empty($user->ga_secret)) {
            $secret = $ga->createSecret();
            $user_id = $this->session->userdata('user_id');
            if (!empty($user_id) && !empty($secret)) {
                $result = $this->user_model->update_user($user_id, ['ga_secret' => $secret]);
                if ($result) {
                    $this->session->set_flashdata('success', 'Verifikasi dua langkah berhasil diaktifkan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengaktifkan verifikasi dua langkah');
                }
            }
        } else {
            $secret = $user->ga_secret;
        }

        // Generate QR Code URL
        $qrCodeUrl = $ga->getQRCodeGoogleUrl(
            'NamaAplikasiAnda',
            $user->email,
            $secret
        );

        $data = [
            'user' => $user,
            'qrCodeUrl' => $qrCodeUrl,
            'ga_secret' => $secret,
            'current_ip' => $_SERVER['REMOTE_ADDR'],
            'current_location' => $this->get_location_from_ip($_SERVER['REMOTE_ADDR']),
            'last_login_ip' => $user->last_login_ip ?? $_SERVER['REMOTE_ADDR']
        ];

        // Tambahkan di method security()
        $ip = $user->last_login_ip ?? $_SERVER['REMOTE_ADDR'];
        $data['location'] = $this->get_location_from_ip($ip);

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/settings/security', $data);
        $this->load->view('templates/footer');
    }

    // Tambahkan method baru
    private function get_location_from_ip($ip)
    {
        if ($ip == '127.0.0.1' || $ip == '::1') {
            return 'Localhost';
        }

        // Gunakan API gratis seperti ip-api.com
        $url = "http://ip-api.com/json/{$ip}";
        $response = file_get_contents($url);
        $data = json_decode($response);

        if ($data && $data->status == 'success') {
            return $data->city . ', ' . $data->country;
        }

        return 'Tidak diketahui';
    }

    public function notifications()
    {
        $data['title'] = 'Pengaturan Notifikasi';
        $data['user'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/settings/notifications', $data);
        $this->load->view('templates/footer');
    }

    public function deactivate()
    {
        $data['title'] = 'Nonaktifkan Akun';
        $data['user'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));

        $this->form_validation->set_rules('confirmation', 'Konfirmasi', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/settings/deactivate', $data);
            $this->load->view('templates/footer');
        } else {
            $confirmation = $this->input->post('confirmation');
            $password = $this->input->post('password');

            // Check confirmation
            if ($confirmation !== 'NONAKTIFKAN') {
                $this->session->set_flashdata('error', 'Konfirmasi tidak valid.');
                redirect('dashboard/settings/deactivate');
            }

            // Verify password
            if (!$this->user_model->check_password($this->session->userdata('user_id'), $password)) {
                $this->session->set_flashdata('error', 'Password tidak cocok.');
                redirect('dashboard/settings/deactivate');
            }

            // Deactivate account
            $this->user_model->update_user($this->session->userdata('user_id'), ['is_active' => 0]);

            // Log out user
            $this->user_model->update_last_logout($this->session->userdata('user_id'));
            $this->session->sess_destroy();

            $this->session->set_flashdata('success', 'Akun Anda telah dinonaktifkan.');
            redirect('auth');
        }
    }

    public function logout_other_devices()
    {
        $this->session->sess_regenerate(true); // Generate session ID baru
        $this->user_model->update_last_activity($this->session->userdata('user_id'));

        $this->session->set_flashdata('success', 'Anda telah logout dari semua perangkat lain');
        redirect('settings/security');
    }

    public function get_login_history($user_id, $limit = 5)
    {
        return $this->db
            ->select('ip_address, login_time, user_agent')
            ->from('user_login_history') // Asumsi ada tabel ini
            ->where('user_id', $user_id)
            ->order_by('login_time', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }
}
