<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
			'name' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 128,
			],
			'birthdate' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 128,
				'null'				=> true,
			],
			'gender' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 128,
				'null'				=> true
			],
			'age' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 11,
				'null'				=> true
			],
			'phone' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 128,
				'null'				=> true
			],
			'address' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 128,
				'null'				=> true
			],
			'photo' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> 256,
				'null'				=> true
			]
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
