<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Auth Controller
 * Mengelola proses autentikasi pengguna (login, registrasi, logout)
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property User_model $User_model
 */


class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Memuat library yang diperlukan
        $this->load->library(['session', 'form_validation']);
        // Memuat model User_model 
        $this->load->model('User_model');
    }

    public function index() // Login
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', ['title' => 'Login']);
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
        } else {
            $user = $this->User_model->login(
                $this->input->post('username'),
                $this->input->post('password')
            );

            if ($user) {
                // Update last login via model
                $this->User_model->update_last_login($user->id);

                // Set session
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'logged_in' => true,
                    'last_activity' => time() // Tambah timestamp aktivitas
                ]);

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
                redirect('auth');
            }
        }
    }

    public function register()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Registrasi Pengguna';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/footer');
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            ];

            $this->User_model->register($data);
            $this->session->set_flashdata('success', 'Registrasi berhasil. Silakan login.');
            redirect('auth');
        }
    }

    public function logout()
    {
        if ($this->session->userdata('user_id')) {
            // Update last logout via model
            $this->User_model->update_last_logout($this->session->userdata('user_id'));
        }

        // Hapus session
        $this->session->unset_userdata(['logged_in', 'user_id', 'username', 'last_activity']);
        $this->session->set_flashdata('success', 'Anda telah logout');
        redirect('auth');
    }
}
