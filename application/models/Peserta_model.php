<!-- application/models/Peserta_model.php -->
<?php
class Peserta_model extends CI_Model
{
    private $table = 'peserta_pelatihan';

    public function create($data)
    {
        $this->db->insert($this->table, $data);

        // Cek apakah ada baris yang terpengaruh
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            // Jika tidak ada baris yang terpengaruh, berarti insert gagal
            $error = $this->db->error();
            print_r($error);  // Debugging error
            return false;
        }
    }



    /**
     * Mengambil data peserta dengan join ke tabel modul
     * @return object Properti penting:
     *   - id_peserta
     *   - nama_peserta
     *   - nama_modul (dari join dengan modul_pelatihan)
     *   - jenis_kelamin
     */
    public function read($id = null)
    {
        if ($id) {
            return $this->db->select('p.*, m.nama_modul, jk.jenis_kelamin')
                ->from('peserta_pelatihan p')
                ->join('modul_pelatihan m', 'm.id_modul = p.id_modul', 'left')
                ->join('jenis_kelamin jk', 'jk.id_jenis_kelamin = p.jenis_kelamin_id', 'left')
                ->where('p.id_peserta', $id)
                ->where('p.status_aktif', 1)
                ->get()->row();
        }
        return $this->db->select('p.*, m.nama_modul, jk.jenis_kelamin')
            ->from('peserta_pelatihan p')
            ->join('modul_pelatihan m', 'm.id_modul = p.id_modul', 'left')
            ->join('jenis_kelamin jk', 'jk.id_jenis_kelamin = p.jenis_kelamin_id', 'left')
            ->where('p.status_aktif', 1)
            ->get()->result();
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id_peserta' => $id]);
    }

    public function delete($id)
    {
        return $this->db->update($this->table, ['status_aktif' => 0], ['id_peserta' => $id]);
    }

    public function restore($id)
    {
        return $this->db->update($this->table, ['status_aktif' => 1], ['id_peserta' => $id]);
    }

    public function get_nonaktif()
    {
        return $this->db->get_where($this->table, ['status_aktif' => 0])->result();
    }

    public function count_all()
    {
        return $this->db->where('status_aktif', 1)->count_all_results($this->table);
    }

    public function get_peserta_data()
    {
        $this->db->select('p.id AS peserta_id, p.nama AS peserta_nama, j.jenis_kelamin, m.modul_pelatihan');
        $this->db->from('peserta_pelatihan p');
        $this->db->join('jenis_kelamin j', 'p.jenis_kelamin_id = j.id');
        $this->db->join('modul_pelatihan m', 'p.modul_pelatihan_id = m.id');

        $query = $this->db->get();
        return $query->result();
    }


    public function get_peserta($limit = null, $offset = null, $search = null)
    {
        $this->db->select('p.*, m.nama_modul, jk.jenis_kelamin');
        $this->db->from('peserta_pelatihan p');
        $this->db->join('modul_pelatihan m', 'm.id_modul = p.id_modul', 'left');
        $this->db->join('jenis_kelamin jk', 'jk.id_jenis_kelamin = p.jenis_kelamin_id', 'left');
        $this->db->where('p.status_aktif', 1);

        if ($search) {
            $this->db->group_start();
            $this->db->like('p.nik_peserta', $search);
            $this->db->or_like('p.no_induk_peserta', $search);
            $this->db->or_like('p.nama_peserta', $search);
            $this->db->or_like('m.nama_modul', $search);
            $this->db->or_like('jk.jenis_kelamin', $search);
            $this->db->group_end();
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    public function count_search_results($search)
    {
        $this->db->from('peserta_pelatihan p');
        $this->db->join('modul_pelatihan m', 'm.id_modul = p.id_modul', 'left');
        $this->db->join('jenis_kelamin jk', 'jk.id_jenis_kelamin = p.jenis_kelamin_id', 'left');
        $this->db->where('p.status_aktif', 1);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('p.nik_peserta', $search);
            $this->db->or_like('p.no_induk_peserta', $search);
            $this->db->or_like('p.nama_peserta', $search);
            $this->db->or_like('m.nama_modul', $search);
            $this->db->or_like('jk.jenis_kelamin', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    public function get_paginated($limit, $offset)
    {
        try {
            $this->db->select('p.*, m.nama_modul, jk.jenis_kelamin');
            $this->db->from('peserta_pelatihan p');
            $this->db->join('modul_pelatihan m', 'm.id_modul = p.id_modul', 'left');
            $this->db->join('jenis_kelamin jk', 'jk.id_jenis_kelamin = p.jenis_kelamin_id', 'left');
            $this->db->where('p.status_aktif', 1);
            $this->db->order_by('p.nama_peserta', 'ASC');
            $this->db->limit($limit, $offset);

            $query = $this->db->get();

            if (!$query) {
                throw new Exception($this->db->error()['message']);
            }

            return $query->result();
        } catch (Exception $e) {
            log_message('error', 'Error in get_paginated: ' . $e->getMessage());
            throw $e;
        }
    }


    public function search_peserta($search, $limit, $offset)
    {
        $this->db->select('p.*, m.nama_modul, jk.jenis_kelamin'); // Perhatikan alias 'modul_pelatihan'
        $this->db->from('peserta_pelatihan p');
        $this->db->join('modul_pelatihan m', 'm.id_modul = p.id_modul', 'left');
        $this->db->join('jenis_kelamin jk', 'jk.id_jenis_kelamin = p.jenis_kelamin_id', 'left');
        $this->db->where('p.status_aktif', 1);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('p.nik_peserta', $search);
            $this->db->or_like('p.no_induk_peserta', $search);
            $this->db->or_like('p.nama_peserta', $search);
            $this->db->or_like('m.nama_modul', $search);
            $this->db->or_like('jk.jenis_kelamin', $search);
            $this->db->group_end();
        }

        $this->db->order_by('p.nama_peserta', 'ASC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    private function apply_search_conditions($search)
    {
        if (empty($search)) return;

        $this->db->group_start();
        $this->db->like('p.nik_peserta', $search);
        $this->db->or_like('p.no_induk_peserta', $search);
        $this->db->or_like('p.nama_peserta', $search);
        $this->db->or_like('m.nama_modul', $search);
        $this->db->or_like('jk.jenis_kelamin', $search); // Search by jenis_kelamin
        $this->db->group_end();
    }

    public function get_modul_pelatihan()
    {
        return $this->db->get('modul_pelatihan')->result();
    }

    public function get_jenis_kelamin()
    {
        return $this->db->get('jenis_kelamin')->result();
    }
}
