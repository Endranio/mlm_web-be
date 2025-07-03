<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePairingBonus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type'=>'INT','auto_increment'=>true],
            'user_id'       => ['type'=>'INT'],
            'point_left'    => ['type'=>'INT','default'=>0],
            'point_right'   => ['type'=>'INT','default'=>0],
            'bonus'         => ['type'=>'INT','default'=>0],
            'created_at'    => ['type'=>'TIMESTAMP','default'=>new RawSql('CURRENT_TIMESTAMP')]
        ]);
        $this->forge->addKey('id',true);
        $this->forge->createTable('pairing_bonus');
    }

    public function down()
    {
        //
    }
}
