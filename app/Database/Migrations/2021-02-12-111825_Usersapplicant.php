<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usersapplicant extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true
			],
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 50
			],
			'id_category' => [
				'type' => 'INT',
				'constraint' => 4
			],
			'expired' => [
				'type' => 'DATE',
			],
			'note' => [
				'type' => 'VARCHAR',
				'constraint' => 256
			],
			'id_status' => [
				'type' => 'INT',
				'constraint' => 2
			],
			'id_interview' => [
				'type' => 'INT',
				'constraint' => 2
			],
			'image' => [
				'type' => 'VARCHAR',
				'constraint' => 256
			],
			'vacancy' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'sallary' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'created_at' => [
				'type' => 'DATETIME',
			],
			'updated_at' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users_applicant');
	}

	public function down()
	{
		$this->forge->dropTable('users_applicant');
	}
}
