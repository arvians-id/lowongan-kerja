<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\AuthUsers_model;

class NoAuth implements FilterInterface
{
    protected $authUser_m;
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        helper('cookie');
        $this->authUser_m = new AuthUsers_model();
        $session = session()->get('email');
        $cekLoginUser = $this->authUser_m->where('cookies_log', get_cookie('cookies_log'))->first();
        if (!$cekLoginUser || !$session || $cekLoginUser['status'] == 1) {
            delete_cookie('cookies_me');
            delete_cookie('cookies_log');
            session()->remove(['id', 'email', 'role', 'username', 'isLoggedIn']);
            return redirect()->to('/')->withCookies()->with('error', 'Please login first');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
