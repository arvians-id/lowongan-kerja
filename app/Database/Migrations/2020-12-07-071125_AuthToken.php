<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuthToken extends Migration
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
			'email' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 128,
			],
			'token' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 256,
				'null'				=> true,
			],
			'message' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 256,
				'null'				=> true,
			],
			'created_at' => [
				'type'				=> 'INT',
				'null'				=> true
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('auth_token');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('auth_token');
	}
}
