<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthUsers_model extends Model
{
    // Core
    protected $table = 'auth_users';
    protected $allowedFields = ['username', 'email', 'password', 'cookies_log', 'cookies_me', 'is_active', 'role', 'status'];
    protected $useTimestamps = true;
    // Optional
    protected $table_users = 'users';

    public function registration($data, $tempName)
    {
        $db = \Config\Database::connect();
        $this->db->table($this->table)->insert($data);
        $userID = $db->insertID();
        $dataProfil = [
            'user_id' => $userID,
            'name' => $tempName,
            'birthdate' => '',
            'gender' => '',
            'age' => '',
            'phone' => '',
            'address' => '',
            'photo' => 'default.png',
        ];
        return $this->db->table($this->table_users)->insert($dataProfil);
    }
    public function getUser()
    {
        $builder = $this->db->table("$this->table a");
        $builder->select('*');
        $builder->join("$this->table_users b", 'a.id = b.user_id');
        $builder->where('a.email', session()->get('email'));
        return $builder->get()->getRowArray();
    }
    public function getUserProfile($username)
    {
        $builder = $this->db->table("$this->table a");
        $builder->join("$this->table_users b", 'a.id = b.user_id');
        $builder->where('a.username', $username);
        return $builder->get()->getRowArray();
    }
    public function totalUser($status)
    {
        if ($status == 'active') {
            return $this->db->table($this->table)->where('status', 0)->countAllResults();
        } else {
            return $this->db->table($this->table)->where('status', 1)->countAllResults();
        }
    }
    public function insertCookiesMe($data, $email)
    {
        return $this->db->table($this->table)->set('cookies_me', $data)->where('email', $email)->update();
    }
    public function insertCookiesLog($data, $email)
    {
        return $this->db->table($this->table)->set('cookies_log', $data)->where('email', $email)->update();
    }
    public function deleteUser($email)
    {
        $getID = $this->db->table($this->table)->where('email', $email)->get()->getRowArray();
        $this->db->table($this->table)->where('email', $email)->delete();
        $this->db->table($this->table_users)->where('user_id', $getID['id'])->delete();
    }
    public function changeIsActive($email)
    {
        return $this->db->table($this->table)->set('is_active', 1)->where('email', $email)->update();
    }
    public function changePassword($password, $email)
    {
        return $this->db->table($this->table)->set('password', $password)->where('email', $email)->update();
    }
    public function changesemail($email, $newEmail)
    {
        return $this->db->table($this->table)->set('email', $newEmail)->where('email', $email)->update();
    }
}
