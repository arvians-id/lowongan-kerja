<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersBlacklist_model extends Model
{
    // Core
    protected $table = 'users_blacklist';
    protected $allowedFields = ['user_id', 'message', 'banned_at', 'finished_on'];
    // protected $useTimestamps = true;
    // Optional
    protected $table_users = 'users';
    protected $table_auth = 'auth_users';
    protected $column_order_users = ['users_blacklist.id', 'username', 'name', null, 'banned_at', 'finished_on', null];
    protected $column_search_users = ['username', 'name', 'email'];
    protected $order = ['users_blacklist.id' => 'desc'];

    // Datatables
    private function _getQueryUsers($builder)
    {
        $builder->select('*');
        $builder->join($this->table_auth, "$this->table_auth.id = $this->table.user_id");
        $builder->join($this->table_users, "$this->table_users.user_id = $this->table_auth.id");
        $builder->where("$this->table_auth.role", 2);
        $builder->where("$this->table_auth.status", 1);

        $i = 0;
        foreach ($this->column_search_users as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $builder->groupStart();
                    $builder->like($item, $_POST['search']['value']);
                } else {
                    $builder->orLike($item, $_POST['search']['value']);
                }
                if (count($this->column_search_users) - 1 == $i)
                    $builder->groupEnd();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $builder->orderBy($this->column_order_users[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $builder->orderBy(key($order), $order[key($order)]);
        }
    }
    public function get_datatables_users()
    {
        $builder = $this->db->table($this->table);
        $this->_getQueryUsers($builder);
        if ($_POST['length'] != -1) {
            $builder->limit($_POST['length'], $_POST['start']);
        }
        return $builder->get()->getResult();
    }
    public function count_filtered()
    {
        $builder = $this->db->table($this->table);
        $this->_getQueryUsers($builder);
        return $builder->countAllResults();
    }
    public function count_all()
    {
        $builder = $this->db->table($this->table);
        return $builder->countAllResults();
    }
    public function insertBlacklist($data, $username)
    {
        $db = \Config\Database::connect();
        $builder = $this->db->table($this->table);
        $builder->insert($data);
        if ($db->affectedRows() > 0) {
            return $this->db->table($this->table_auth)->set('status', 1)->where('username', $username)->update();
        }
    }
    public function removeBlacklist($id)
    {
        $db = \Config\Database::connect();
        $builder = $this->db->table($this->table);
        $builder->where('user_id', $id)->delete();
        if ($db->affectedRows() > 0) {
            return $this->db->table($this->table_auth)->set('status', 0)->where('id', $id)->update();
        }
    }
    public function getUsersBlacklist($username)
    {
        $builder = $this->db->table($this->table);
        $builder->join($this->table_auth, "$this->table_auth.id = $this->table.user_id");
        $builder->where("$this->table_auth.username", $username);
        return $builder->get()->getRowArray();
    }
}
