<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Load database connection
        $db = \Config\Database::connect();

        // Truncate (hapus semua data)
        $db->table('balance_logs')->truncate();
        $db->table('users')->truncate();

        // Insert user data
        $userData = [
            [
                'username'    => 'user1',
                'pair_count'  => 3,
                'password'    => password_hash('password1', PASSWORD_DEFAULT),
                'sponsor_id'  => null,
                'upline_id'   => null,
                'position'    => 'left',
                'point_left'  => 100,
                'point_right' => 200,
                'saldo'       => 50000,
            ],
            [
                'username'    => 'user2',
                'pair_count'  => 1,
                'password'    => password_hash('password2', PASSWORD_DEFAULT),
                'sponsor_id'  => 1,
                'upline_id'   => 1,
                'position'    => 'right',
                'point_left'  => 50,
                'point_right' => 150,
                'saldo'       => 75000,
            ],
        ];

        $db->table('users')->insertBatch($userData);

        // Insert balance log data
        $balanceData = [
            [
                'user_id'         => 1,
                'type'            => 'credit',
                'from_source'     => 'pairing',
                'reference_table' => 'pairing_logs',
                'reference_id'    => 101,
                'amount'          => 25000,
                'created_by'      => 1,
                'updated_by'      => null,
                'deleted_by'      => null,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => null,
                'deleted_at'      => null,
            ],
            [
                'user_id'         => 2,
                'type'            => 'debit',
                'from_source'     => 'withdraw',
                'reference_table' => 'withdrawals',
                'reference_id'    => 202,
                'amount'          => 10000,
                'created_by'      => 2,
                'updated_by'      => null,
                'deleted_by'      => null,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => null,
                'deleted_at'      => null,
            ],
        ];

        $db->table('balance_logs')->insertBatch($balanceData);
    }
}
