<!-- aplication/controllers/Profile.php -->

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
 * @property Pdf $pdf

 */

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('user_model');

        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Update last activity
        $this->user_model->update_last_activity($this->session->userdata('user_id'));
    }

    public function index()
    {
        $data['title'] = 'Profil Saya';
        $data['user'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/profile/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profil';
        $data['user'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/profile/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email');
            $username = $this->input->post('username');

            // Check if email changed and already exists
            if ($email != $data['user']->email) {
                $existing_user = $this->user_model->get_user_by_email($email);
                if ($existing_user) {
                    $this->session->set_flashdata('error', 'Email sudah digunakan oleh pengguna lain.');
                    redirect('dashboard/profile/edit');
                }
            }

            // Check if username changed and already exists
            if ($username != $data['user']->username) {
                $existing_user = $this->user_model->get_user_by_username($username);
                if ($existing_user) {
                    $this->session->set_flashdata('error', 'Username sudah digunakan oleh pengguna lain.');
                    redirect('dashboard/profile/edit');
                }
            }

            // Update dashboard/profile
            $update_data = [
                'username' => $username,
                'email' => $email
            ];

            $this->user_model->update_user($this->session->userdata('user_id'), $update_data);

            // Update session data
            $this->session->set_userdata('username', $username);
            $this->session->set_userdata('email', $email);

            $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
            redirect('dashboard/profile');
        }
    }

    public function change_password()
    {
        $data['title'] = 'Ubah Password';
        $data['user'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));

        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required|trim');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|trim|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/profile/change_password', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');

            // Verify current password
            if (!$this->user_model->check_password($this->session->userdata('user_id'), $current_password)) {
                $this->session->set_flashdata('error', 'Password saat ini tidak cocok.');
                redirect('dashboard/profile/change_password');
            }

            // Update password
            $this->user_model->change_password($this->session->userdata('user_id'), $new_password);

            $this->session->set_flashdata('success', 'Password berhasil diubah.');
            redirect('profile');
        }
    }

    public function activity_log()
    {
        $data['title'] = 'Riwayat Aktivitas';
        $data['user'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/profile/activity_log', $data);
        $this->load->view('templates/footer');
    }
}
