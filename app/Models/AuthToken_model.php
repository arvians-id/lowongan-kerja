<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthToken_model extends Model
{
    protected $table = 'auth_token';
    protected $allowedFields = ['email', 'token', 'message', 'created_at'];
    // protected $useTimestamps = true;

    public function replaceToken($data, $email, $message)
    {
        return $this->db->table($this->table)->set($data)->where('email', $email)->where('message', $message)->update();
    }
    public function deleteToken($email, $message)
    {
        return $this->db->table($this->table)->where('email', $email)->where('message', $message)->delete();
    }
}
