<?php

namespace App\Models;

use CodeIgniter\Model;

class Users_model extends Model
{
    // Core
    protected $table = 'users';
    protected $allowedFields = ['user_id', 'name', 'birthdate', 'gender', 'age', 'phone', 'address', 'photo'];
    // protected $useTimestamps = true;
    //Optional
    protected $column_order_users = ['auth_users.id', 'username', 'name', null, 'gender', null, null];
    protected $column_search_users = ['username', 'name', 'email', 'gender', 'phone'];
    protected $order = ['auth_users.id' => 'desc'];
    protected $table_auth = 'auth_users';

    // Datatables
    private function _getQueryUsers($builder)
    {
        $builder->select('*');
        $builder->join($this->table_auth, "$this->table_auth.id = $this->table.user_id");
        $builder->where("$this->table_auth.role", 2);
        $builder->where("$this->table_auth.status", 0);

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

    // Query
}
