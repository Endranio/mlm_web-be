<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ===== USERS =====
        $users = [
            [
                'username'    => 'endra',
                'password'    => password_hash('rahasia123', PASSWORD_DEFAULT),
                'sponsor_id'  => null,
                'upline_id'   => null,
                'position'    => null,
                'point_left'  => 10,
                'point_right' => 5,
                'saldo'       => 100000,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'username'    => 'admin',
                'password'    => password_hash('admin123', PASSWORD_DEFAULT),
                'sponsor_id'  => null,
                'upline_id'   => null,
                'position'    => null,
                'point_left'  => 20,
                'point_right' => 15,
                'saldo'       => 500000,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];
$this->db->table('users')->truncate(); 
        $this->db->table('users')->insertBatch($users);

        // ===== PAIRING BONUS =====
        $pairing = [
            [
                'user_id'     => 1,
                'point_left'  => 10,
                'point_right' => 10,
                'bonus'       => 50000,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'     => 2,
                'point_left'  => 5,
                'point_right' => 5,
                'bonus'       => 25000,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];
$this->db->table('pairingBonus')->truncate(); 
        $this->db->table('pairingBonus')->insertBatch($pairing);

        // ===== WITHDRAW =====
        $withdraws = [
            [
                'user_id'      => 1,
                'amount'       => 20000,
                'status'       => 'approved',
                'requested_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'      => 2,
                'amount'       => 15000,
                'status'       => 'pending',
                'requested_at' => date('Y-m-d H:i:s'),
            ],
        ];
         

$this->db->table('withdraw')->truncate();       

        $this->db->table('withdraw')->insertBatch($withdraws);
    }
}
