<?php

namespace App\Filters;

use App\Models\AuthUsers_model;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    protected $authUsers_m;
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        $session = session()->get('isLoggedIn');
        if ($session) {
            return redirect()->to('/admin');
        }
        helper('cookie');
        $this->authUsers_m = new AuthUsers_model();
        $getCookie = get_cookie('cookies_me');
        $cekUser = $this->authUsers_m->where('cookies_me', $getCookie)->first();
        if ($cekUser) {
            $data = [
                'id' => $cekUser['id'],
                'email' => $cekUser['email'],
                'username' => $cekUser['username'],
                'role' => $cekUser['role'],
                'isLoggedIn' => true
            ];
            session()->set($data);
            return redirect()->to('/admin');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
