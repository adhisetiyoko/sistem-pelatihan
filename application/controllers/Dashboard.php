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
 * @property Pdf $pdf
 * @property db $db

 */


// Tambahkan ini di luar fungsi, sebelum class
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $this->load->model(['Peserta_model', 'User_model']);
        $this->load->helper('user_status');
        $this->load->library('pdf'); // ini akan load application/libraries/Pdf.php
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
                'showing' => $this->Peserta_model->count_search_results($search) ?: $this->Peserta_model->count_all(),
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
                <span class="badge bg-' . ($p->nama_modul == 'Pemrograman' ? 'info' : ($p->nama_modul == 'Desain Grafis' ? 'warning' : 'success')) . '">
                    ' . htmlspecialchars($p->nama_modul) . '
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
        } else {
            $output = '<tr><td colspan="6" class="text-center py-4">Tidak ditemukan data peserta</td></tr>';
        }

        // Kirim juga total hasil untuk update counter
        $output .= '<script>
        $(document).ready(function() {
            $("#showingCount").text(' . count($peserta) . ');
            $("#totalCount").text(' . $total_results . ');
        });
        </script>';

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
        // Set form validation rules dengan pesan error bahasa Indonesia
        $this->form_validation->set_rules('nik_peserta', 'NIK', 'required|is_unique[peserta_pelatihan.nik_peserta]', [
            'required' => 'NIK wajib diisi.',
            'is_unique' => 'NIK ini sudah terdaftar dalam sistem.'
        ]);

        $this->form_validation->set_rules('no_induk_peserta', 'Nomor Induk', 'required|is_unique[peserta_pelatihan.no_induk_peserta]', [
            'required' => 'Nomor Induk wajib diisi.',
            'is_unique' => 'Nomor Induk ini sudah terdaftar dalam sistem.'
        ]);

        $this->form_validation->set_rules('nama_peserta', 'Nama Peserta', 'required', [
            'required' => 'Nama Peserta wajib diisi.'
        ]);

        $this->form_validation->set_rules('jenis_kelamin_id', 'Jenis Kelamin', 'required', [
            'required' => 'Jenis Kelamin wajib dipilih.'
        ]);

        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required', [
            'required' => 'Tempat Lahir wajib diisi.'
        ]);

        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|callback_valid_date', [
            'required' => 'Tanggal Lahir wajib diisi.'
        ]);

        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|numeric', [
            'required' => 'Nomor Telepon wajib diisi.',
            'numeric' => 'Nomor Telepon harus berupa angka.'
        ]);

        $this->form_validation->set_rules('id_modul', 'Modul Pelatihan', 'required', [
            'required' => 'Modul Pelatihan wajib dipilih.'
        ]);

        $this->form_validation->set_rules('alamat', 'Alamat', 'required', [
            'required' => 'Alamat wajib diisi.'
        ]);

        // Untuk callback custom validation
        $this->form_validation->set_message('valid_date', 'Format tanggal pada %s tidak valid.');

        // Simpan semua data input ke dalam variabel untuk digunakan kembali jika validasi gagal
        $data['form_data'] = [
            'nik_peserta' => $this->input->post('nik_peserta'),
            'no_induk_peserta' => $this->input->post('no_induk_peserta'),
            'nama_peserta' => $this->input->post('nama_peserta'),
            'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'no_telp' => $this->input->post('no_telp'),
            'id_modul' => $this->input->post('id_modul'),
            'alamat' => $this->input->post('alamat')
        ];

        $data['title'] = 'Tambah Peserta';

        if ($this->form_validation->run() === FALSE) {
            // Load view dengan data yang sudah diisi
            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/peserta/tambah', $data);
            $this->load->view('templates/footer');
        } else {
            // Proses jika validasi berhasil
            // Cek jika nik_peserta atau no_induk_peserta sudah ada di database
            $nik_peserta = $this->input->post('nik_peserta');
            $no_induk_peserta = $this->input->post('no_induk_peserta');

            // 1. Cek jika NIK dan NIP sama
            if ($nik_peserta === $no_induk_peserta) {
                $this->session->set_flashdata('error', 'NIK dan No Induk Peserta tidak boleh sama.');
                $this->session->set_flashdata('form_data', $data['form_data']);
                redirect('dashboard/peserta/tambah');
                return;
            }

            // 2. Cek duplikat NIK (tambahan validasi manual meskipun sudah ada is_unique rule)
            $nik_exists = $this->db->get_where('peserta_pelatihan', ['nik_peserta' => $nik_peserta])->num_rows() > 0;
            if ($nik_exists) {
                $this->session->set_flashdata('error', 'NIK sudah terdaftar');
                $this->session->set_flashdata('form_data', $data['form_data']);
                redirect('dashboard/peserta/tambah');
                return;
            }

            // 3. Cek duplikat NIP (tambahan validasi manual meskipun sudah ada is_unique rule)
            $no_induk_exists = $this->db->get_where('peserta_pelatihan', ['no_induk_peserta' => $no_induk_peserta])->num_rows() > 0;
            if ($no_induk_exists) {
                $this->session->set_flashdata('error', 'No Induk sudah terdaftar');
                $this->session->set_flashdata('form_data', $data['form_data']);
                redirect('dashboard/peserta/tambah');
                return;
            }

            // Jika semua validasi berhasil
            $peserta_data = $this->input->post();
            $this->Peserta_model->create($peserta_data);
            $this->session->set_flashdata('success', 'Data peserta berhasil ditambahkan');
            redirect('dashboard/peserta');
        }
    }

    public function edit_peserta($id)
    {
        $this->form_validation->set_rules('nik_peserta', 'NIK', 'required');
        $this->form_validation->set_rules('no_induk_peserta', 'No Induk', 'required');
        $this->form_validation->set_rules('nama_peserta', 'Nama Peserta', 'required');
        $this->form_validation->set_rules('jenis_kelamin_id', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|callback_valid_date');
        $this->form_validation->set_rules('no_telp', 'No HP', 'required|numeric');
        $this->form_validation->set_rules('id_modul', 'Modul Pelatihan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data = [
                'title' => 'Edit Peserta',
                'peserta' => $this->Peserta_model->read($id),

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

    public function export_pdf()
    {
        $this->load->library('pdf');

        $search = $this->input->get('search');
        $data['peserta'] = $this->Peserta_model->search_peserta($search, 1000, 0);

        $html = $this->load->view('dashboard/peserta/export_pdf', $data, true);

        ob_clean(); // Bersihkan output buffer

        // Panggil dengan parameter landscape
        $this->pdf->createPDF($html, 'Data_Peserta_' . date('Ymd'), true, 'L');
    }

    public function export_excel()
    {
        ob_clean(); // Pastikan tidak ada output sebelumnya

        // Ambil data dari model
        $this->load->model('Peserta_model');
        $search = $this->input->get('search');
        $data = $this->Peserta_model->search_peserta($search, null, null);

        // Load library PhpSpreadsheet
        require_once APPPATH . 'third_party/PhpSpreadsheet/vendor/autoload.php';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set properti file
        $spreadsheet->getProperties()
            ->setCreator("Sistem Pelatihan")
            ->setLastModifiedBy("Sistem Pelatihan")
            ->setTitle("Data Peserta Pelatihan");

        // Header
        $sheet->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'NIK')
            ->setCellValue('C1', 'NO INDUK')
            ->setCellValue('D1', 'NAMA PESERTA')
            ->setCellValue('E1', 'JENIS KELAMIN')
            ->setCellValue('F1', 'MODUL PELATIHAN');

        // Isi data
        $row = 2;
        foreach ($data as $key => $p) {
            $sheet->setCellValue('A' . $row, $key + 1)
                ->setCellValueExplicit('B' . $row, $p->nik_peserta, DataType::TYPE_STRING)
                ->setCellValue('C' . $row, $p->no_induk_peserta)
                ->setCellValue('D' . $row, $p->nama_peserta)
                ->setCellValue('E' . $row, $p->jenis_kelamin)
                ->setCellValue('F' . $row, $p->nama_modul);
            $row++;
        }

        // Styling header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,  // Horizontal center
                'vertical' => Alignment::VERTICAL_CENTER       // Vertical center
            ]
        ];
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

        // Styling border untuk tabel
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,  // Menggunakan border tipis
                    'color' => ['rgb' => '000000']  // Warna border hitam
                ]
            ]
        ];
        $sheet->getStyle('A1:F' . ($row - 1))->applyFromArray($borderStyle);

        // Styling untuk centerkan semua konten tabel
        $sheet->getStyle('A1:F' . ($row - 1))
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER) // Horizontal center
            ->setVertical(Alignment::VERTICAL_CENTER);    // Vertical center

        // Autosize kolom
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Nama file
        $filename = 'Data_Peserta_' . date('Ymd_His') . '.xlsx';

        // Output ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // // Fungsi untuk validasi format tanggal
    // public function valid_date($date)
    // {
    //     // Cek apakah format tanggal valid (YYYY-MM-DD)
    //     $format = 'Y-m-d';
    //     $d = DateTime::createFromFormat($format, $date);
    //     if ($d && $d->format($format) === $date) {
    //         return TRUE; // Format tanggal valid
    //     } else {
    //         $this->form_validation->set_message('valid_date', 'Tanggal Lahir tidak valid. Format yang benar adalah YYYY-MM-DD.');
    //         return FALSE; // Format tanggal tidak valid
    //     }
    // }

    // Fungsi callback untuk validasi tanggal
    public function valid_date($date)
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return FALSE;
        }

        // Validasi tanggal yang valid menggunakan PHP DateTime
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    // Fungsi untuk memeriksa apakah NIK dan No Induk sudah ada di database
    public function check_peserta()
    {
        $nik = $this->input->post('nik');
        $no_induk = $this->input->post('no_induk');

        $this->load->model('Peserta_model');

        $result = array(
            'nik_exists' => $this->Peserta_model->check_nik_exists($nik),
            'no_induk_exists' => $this->Peserta_model->check_no_induk_exists($no_induk)
        );

        echo json_encode($result);
    }
}
