<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Register new user
     * @param array $data User data
     * @return bool|int Insert ID if success, false if failed
     */
    public function register($data)
    {
        $user_data = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'is_active' => 1 // Set user as active by default
        ];

        $this->db->insert('users', $user_data);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * User login
     * @param string $username
     * @param string $password
     * @return object|bool User object if success, false if failed
     */
    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->or_where('email', $username); // Allow login with email too
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                // Update last login and activity
                $this->update_last_login($user->id);
                return $user;
            }
        }
        return false;
    }

    /**
     * Get all active users
     * @return array Array of user objects
     */
    public function get_all_users()
    {
        $this->db->where('is_active', 1);
        $this->db->order_by('username', 'ASC');
        return $this->db->get('users')->result();
    }

    /**
     * Search users with pagination
     * @param string|null $search Search term
     * @param int|null $limit Limit per page
     * @param int|null $offset Offset
     * @return array Array of user objects
     */
    public function search_users($search = null, $limit = null, $offset = null)
    {
        $this->db->select('id, username, email, created_at, last_login, last_activity, last_logout, is_active');
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

    /**
     * Count search results
     * @param string|null $search Search term
     * @return int Number of results
     */
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

    /**
     * Get paginated users
     * @param int $limit
     * @param int $offset
     * @return array Array of user objects
     */
    public function get_paginated_users($limit, $offset)
    {
        $this->db->select('id, username, email, created_at, last_login, last_activity, last_logout, is_active');
        $this->db->from('users');
        $this->db->where('is_active', 1);
        $this->db->limit($limit, $offset);
        $this->db->order_by('username', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Count all active users
     * @return int Number of active users
     */
    public function count_all()
    {
        $this->db->from('users');
        $this->db->where('is_active', 1);
        return $this->db->count_all_results();
    }

    /**
     * Update last login and activity time
     * @param int $user_id
     * @return bool True if success, false if failed
     */
    public function update_last_login($user_id)
    {
        $data = [
            'last_login' => date('Y-m-d H:i:s'),
            'last_activity' => date('Y-m-d H:i:s'),
            'is_active' => 1
        ];
        
        $this->db->where('id', $user_id);
        $result = $this->db->update('users', $data);
        
        if (!$result) {
            log_message('error', 'Failed to update last login: ' . print_r($this->db->error(), TRUE));
            return false;
        }
        return true;
    }

    /**
     * Update last activity time
     * @param int $user_id
     * @return bool True if success, false if failed
     */
    public function update_last_activity($user_id)
    {
        $this->db->set('last_activity', date('Y-m-d H:i:s'));
        $this->db->where('id', $user_id);
        $result = $this->db->update('users');
        
        if (!$result) {
            log_message('error', 'Failed to update last activity: ' . print_r($this->db->error(), TRUE));
            return false;
        }
        return true;
    }

    /**
     * Update last logout time and set inactive
     * @param int $user_id
     * @return bool True if success, false if failed
     */
    public function update_last_logout($user_id)
    {
        $data = [
            'last_logout' => date('Y-m-d H:i:s'),
            'last_activity' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $user_id);
        $result = $this->db->update('users', $data);
        
        if (!$result) {
            log_message('error', 'Failed to update logout status: ' . print_r($this->db->error(), TRUE));
            return false;
        }
        return true;
    }

    /**
     * Get user by ID
     * @param int $user_id
     * @return object|bool User object if found, false if not
     */
    public function get_user_by_id($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    /**
     * Check if username exists
     * @param string $username
     * @return bool True if exists, false if not
     */
    public function username_exists($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('users')->num_rows() > 0;
    }

    /**
     * Check if email exists
     * @param string $email
     * @return bool True if exists, false if not
     */
    public function email_exists($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('users')->num_rows() > 0;
    }

    /**
     * Update user profile
     * @param int $user_id
     * @param array $data
     * @return bool True if success, false if failed
     */
    public function update_profile($user_id, $data)
    {
        $this->db->where('id', $user_id);
        $result = $this->db->update('users', $data);
        
        if (!$result) {
            log_message('error', 'Failed to update profile: ' . print_r($this->db->error(), TRUE));
            return false;
        }
        return true;
    }

    /**
     * Change user password
     * @param int $user_id
     * @param string $new_password
     * @return bool True if success, false if failed
     */
    public function change_password($user_id, $new_password)
    {
        $this->db->set('password', password_hash($new_password, PASSWORD_DEFAULT));
        $this->db->where('id', $user_id);
        $result = $this->db->update('users');
        
        if (!$result) {
            log_message('error', 'Failed to change password: ' . print_r($this->db->error(), TRUE));
            return false;
        }
        return true;
    }
}