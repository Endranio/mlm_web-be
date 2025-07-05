<?php

namespace App\Models;

use CodeIgniter\Model;

class WithdrawModel extends Model
{
    protected $table            = 'withdraw';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'user_id',
        'amount',
        'status',
        'requested_at'
    ];


    protected $useTimestamps    = false;

    protected $dateFormat       = 'datetime';
}
