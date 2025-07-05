<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $allowedFields = [
        'username',
        'pair_count',
        'password',
        'sponsor_id',
        'upline_id',
        'position',
        'point_left',
        'point_right',
        'saldo',
        "pair_count"
    ];
    protected $returnType    = 'array';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
}