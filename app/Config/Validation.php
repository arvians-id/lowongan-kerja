<?php

namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\MyRules::class,
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
		\Denis303\ReCaptcha\Validation\ReCaptchaRules::class
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $registration = [
		'username' => [
			'rules' => 'required|alpha_numeric|is_unique[auth_users.username]|min_length[6]|max_length[12]',
			'errors' => [
				'required' => 'REQUIRED',
				'min_length' => 'TOO SHORT',
				'alpha_numeric' => 'INVALID USERNAME',
				'is_unique' => 'ALREADY TAKEN',
				'max_length' => 'TOO LONG',
			]
		],
		'email' => [
			'rules' => 'required|is_unique[auth_users.email]|valid_email',
			'errors' => [
				'required' => 'REQUIRED',
				'is_unique' => 'ALREADY TAKEN',
				'valid_email' => 'INVALID EMAIL'
			]
		],
		'password' => [
			'rules' => 'required|min_length[6]|matches[rpassword]|password_check',
			'errors' => [
				'required' => 'REQUIRED',
				'min_length' => 'TOO SHORT',
				'matches' => 'NOT MATCH',
				'password_check' => 'INVALID PASSWORD'
			]
		],
		'rpassword' => [
			'rules' => 'required|min_length[6]|matches[password]|password_check',
			'errors' => [
				'required' => 'REQUIRED',
				'min_length' => 'TOO SHORT',
				'matches' => 'NOT MATCH',
				'password_check' => 'INVALID PASSWORD'
			]
		],
	];

	public $login = [
		'email' => [
			'rules' => 'required|valid_email',
			'errors' => [
				'required' => 'REQUIRED',
				'valid_email' => 'INVALID EMAIL'
			]
		],
		'password' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'REQUIRED'
			]
		]
	];
	public $forgotpassword = [
		'email' => [
			'rules' => 'required|valid_email',
			'errors' => [
				'required' => 'REQUIRED',
				'valid_email' => 'INVALID EMAIL'
			]
		]
	];
	public $resetpassword = [
		'password' => [
			'rules' => 'required|min_length[6]|matches[rpassword]|password_check',
			'errors' => [
				'required' => 'REQUIRED',
				'min_length' => 'TOO SHORT',
				'matches' => 'NOT MATCH',
				'password_check' => 'INVALID PASSWORD'
			]
		],
		'rpassword' => [
			'rules' => 'required|min_length[6]|matches[password]|password_check',
			'errors' => [
				'required' => 'REQUIRED',
				'min_length' => 'TOO SHORT',
				'matches' => 'NOT MATCH',
				'password_check' => 'INVALID PASSWORD'
			]
		],
	];
	public $sendverification = [
		'email' => [
			'rules' => 'required|valid_email',
			'errors' => [
				'required' => 'REQUIRED',
				'valid_email' => 'INVALID EMAIL'
			]
		],
	];
	public $blacklist = [
		'exampleRadios' => [
			'rules' => 'permit_empty',
		],
		'finished_on'  => [
			'rules' => 'required',
			'errors' => [
				'required' => 'REQUIRED'
			]
		],
	];
	public $edit_profile = [
		'name' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'REQUIRED',
			]
		],
		'phone' => [
			'rules' => 'required|numeric|min_length[10]|max_length[13]',
			'errors' => [
				'required' => 'REQUIRED',
				'numeric' => 'INVALID NUMBER PHONE',
				'min_length' => 'INVALID NUMBER PHONE',
				'max_length' => 'INVALID NUMBER PHONE'
			]
		],
		'birthdate' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'REQUIRED'
			]
		],
		'gender' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'REQUIRED'
			]
		],
		'age' => [
			'rules' => 'required|numeric',
			'errors' => [
				'required' => 'REQUIRED',
				'numeric' => 'INVALID AGE'
			]
		],
		'address' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'REQUIRED',
			]
		],
		'photo' => [
			'rules' => 'is_image[photo]|mime_in[photo,image/png,image/jpg,image/jpeg]|max_size[photo,1024]',
			'errors' => [
				'max_size' => 'TOO HIGH',
				'mime_in' => 'ONLY RECEIVED JPG, JPEG, PNG',
				'is_image' => 'INVALID PHOTO'
			]
		]
	];
	public $changes_password = [
		'cpassword' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'REQUIRED'
			]
		],
		'password' => [
			'rules' => 'required|min_length[6]|matches[rpassword]|password_check',
			'errors' => [
				'required' => 'REQUIRED',
				'min_length' => 'TOO SHORT',
				'matches' => 'NOT MATCH',
				'password_check' => 'INVALID PASSWORD'
			]
		],
		'rpassword' => [
			'rules' => 'required|min_length[6]|matches[password]|password_check',
			'errors' => [
				'required' => 'REQUIRED',
				'min_length' => 'TOO SHORT',
				'matches' => 'NOT MATCH',
				'password_check' => 'INVALID PASSWORD'
			]
		]
	];
	public $changesemail = [
		'email' => [
			'rules' => 'required|valid_email',
			'errors' => [
				'required' => 'REQUIRED',
				'valid_email' => 'INVALID EMAIL'
			]
		],
		'password' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'REQUIRED'
			]
		]
	];
}
