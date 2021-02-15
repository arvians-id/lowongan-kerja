<?php

namespace App\Controllers;

use App\Models\AuthToken_model;
use App\Models\AuthUsers_model;
use App\Models\UsersBlacklist_model;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
	protected $authUsers_m, $usersBlacklist_m, $authToken_m;
	public function __construct()
	{
		$this->authUsers_m = new AuthUsers_model();
		$this->usersBlacklist_m = new UsersBlacklist_model();
		$this->authToken_m = new AuthToken_model();
	}
	public function index()
	{
		$data = [
			'title' => 'Login Now | Features Example',
		];
		return view('auth/authPages/index', $data);
	}
	public function login()
	{
		if ($this->request->isAJAX()) {
			if (!$this->validate('login')) {
				$view = [
					'error' => [
						'email' => $this->validation->getError('email'),
						'password' => $this->validation->getError('password')
					]
				];
			} else {
				$email = htmlspecialchars(trim($this->request->getVar('email')));
				$password = htmlspecialchars(trim($this->request->getVar('password')));
				$rememberme = $this->request->getVar('rememberme');

				$cekUser = $this->authUsers_m->where('email', $email)->first();
				$cekBlacklist = $this->authUsers_m->where('email', $email)->where('status', 0)->first();
				if ($cekUser) {
					if (password_verify($password, $cekUser['password'])) {
						if ($cekBlacklist) {
							if ($cekUser['is_active'] != 0) {
								$data = [
									'id' => $cekUser['id'],
									'email' => $cekUser['email'],
									'username' => $cekUser['username'],
									'role' => $cekUser['role'],
									'isLoggedIn' => true
								];
								$this->session->set($data);
								if (isset($rememberme)) {
									$valueToken = bin2hex(random_bytes(32));
									set_cookie('cookies_me', $valueToken, time() + (60 * 60 * 24));
									$this->authUsers_m->insertCookiesMe($valueToken, $cekUser['email']);
								}
								$valueToken = bin2hex(random_bytes(32));
								set_cookie('cookies_log', $valueToken, time() + (10 * 365 * 24 * 60 * 60));
								$this->authUsers_m->insertCookiesLog($valueToken, $cekUser['email']);
								$view = ['success' => '/admin'];
							} else {
								$view = ['blocked' => 'Please activate your account'];
							}
						} else {
							$message = $this->usersBlacklist_m->where('email', $email)->first();
							$view = ['blocked' => $message['message']];
						}
					} else {
						$view = ['blocked' => 'Email or password is doesnt exist'];
					}
				} else {
					$view = ['blocked' => 'User not found'];
				}
			}
			$csrf = ['csrfHash' => csrf_hash(), 'csrfName' => csrf_token()];
			$data = array_merge($view, $csrf);
			echo json_encode($data);
		} else {
			return redirect()->to(previous_url());
		}
	}
	public function registration()
	{
		$data = [
			'title' => 'Create Your Account | Features Example',
		];
		return view('auth/authPages/register', $data);
	}
	public function register()
	{
		if ($this->request->isAJAX()) {
			if (!$this->validate('registration')) {
				$view = [
					'error' => [
						'username' => $this->validation->getError('username'),
						'email' => $this->validation->getError('email'),
						'password' => $this->validation->getError('password'),
						'rpassword' => $this->validation->getError('rpassword'),
					]
				];
			} else {
				$username = htmlspecialchars(trim($this->request->getVar('username')));
				$email = htmlspecialchars(trim($this->request->getVar('email')));
				$password = $this->request->getVar('password');
				$customCheckRegister = $this->request->getVar('customCheckRegister');
				if (isset($customCheckRegister)) {
					$data = [
						'username'		=> $username,
						'email'			=> $email,
						'password'		=> password_hash($password, PASSWORD_DEFAULT),
						'is_active'		=> 0,
						'role'			=> 1,
						'status'		=> 0,
						'created_at'	=> Time::now('Asia/Jakarta'),
						'updated_at'	=> Time::now('Asia/Jakarta'),
					];
					$token = bin2hex(random_bytes(32));
					$message = 'activation';
					$dataToken = [
						'email' => $email,
						'token' => $token,
						'message' => $message,
						'created_at' => time()
					];
					$this->authToken_m->save($dataToken);
					$this->authUsers_m->registration($data, $username);

					$this->_sendEmail($token, $email, $message);
					$view = ['success' => 'Successfuly! Please check your mail for activate'];
				} else {
					$view = ['blocked' => 'Please click I agree with the privacy and policy'];
				}
			}
			$csrf = ['csrfHash' => csrf_hash(), 'csrfName' => csrf_token()];
			$data = array_merge($view, $csrf);
			echo json_encode($data);
		} else {
			return redirect()->to(previous_url());
		}
	}
	public function verification()
	{
		$data = [
			'title' => 'Resend Mail Verification | Features Example',
		];
		return view('auth/authPages/verification', $data);
	}
	public function sendverification()
	{
		if ($this->request->isAJAX()) {
			if (!$this->validate('sendverification')) {
				$view = [
					'error' => [
						'email' => $this->validation->getError('email')
					]
				];
			} else {
				$email = htmlspecialchars(trim($this->request->getVar('email')));
				$cekUser = $this->authUsers_m->where('email', $email)->first();
				$cekActive = $this->authUsers_m->where('email', $email)->where('is_active', 1)->first();
				if ($cekUser) {
					if (!$cekActive) {
						$token = bin2hex(random_bytes(32));
						$message = 'activation';
						$dataToken = [
							'email' => $email,
							'token' => $token,
							'message' => $message,
							'created_at' => time()
						];
						$cekUserSpam = $this->authToken_m->where('email', $email)->where('message', $message)->first();
						if ($cekUserSpam) {
							if (time() - $cekUserSpam['created_at'] < (60 * 10)) {
								$this->authToken_m->replaceToken($dataToken, $email, $message);
								$this->_sendEmail($token, $email, $message);
								$view = ['success' => 'Successfuly! Please check your mail for activate'];
							} else {
								$this->authUsers_m->deleteUser($email);
								$this->authToken_m->deleteToken($email, $message);
								$view = ['blocked' => 'The link to verify your mail has expired. Please create again'];
							}
						} else {
							$this->authToken_m->save($dataToken);
							$this->_sendEmail($token, $email, $message);
							$view = ['success' => 'Successfuly! Please check your mail for activate'];
						}
					} else {
						$view = ['blocked' => 'You have activated email'];
					}
				} else {
					$view = ['blocked' => 'User not found'];
				}
			}
			$csrf = ['csrfHash' => csrf_hash(), 'csrfName' => csrf_token()];
			$data = array_merge($view, $csrf);
			echo json_encode($data);
		} else {
			return redirect()->to(previous_url());
		}
	}
	public function forgot()
	{
		$data = [
			'title' => 'Reset Your Password | Features Example',
		];
		return view('auth/authPages/forgot', $data);
	}
	public function forgotpassword()
	{
		if ($this->request->isAJAX()) {
			if (!$this->validate('forgotpassword')) {
				$view = [
					'error' => [
						'email' => $this->validation->getError('email')
					]
				];
			} else {
				$email = htmlspecialchars(trim($this->request->getVar('email')));

				$cekUser = $this->authUsers_m->where('email', $email)->where('is_active', 1)->first();
				$cekBlacklist = $this->authUsers_m->where('email', $email)->where('status', 0)->first();
				if ($cekUser) {
					if ($cekBlacklist) {
						$token = bin2hex(random_bytes(32));
						$message = 'resetpassword';
						$dataToken = [
							'email' => $email,
							'token' => $token,
							'message' => $message,
							'created_at' => time()
						];
						$cekUserSpam = $this->authToken_m->where('email', $email)->where('message', $message)->first();
						if ($cekUserSpam) {
							$this->authToken_m->replaceToken($dataToken, $email, $message);
						} else {
							$this->authToken_m->save($dataToken);
						}
						$this->_sendEmail($token, $email, $message);
						$view = ['success' => 'Please check your mail for next steps'];
					} else {
						$messages = $this->usersBlacklist_m->where('email', $email)->first();;
						$view = ['blocked' => $messages['message']];
					}
				} else {
					$view = ['blocked' => 'User not found'];
				}
			}
			$csrf = ['csrfHash' => csrf_hash(), 'csrfName' => csrf_token()];
			$data = array_merge($view, $csrf);
			echo json_encode($data);
		} else {
			return redirect()->to(previous_url());
		}
	}
	private function _sendEmail($token, $email, $type)
	{
		$this->sendEmail->setFrom('allmygames56@gmail.com', 'Anonymous');
		$this->sendEmail->setTo($email);
		if ($type === 'activation') {
			$this->sendEmail->setSubject('Aktivasi Email');
			$this->sendEmail->setMessage("Please verify your email. <a href='" . base_url() . "/auth/verify?email=$email&token=$token'> Activate Now!</a>");
		} elseif ($type == 'resetpassword') {
			$this->sendEmail->setSubject('Forgot Password');
			$this->sendEmail->setMessage("Click this link for reset your password. <a href='" . base_url() . "/auth/reset?email=$email&token=$token'> Reset Password!</a>");
		}
		return $this->sendEmail->send(true);
	}
	// Activation Email
	public function verify()
	{
		$email = $this->request->getVar('email');
		$token = $this->request->getVar('token');
		$message = 'activation';
		$cekUser = $this->authToken_m->where('email', $email)->where('token', $token)->first();
		if ($cekUser) {
			if (time() - $cekUser['created_at'] < (60 * 10)) {
				$this->authUsers_m->changeIsActive($email);
				$this->authToken_m->deleteToken($email, $message);
				return redirect()->to('/')->with('success', 'Activation Successfuly');;
			} else {
				$this->authUsers_m->deleteUser($email);
				$this->authToken_m->deleteToken($email, $message);
				return redirect()->to('/')->with('error', 'Invalid Credentials');;
			}
		} else {
			return redirect()->to('/')->with('error', 'Invalid Credentials');;
		}
	}
	// Forgot Password
	public function reset()
	{
		$email = $this->request->getVar('email');
		$token = $this->request->getVar('token');
		$message = 'resetpassword';
		$cekUser = $this->authToken_m->where('email', $email)->where('token', $token)->first();
		if ($cekUser) {
			if (time() - $cekUser['created_at'] < (60 * 10)) {
				$this->session->set('resetpassword', $email);
				$this->_resetPassword();
			} else {
				$this->authToken_m->deleteToken($email, $message);
				return redirect()->to('/')->with('error', 'Invalid Credentials');;
			}
		} else {
			return redirect()->to('/')->with('error', 'Invalid Credentials');;
		}
	}
	private function _resetPassword()
	{
		if (!$this->session->get('resetpassword')) {
			return redirect()->to('/');
		}
		$data['title'] = 'Reset Your Password Here | Features Example';
		echo view('auth/authPages/changePassword', $data);
	}
	public function resetpassword()
	{
		if ($this->request->isAJAX()) {
			if (!$this->validate('resetpassword')) {
				$view = [
					'error' => [
						'password' => $this->validation->getError('password'),
						'rpassword' => $this->validation->getError('rpassword')
					]
				];
			} else {
				$password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
				$email = $this->session->get('resetpassword');
				$message = 'resetpassword';
				$this->authUsers_m->changePassword($password, $email);
				$this->authToken_m->deleteToken($email, $message);

				$this->session->remove('resetpassword');
				$view = ['success' => '/auth'];
			}
			$csrf = ['csrfHash' => csrf_hash(), 'csrfName' => csrf_token()];
			$data = array_merge($view, $csrf);
			echo json_encode($data);
		} else {
			return redirect()->to(previous_url());
		}
	}
	public function logout()
	{
		delete_cookie('cookies_me');
		delete_cookie('cookies_log');
		$this->session->destroy();
		return redirect()->to('/')->withCookies();
	}
}
