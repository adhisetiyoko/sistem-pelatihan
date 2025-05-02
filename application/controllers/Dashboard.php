<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Pagination $pagination
 * @property CI_URI $uri
 * @property Peserta_model $Peserta_model
 * @property User_model $User_model
 * @property CI_Output $output
 */
class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model(['Peserta_model', 'User_model']);
        $this->load->helper('user_status');
    }

    public function index()
    {
        $data['total_peserta'] = $this->Peserta_model->count_all();
        $data['total_users'] = count($this->User_model->get_all_users());

        $this->load->view('templates/header', ['title' => 'Dashboard']);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

    public function peserta()
    {
        try {
            $search = $this->input->get('search');
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $per_page = 5;

            $this->load->library('pagination');

            // Konfigurasi pagination yang benar untuk peserta
            $config = [
                'base_url' => site_url('dashboard/peserta'),
                'total_rows' => $search
                    ? $this->Peserta_model->count_search_results($search)
                    : $this->Peserta_model->count_all(),
                'per_page' => $per_page,
                'uri_segment' => 3,
                'reuse_query_string' => true,

                // Styling pagination
                'full_tag_open' => '<ul class="pagination pagination-sm justify-content-end">',
                'full_tag_close' => '</ul>',
                'attributes' => ['class' => 'page-link'],
                'first_link' => '&laquo; First',
                'last_link' => 'Last &raquo;',
                'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
                'cur_tag_close' => '</span></li>',
                'num_tag_open' => '<li class="page-item">',
                'num_tag_close' => '</li>',
                'prev_link' => '&lsaquo;',
                'next_link' => '&rsaquo;',
                'prev_tag_open' => '<li class="page-item">',
                'prev_tag_close' => '</li>',
                'next_tag_open' => '<li class="page-item">',
                'next_tag_close' => '</li>'
            ];

            $this->pagination->initialize($config);

            $data = [
                'title' => 'Data Peserta Pelatihan',
                'peserta' => $this->get_peserta_data($search, $per_page, $page),
                'pagination' => $this->pagination->create_links(),
                'search' => $search,
                'total_rows' => $config['total_rows'],
                'showing' => $this->Peserta_model->count_search_results($search) ?: $this->Peserta_model->count_all()
            ];

            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/peserta/index', $data);
            $this->load->view('templates/footer');
        } catch (Exception $e) {
            log_message('error', 'Error loading peserta: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat memuat data peserta.');
            redirect('dashboard');
        }
    }

    public function peserta_ajax()
    {
        $search = $this->input->get('search', true);
        $page = $this->input->get('page', true) ?? 1;
        $per_page = 5;
        $offset = ($page - 1) * $per_page;

        // Get paginated search results
        $peserta = $this->Peserta_model->search_peserta($search, $per_page, $offset);
        $total_results = $this->Peserta_model->count_search_results($search);

        $no = 1 + $offset;
        $output = '';

        if ($peserta) {
            foreach ($peserta as $p) {
                $output .= '
            <tr class="user-row hover-effect">
                <td class="text-center">' . $no++ . '</td>
                <td>' . htmlspecialchars($p->nik_peserta) . '</td>
                <td>' . htmlspecialchars($p->no_induk_peserta) . '</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                            ' . strtoupper(substr($p->nama_peserta, 0, 1)) . '
                        </div>
                        <div>
                            <h6 class="mb-0">' . htmlspecialchars($p->nama_peserta) . '</h6>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <span class="badge bg-' . ($p->modul_pelatihan == 'Pemrograman' ? 'info' : ($p->modul_pelatihan == 'Desain Grafis' ? 'warning' : 'success')) . '">
                        ' . htmlspecialchars($p->modul_pelatihan) . '
                    </span>
                </td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm">
                        <a href="' . base_url('dashboard/edit_peserta/' . $p->id_peserta) . '" class="btn btn-outline-primary px-3" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="' . base_url('dashboard/hapus_peserta/' . $p->id_peserta) . '" class="btn btn-outline-danger px-3" title="Hapus" onclick="return confirm(\'Yakin ingin menghapus peserta ini?\')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <a href="' . base_url('dashboard/detail_peserta/' . $p->id_peserta) . '" class="btn btn-outline-info px-3" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>';
            }

            // Add pagination and counter update
            $output .= '
        <script>
            $(document).ready(function() {
                // Update showing count
                $("#showingCount").text(' . count($peserta) . ');
                $("#totalCount").text(' . $total_results . ');
                
                // Re-init pagination
                initPagination(' . $total_results . ', ' . $per_page . ', ' . $page . ', "' . htmlspecialchars($search, ENT_QUOTES) . '");
            });
        </script>';
        } else {
            $output = '<tr><td colspan="6" class="text-center py-4">Tidak ditemukan data peserta</td></tr>
        <script>
            $(document).ready(function() {
                $("#showingCount").text(0);
                $("#totalCount").text(0);
                $(".pagination").html("");
            });
        </script>';
        }

        echo $output;
        exit;
    }

    private function get_peserta_data($search, $per_page, $page)
    {
        return $search ? $this->Peserta_model->search_peserta($search, $per_page, $page)
            : $this->Peserta_model->get_paginated($per_page, $page);
    }

    public function tambah_peserta()
    {
        $this->form_validation->set_rules('nik_peserta', 'NIK', 'required|is_unique[peserta_pelatihan.nik_peserta]');
        $this->form_validation->set_rules('no_induk_peserta', 'No Induk', 'required|is_unique[peserta_pelatihan.no_induk_peserta]');
        // Set rules lainnya...

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', ['title' => 'Tambah Peserta']);
            $this->load->view('dashboard/peserta/tambah');
            $this->load->view('templates/footer');
        } else {
            $this->Peserta_model->create($this->input->post());
            $this->session->set_flashdata('success', 'Data peserta berhasil ditambahkan');
            redirect('dashboard/peserta');
        }
    }

    public function edit_peserta($id)
    {
        $this->form_validation->set_rules('nik_peserta', 'NIK', 'required');
        $this->form_validation->set_rules('no_induk_peserta', 'No Induk', 'required');
        // Set rules lainnya...

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'title' => 'Edit Peserta',
                'peserta' => $this->Peserta_model->read($id)
            ];

            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/peserta/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Peserta_model->update($id, $this->input->post());
            $this->session->set_flashdata('success', 'Data peserta berhasil diperbarui');
            redirect('dashboard/peserta');
        }
    }

    public function detail_peserta($id)
    {
        $peserta = $this->Peserta_model->read($id);

        if (!$peserta) {
            show_404();
        }

        $data = [
            'title' => 'Detail Peserta',
            'peserta' => $peserta
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/peserta/detail_peserta', $data);
        $this->load->view('templates/footer');
    }
 
    public function hapus_peserta($id)
    {
        $this->Peserta_model->delete($id);
        $this->session->set_flashdata('success', 'Data peserta berhasil dihapus');
        redirect('dashboard/peserta');
    }

    public function users()
    {
        $this->load->library('pagination');

        $search = $this->input->get('search');
        $page = $this->input->get('page') ?? 1;
        $per_page = 5;
        $offset = ($page - 1) * $per_page;

        $total_rows = $search
            ? $this->User_model->count_search_results($search)
            : $this->User_model->count_all();

        $config = [
            'base_url' => site_url('dashboard/users'),
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'page_query_string' => TRUE,
            'query_string_segment' => 'page',
            'reuse_query_string' => TRUE,
            'use_page_numbers' => TRUE,

            // Styling
            'full_tag_open' => '<ul class="pagination pagination-sm justify-content-end">',
            'full_tag_close' => '</ul>',
            'attributes' => ['class' => 'page-link'],
            'first_link' => '&laquo; First',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            'last_link' => 'Last &raquo;',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close' => '</span></li>',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
        ];

        $this->pagination->initialize($config);

        $data['users'] = $search
            ? $this->User_model->search_users($search, $per_page, $offset)
            : $this->User_model->get_paginated_users($per_page, $offset);

        $data['total_rows'] = $total_rows;
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;
        $data['config'] = $config;

        $this->load->view('templates/header', ['title' => 'Data Users']);
        $this->load->view('dashboard/users', $data);
        $this->load->view('templates/footer');
    }


    public function users_ajax()
    {
        $search = $this->input->get('search', true);
        $page = $this->input->get('page', true) ?? 1;
        $per_page = 5;
        $offset = ($page - 1) * $per_page;

        // Get paginated search results
        $users = $this->User_model->search_users($search, $per_page, $offset);
        $total_results = $this->User_model->count_search_results($search);

        $no = 1 + $offset;
        $output = '';

        if ($users) {
            foreach ($users as $u) {
                $status = get_user_status($u); // Menggunakan helper

                $output .= '
                <tr class="user-row hover-effect">
                    <td class="text-center">' . $no++ . '</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                                ' . strtoupper(substr($u->username, 0, 1)) . '
                            </div>
                            <div>
                                <h6 class="mb-0">' . htmlspecialchars($u->username) . '</h6>
                                <small class="text-muted">ID: ' . $u->id . '</small>
                            </div>
                        </div>
                    </td>
                    <td>' . htmlspecialchars($u->email) . '</td>
                    <td class="text-center">
                        <span class="badge bg-' . $status['class'] . '">
                            ' . $status['text'] . '
                        </span>
                        <small class="d-block text-muted mt-1">
                            ' . $status['detail'] . '
                        </small>
                    </td>
                    <td class="text-center">
                        <small class="text-muted">
                            ' . ($u->last_login ? date('d M Y H:i', strtotime($u->last_login)) : 'Belum pernah login') . '
                        </small>
                    </td>
                </tr>';
            }


            // Add pagination and counter update
            $output .= '
        <script>
            $(document).ready(function() {
                // Update showing count
                $("#showingCount").text(' . count($users) . ');
                
                // Re-init pagination
                initPagination(' . $total_results . ');
            });
            
            function initPagination(total) {
                $(".pagination").pagination({
                    items: total,
                    itemsOnPage: ' . $per_page . ',
                    currentPage: ' . $page . ',
                    cssStyle: "light-theme",
                    hrefTextPrefix: "' . site_url('dashboard/users?search=' . urlencode($search) . '&page=') . '",
                    onPageClick: function(pageNum) {
                        performLiveSearch("' . $search . '", pageNum);
                    }
                });
            }
        </script>';
        } else {
            $output = '<tr><td colspan="5" class="text-center py-4">Tidak ditemukan data pengguna</td></tr>
        <script>
            $(document).ready(function() {
                $("#showingCount").text(0);
                $(".pagination").html("");
            });
        </script>';
        }

        echo $output;
        exit;
    }
}
