<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
        'id'           => ['type' => 'INT', 'auto_increment' => true],
        'username'     => ['type' => 'VARCHAR', 'constraint' => 100,'unique'=> true],
        'password'     => ['type' => 'VARCHAR', 'constraint' => 255],
        'sponsor_id'   => ['type' => 'INT', 'null' => true],
        'upline_id'    => ['type' => 'INT', 'null' => true],
        'position'     => ['type' => 'ENUM("left","right")', 'null' => true],
        'point_left'   => ['type' => 'INT', 'default' => 0],
        'point_right'  => ['type' => 'INT', 'default' => 0],
        'saldo'        => ['type' => 'INT', 'default' => 0],
        'created_at'   => ['type' => 'TIMESTAMP','null'=> false, 'default' => new RawSql('CURRENT_TIMESTAMP')],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('users');
    }

    public function down()
    {
         $this->forge->dropTable('users');
    }
}
