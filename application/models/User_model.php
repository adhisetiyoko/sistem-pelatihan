<?php
class User_model extends CI_Model
{
    public function register($data)
    {
        $user_data = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ];

        return $this->db->insert('users', $user_data);
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                return $user; // Login berhasil
            }
        }
        return false; // Login gagal
    }


    public function get_all_users()
    {
        return $this->db->get('users')->result();
    }

    public function search_users($search = null, $limit = null, $offset = null)
    {
        $this->db->select('id, username, email, created_at, last_login, is_active');
        $this->db->from('users');
        $this->db->where('is_active', 1);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('username', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('username', 'ASC');
        return $this->db->get()->result();
    }

    public function count_search_results($search = null)
    {
        $this->db->from('users');
        $this->db->where('is_active', 1);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('username', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    public function get_paginated_users($limit, $offset)
    {
        $this->db->select('id, username, email, created_at, last_login, is_active');
        $this->db->from('users');
        $this->db->where('is_active', 1);
        $this->db->limit($limit, $offset);
        $this->db->order_by('username', 'ASC');
        return $this->db->get()->result();
    }

    public function count_all()
    {
        $this->db->from('users');
        $this->db->where('is_active', 1);
        return $this->db->count_all_results();
    }

    // Method untuk update last_login (jika kolom tersedia)
    public function update_last_login($user_id)
    {
        $this->db->set('last_login', date('Y-m-d H:i:s'));
        $this->db->set('last_activity', date('Y-m-d H:i:s'));
        $this->db->where('id', $user_id);

        if (!$this->db->update('users')) {
            log_message('error', print_r($this->db->error(), TRUE));
            return false;
        }
        return true;
    }

    public function update_last_logout($user_id)
    {
        $this->db->set('last_logout', date('Y-m-d H:i:s'));
        $this->db->where('id', $user_id);
        return $this->db->update('users');
    }
}
