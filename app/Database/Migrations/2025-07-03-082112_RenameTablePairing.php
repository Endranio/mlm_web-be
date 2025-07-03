<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameTablePairing extends Migration
{
    public function up()
    {
          $this->forge->renameTable('pairing-bonus', 'pairingBonus');
    }

    public function down()
    {
        //
    }
}
