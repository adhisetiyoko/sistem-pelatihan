<?php
class Peserta_model extends CI_Model
{
    private $table = 'peserta_pelatihan';

    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function read($id = null)
    {
        if ($id) {
            return $this->db->get_where($this->table, ['id_peserta' => $id, 'status_aktif' => 1])->row();
        }
        return $this->db->get_where($this->table, ['status_aktif' => 1])->result();
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

    public function get_peserta($limit = null, $offset = null, $search = null)
    {
        $this->db->where('status_aktif', 1); // Hanya data aktif

        if ($search) {
            $this->db->group_start();
            $this->db->like('nik_peserta', $search);
            $this->db->or_like('no_induk_peserta', $search);
            $this->db->or_like('nama_peserta', $search);
            $this->db->or_like('modul_pelatihan', $search);
            $this->db->group_end();
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get('peserta_pelatihan')->result();
    }

    public function count_search_results($search)
    {
        $this->apply_search_conditions($search);
        return $this->db->count_all_results('peserta_pelatihan');
    }

    public function get_paginated($limit, $offset)
    {
        try {
            $this->db->where('status_aktif', 1); // Tambahkan filter status aktif
            $this->db->order_by('nama_peserta', 'ASC');
            $this->db->limit($limit, $offset);
            $query = $this->db->get('peserta_pelatihan');

            if (!$query) {
                throw new Exception($this->db->error()['message']);
            }

            return $query->result();
        } catch (Exception $e) {
            log_message('error', 'Error in get_paginated: ' . $e->getMessage());
            throw $e;
        }
    }


    public function search_peserta($search)
    {
        $this->db->where('status_aktif', 1);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nik_peserta', $search);
            $this->db->or_like('no_induk_peserta', $search);
            $this->db->or_like('nama_peserta', $search);
            $this->db->or_like('modul_pelatihan', $search);
            $this->db->group_end();
        }

        $this->db->order_by('nama_peserta', 'ASC');
        return $this->db->get($this->table)->result();
    }

    private function apply_search_conditions($search)
    {
        if (empty($search)) return;

        $this->db->group_start();
        $this->db->like('nik_peserta', $search);
        $this->db->or_like('no_induk_peserta', $search);
        $this->db->or_like('nama_peserta', $search);
        $this->db->or_like('modul_pelatihan', $search);
        $this->db->or_like('jenis_kelamin', $search);
        $this->db->or_like('alamat', $search);
        $this->db->group_end();
    }
}
