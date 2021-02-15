<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Datainterview extends Migration
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
			'id_applicant' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'place_of_interview' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => true,
			],
			'date_time' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'interview_with' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => true,
			],
			'phone_number' => [
				'type' => 'VARCHAR',
				'constraint' => 13,
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('data_interview');
	}

	public function down()
	{
		$this->forge->dropTable('data_interview');
	}
}
