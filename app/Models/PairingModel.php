<?php

namespace App\Models;
use CodeIgniter\Model;
class PairingBonusModel extends Model
{
    protected $table            = 'pairing_bonus';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id',
        'point_left',
        'point_right',
        'bonus',
    ];

    
    protected $useTimestamps    = true;

    protected $dateFormat       = 'datetime';
}
