<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use CodeIgniter\I18n\Time;

class UsersSeeder extends Seeder
{
	public function run()
	{
		$faker = \Faker\Factory::create('id_ID');
		for ($i = 0; $i < 200; $i++) {
			$authUsers = [
				'username'      => $faker->userName,
				'email'         => $faker->email,
				'password'      => password_hash('WiddyGanteng', PASSWORD_DEFAULT),
				'cookies_log'   => '',
				'cookies_me'    => '',
				'is_active'     => 1,
				'role'          => 2,
				'status'        => 0,
				'created_at'    => Time::now('Asia/Jakarta'),
				'updated_at'    => Time::now('Asia/Jakarta'),
			];

			// Using Query Builder
			$this->db->table('auth_users')->insert($authUsers);
			$db = \Config\Database::connect();
			$id = $db->insertID();
			$users = [
				'user_id'       => $id,
				'name'          => $faker->name,
				'birthdate'     => 'Unknown',
				'gender'        => $faker->randomElement(['Male', 'Female']),
				'age'           => $faker->biasedNumberBetween(18, 60),
				'phone'         => $faker->phoneNumber,
				'photo'         => 'default.png',
			];
			$this->db->table('users')->insert($users);
		}
	}
}
