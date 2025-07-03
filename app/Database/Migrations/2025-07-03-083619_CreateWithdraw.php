<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
class CreateWithdraw extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type'=>'INT','auto_increment' => true],
            'user_id'           => ['type'=>'INT'],
            'ammount'           => ['type'=>'INT'],
            'status'            => ['type'=>'ENUM("pending","approved","reject")','default' => 'pending'],
            'requested_at'      => ['TIMESTAMP','default' => new RawSql('CURRENT_TIMESTAMP')]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('withdraw');
    }

    public function down()
    {
        //
    }
}
