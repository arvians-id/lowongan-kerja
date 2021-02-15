<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Datacategory extends Migration
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
			'category' => [
				'type' => 'VARCHAR',
				'constraint' => 50
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('data_category');
	}

	public function down()
	{
		$this->forge->dropTable('data_category');
	}
}
