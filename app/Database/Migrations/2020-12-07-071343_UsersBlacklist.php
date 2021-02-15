<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersBlacklist extends Migration
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
			'user_id' => [
				'type'				=> 'INT',
				'constraint'		=> 11,
			],
			'message' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 256,
			],
			'banned_at' => [
				'type'				=> 'DATETIME',
			],
			'finished_on' => [
				'type'				=> 'DATETIME',
			]
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('users_blacklist');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users_blacklist');
	}
}
