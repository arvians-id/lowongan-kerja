<?php

namespace App\Controllers;

use App\Models\AuthToken_model;
use App\Models\UsersBlacklist_model;
use App\Models\AuthUsers_model;
use App\Models\DataCategory_model;
use App\Models\Users_model;
use CodeIgniter\I18n\Time;

class Admin extends BaseController
{
    protected $users_m, $usersBlacklist_m, $authUsers_m, $authToken_m, $dataCategory_m;
    public function __construct()
    {
        $this->users_m = new Users_model();
        $this->usersBlacklist_m = new UsersBlacklist_model();
        $this->authUsers_m = new AuthUsers_model();
        $this->authToken_m = new AuthToken_model();
        $this->dataCategory_m = new DataCategory_model();
    }
    public function index()
    {
        $data = [
            'title' => 'Admin | Features Example',
            'sessUser'  => $this->authUsers_m->getUser(),
            'totalUsers' => $this->authUsers_m->where('status', 0)->countAllResults(),
            'totalBL' => $this->authUsers_m->where('status', 1)->countAllResults(),
        ];
        return view('admin/adminPages/index', $data);
    }
    public function users($username = null)
    {
        $cekRole = $this->authUsers_m->where('username', $username)->where('role', 2)->first();
        if ($username != null) {
            if ($cekRole) {
                $data = [
                    'title' => 'Users Profile | Features Example',
                    'sessUser' => $this->authUsers_m->getUser(),
                    'getUser' => $this->authUsers_m->getUserProfile($username)
                ];
                return view('admin/adminPages/usersProfile', $data);
            }
            return false;
        }
        $data = [
            'title' => 'Users | Features Example',
            'sessUser'  => $this->authUsers_m->getUser(),
        ];
        return view('admin/adminPages/users', $data);
    }
    public function users_datatable()
    {
        if ($this->request->isAJAX()) {
            $list = $this->users_m->get_datatables_users();
            $data = [];
            $no = $this->request->getVar('start');
            foreach ($list as $allData) {
                $no++;
                $item = [];
                $item[] = $no;
                $item[] = $allData->username;
                $item[] = $allData->name;
                $item[] = $allData->email;
                $item[] = $allData->gender;
                $item[] = $allData->phone;
                $item[] = "<div class='btn-group mb-3' role='group' aria-label='Basic example'><a href='/admin/users/$allData->username' class='btn btn-primary btn-sm'>Detail</a><a href='javascript:void(0);' onclick='openModal(\"$allData->username\")' class='btn btn-danger btn-sm'>Banned</a></div>";

                $data[] = $item;
            }
            $output = [
                "draw" => $this->request->getVar('draw'),
                "recordsTotal" => $this->users_m->count_all(),
                "recordsFiltered" => $this->users_m->count_filtered(),
                "data" => $data,
                'countUser' => $this->authUsers_m->totalUser('active'),
                'countUserBlacklist' => $this->authUsers_m->totalUser('blacklist'),
            ];
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $output[$csrfName] = $csrfHash;
            echo json_encode($output);
        } else {
            return redirect()->to(previous_url());
        }
    }
    public function modalBlacklist()
    {
        if ($this->request->isAJAX()) {
            $data['username'] = $this->request->getVar('username');
            $view = ['view' => view('admin/adminPages/modal/modalBlacklist', $data)];
            echo json_encode($view);
        } else {
            return redirect()->to(previous_url());
        }
    }
    public function goBlacklist($username)
    {
        if ($this->request->isAJAX()) {
            if (!$this->validate('blacklist')) {
                $view = [
                    'error' => [
                        'exampleRadios' => $this->validation->getError('exampleRadios'),
                        'finished_on' => $this->validation->getError('finished_on'),
                    ]
                ];
            } else {
                $user = $this->authUsers_m->where('username', $username)->first();
                if ($user['role'] != 1) {
                    $data = [
                        'user_id' => $user['id'],
                        'message' => $this->request->getVar('exampleRadios'),
                        'banned_at' => Time::now('Asia/Jakarta'),
                        'finished_on' => $this->request->getVar('finished_on')
                    ];
                    $this->usersBlacklist_m->insertBlacklist($data, $username);
                    $view = ['success' => 'The user has been blacklisted'];
                }
            }
            $csrf = ['csrfHash' => csrf_hash(), 'csrfName' => csrf_token()];
            $data = array_merge($csrf, $view);
            echo json_encode($data);
        } else {
            return redirect()->to(previous_url());
        }
    }
    public function blacklist()
    {
        $data = [
            'title' => 'List Users Blacklist | Features Example',
            'sessUser'  => $this->authUsers_m->getUser()
        ];
        return view('admin/adminPages/blacklist', $data);
    }
    public function blacklist_datatable()
    {
        if ($this->request->isAJAX()) {
            $list = $this->usersBlacklist_m->get_datatables_users();
            $data = [];
            $no = $this->request->getVar('start');
            foreach ($list as $allData) {
                $no++;
                $item = [];
                $item[] = $no;
                $item[] = $allData->username;
                $item[] = $allData->name;
                $item[] = $allData->email;
                $item[] = createMyDate($allData->banned_at);
                $item[] = createMyDate($allData->finished_on);
                $item[] = "<div class='btn-group mb-3' role='group' aria-label='Basic example'><a href='/admin/users/$allData->username' class='btn btn-primary btn-sm'>Detail</a><a href='javascript:void(0);' onclick='openModal(\"$allData->username\")' class='btn btn-danger btn-sm'>Unbanned</a></div>";

                $data[] = $item;
            }
            $output = [
                "draw" => $this->request->getVar('draw'),
                "recordsTotal" => $this->usersBlacklist_m->count_all(),
                "recordsFiltered" => $this->usersBlacklist_m->count_filtered(),
                "data" => $data,
            ];
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $output[$csrfName] = $csrfHash;
            echo json_encode($output);
        } else {
            return redirect()->to(previous_url());
        }
    }
    public function modalUnblacklist()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getVar('username');
            $data['data'] = $this->usersBlacklist_m->getUsersBlacklist($username);
            $view = ['view' => view('admin/adminPages/modal/modalUnblacklist', $data)];
            echo json_encode($view);
        } else {
            return redirect()->to(previous_url());
        }
    }
    public function goUnblacklist($id)
    {
        if ($this->request->isAJAX()) {
            $this->usersBlacklist_m->removeBlacklist($id);
            $view = ['success' => 'The user has been Unblacklisted'];
            $csrf = ['csrfName' => csrf_token(), 'csrfHash' => csrf_hash()];
            $data = array_merge($csrf, $view);
            echo json_encode($data);
        } else {
            return redirect()->to(previous_url());
        }
    }
    public function profile()
    {
        $data = [
            'title' => 'Admin Profile | Features Example',
            'sessUser'  => $this->authUsers_m->getUser()
        ];
        return view('admin/adminPages/adminProfile', $data);
    }
    public function goEditProfile()
    {
        if ($this->request->isAJAX()) {
            if (!$this->validate('edit_profile')) {
                $view = [
                    'error' => [
                        'name' => $this->validation->getError('name'),
                        'phone' => $this->validation->getError('phone'),
                        'birthdate' => $this->validation->getError('birthdate'),
                        'gender' => $this->validation->getError('gender'),
                        'age' => $this->validation->getError('age'),
                        'address' => $this->validation->getError('address'),
                        'photo' => $this->validation->getError('photo'),
                    ]
                ];
            } else {
                $photo = $this->request->getFile('photo');
                $cekPhoto = $this->authUsers_m->getUser();
                if ($photo->getError() == 4) {
                    $randomName = $cekPhoto['photo'];
                } else {
                    if ($cekPhoto['photo'] != 'default.png') {
                        unlink('image/profile/' . $cekPhoto['photo']);
                    }
                    $randomName = $photo->getRandomName();
                    $photo->move('image/profile', $randomName);
                }
                $data = [
                    'id' => $this->session->get('id'),
                    'name' => htmlspecialchars(trim($this->request->getVar('name'))),
                    'phone' => htmlspecialchars(trim($this->request->getVar('phone'))),
                    'birthdate' => htmlspecialchars(trim($this->request->getVar('birthdate'))),
                    'gender' => htmlspecialchars(trim($this->request->getVar('gender'))),
                    'age' => htmlspecialchars(trim($this->request->getVar('age'))),
                    'address' => htmlspecialchars(trim($this->request->getVar('address'))),
                    'photo' => $randomName,
                ];
                $this->users_m->save($data);
                $view = ['success' => 'Your profile has been updated', 'data' => $data];
            }
            $csrf = ['csrfName' => csrf_token(), 'csrfHash' => csrf_hash()];
            $data = array_merge($csrf, $view);
            echo json_encode($data);
        } else {
            return redirect()->to(previous_url());
        }
    }
    public function password()
    {
        $data = [
            'title' => 'Changes Password | Features Example',
            'sessUser'  => $this->authUsers_m->getUser()
        ];
        return view('admin/adminPages/changesPassword', $data);
    }
    public function goChangesPassword()
    {
        if (!$this->validate('changes_password')) {
            $view = [
                'error' => [
                    'cpassword' => $this->validation->getError('cpassword'),
                    'password' => $this->validation->getError('password'),
                    'rpassword' => $this->validation->getError('rpassword'),
                ]
            ];
        } else {
            $password = $this->request->getVar('password');
            $cpassword = $this->request->getVar('cpassword');

            $getUser = $this->authUsers_m->getUser();
            if (password_verify($cpassword, $getUser['password'])) {
                if ($password != $cpassword) {
                    // Update
                    $data = [
                        'id' => $this->session->get('id'),
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    ];
                    $this->authUsers_m->save($data);
                    // Send Email
                    $token = bin2hex(random_bytes(32));
                    $message = 'changespassword';
                    $dataToken = [
                        'email' => $this->session->get('email'),
                        'token' => $token,
                        'message' => $message,
                        'created_at' => time(),
                    ];
                    $cekUserSpam = $this->authToken_m->where('email', $this->session->get('email'))->where('message', $message)->first();
                    if ($cekUserSpam) {
                        $this->authToken_m->replaceToken($dataToken, $this->session->get('email'), $message);
                    } else {
                        $this->authToken_m->save($dataToken);
                    }
                    $this->_sendEmail($token, $message);
                    $view = ['success' => 'Password changed successfully'];
                } else {
                    $view = ['blocked' => 'Password must be different than before'];
                }
            } else {
                $view = ['blocked' => 'Your password is wrong'];
            }
        }
        $csrf = ['csrfHash' => csrf_hash(), 'csrfName' => csrf_token()];
        $data = array_merge($csrf, $view);
        echo json_encode($data);
    }
    public function email()
    {
        if ($this->session->has('id')) {
            $cekUser = $this->authUsers_m->where('id', session()->get('id'))->where('email', session()->get('email'))->first();
            if ($cekUser == false) {
                delete_cookie('cookies_me');
                delete_cookie('cookies_log');
                session()->remove(['id', 'email', 'role', 'username', 'isLoggedIn']);
                return redirect()->to('/')->withCookies()->with('error', 'You have logged out, please login again');
            }
        } else {
            return redirect()->to('/')->with('error', 'You have to log in first');
        }
        $data = [
            'title' => 'Changes Email | Features Example',
            'sessUser'  => $this->authUsers_m->getUser()
        ];
        return view('admin/adminPages/changesEmail', $data);
    }
    public function goChangesEmail()
    {
        if (!$this->validate('changesemail')) {
            $view = [
                'error' => [
                    'email' => $this->validation->getError('email'),
                    'password' => $this->validation->getError('password'),
                ]
            ];
        } else {
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $cekUser = $this->authUsers_m->where('email', $email)->first();
            if (!$cekUser) {
                $getUser = $this->authUsers_m->getUser();
                if (password_verify($password, $getUser['password'])) {
                    $token = bin2hex(random_bytes(32));
                    $message = 'changesemail';
                    $dataToken = [
                        'email' => $this->session->get('email'),
                        'token' => $token,
                        'message' => $message,
                        'created_at' => time(),
                    ];
                    $this->authToken_m->save($dataToken);
                    $this->_sendEmail($token, $message, $email);
                    $view = ['success' => 'Please check your email for next steps'];
                } else {
                    $view = ['blocked' => 'Your password is wrong'];
                }
            } else {
                $view = ['blocked' => 'Email already registered'];
            }
        }
        $csrf = ['csrfHash' => csrf_hash(), 'csrfName' => csrf_token()];
        $data = array_merge($csrf, $view);
        echo json_encode($data);
    }
    private function _sendEmail($token, $type, $newEmail = null)
    {
        $this->sendEmail->setFrom('allmygames56@gmail.com', 'Anonymous');
        $email = $this->session->get('email');
        $this->sendEmail->setTo($email);
        if ($type == 'changespassword') {
            $this->sendEmail->setSubject('Password changed successfully');
            $this->sendEmail->setMessage('You have made a password change, If you weren\'t the one who made the password change, <a href="' . base_url() . '/auth/reset?email=' . $email . '&token=' . $token . '">Click this link</a>');
        } else if ($type == 'changesemail') {
            $this->sendEmail->setSubject('Change email account');
            $this->sendEmail->setMessage('We accept requests for email changes to ' . $newEmail . '. Click this link to take the next steps, <a href="' . base_url() . '/admin/changesemail?email=' . $email . '&to=' . $newEmail . '&token=' . $token . '">Click this link</a>');
        }

        return $this->sendEmail->send(true);
    }
    public function changesemail()
    {
        $email = $this->request->getVar('email');
        $token = $this->request->getVar('token');
        $newEmail = $this->request->getVar('to');
        $message = 'changesemail';
        $cekUser = $this->authToken_m->where('email', $email)->where('token', $token)->first();
        if ($cekUser) {
            if (time() - $cekUser['created_at'] < 60 * 10) {
                $this->authUsers_m->changesemail($email, $newEmail);
                $this->authToken_m->deleteToken($email, $message);
                $this->session->set('email', $newEmail);
                return redirect()->to('/admin/email')->with('success', 'Email change was successfully');
            } else {
                $this->authToken_m->deleteToken($email, $message);
                return redirect()->to('/admin/email')->with('error', 'Invalid Credentials');
            }
        } else {
            return redirect()->to('/admin/email')->with('error', 'Invalid Credentials');;
        }
    }
    public function job()
    {
        $data = [
            'title' => 'Create Job | Features Example',
            'data_category' => $this->dataCategory_m->findAll(),
            'sessUser'  => $this->authUsers_m->getUser(),
        ];

        return view('admin/adminPages/job', $data);
    }
    public function applicant()
    {
        $data = [
            'title' => 'Manage Applicant | Features Example',
            'sessUser'  => $this->authUsers_m->getUser(),
        ];

        return view('admin/adminPages/applicant', $data);
    }
    public function schedule()
    {
        $data = [
            'title' => 'Manage Schedule | Features Example',
            'sessUser'  => $this->authUsers_m->getUser(),
        ];

        return view('admin/adminPages/schedule', $data);
    }
    public function setting($setting = null)
    {
        if ($setting != null) {
            $data = [
                'title' => 'Manage Job | Features Example',
                'sessUser'  => $this->authUsers_m->getUser(),
            ];

            return view('admin/adminPages/settingJob', $data);
        }
        $data = [
            'title' => 'Setting | Features Example',
            'sessUser'  => $this->authUsers_m->getUser(),
        ];

        return view('admin/adminPages/setting', $data);
    }
}
