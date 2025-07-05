<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBalanceLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'user_id'         => [
                'type'     => 'INT',
            ],
            'type'            => [
                'type'       => 'ENUM',
                'constraint' => ['in', 'out'],
            ],
            'from_source'     => [
                'type'       => 'ENUM',
                'constraint' => ['sponsor', 'pairing','withdrawal','manual'],
            ],
            'reference_table' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'reference_id'    => [
                'type'     => 'INT',
                'null'     => true,
            ],
            'amount'          => [
                'type'     => 'INT',
            ],
            'created_by'      => [
                'type'     => 'INT',
                'null'     => true,
            ],
            'updated_by'      => [
                'type'     => 'INT',
                'null'     => true,
            ],
            'deleted_by'      => [
                'type'     => 'INT',
                'null'     => true,
            ],
            'created_at'      => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'updated_at'      => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'deleted_at'      => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
       

        $this->forge->createTable('balance_logs');
    }

    public function down()
    {
        $this->forge->dropTable('balance_logs');
    }
}
