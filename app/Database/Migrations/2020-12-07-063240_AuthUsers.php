<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuthUsers extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'				=> 'INT',
				'constraint'		=> 11,
				'unsigned'			=> true,
				'auto_increment'	=> true
			],
			'username' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 128,
			],
			'email' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 128,
			],
			'password' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 256,
				'null'				=> true,
			],
			'cookies_log' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 256,
			],
			'cookies_me' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 256,
			],
			'is_active' => [
				'type'				=> 'INT',
				'constraint'		=> 1,
				'null'				=> true
			],
			'role' => [
				'type'				=> 'INT',
				'constraint'		=> 3,
				'null'				=> true
			],
			'status' => [
				'type'				=> 'INT',
				'constraint'		=> 1,
				'null'				=> true
			],
			'created_at' => [
				'type'				=> 'DATETIME',
				'null'				=> true
			],
			'updated_at' => [
				'type'				=> 'DATETIME',
				'null'				=> true
			]
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('auth_users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('auth_users');
	}
}
