<?php

namespace App\Models;

use CodeIgniter\Model;

class BalanceLogsModel extends Model
{
    protected $table            = 'balance_logs';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    
    
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'user_id',
        'type',             
        'from_source',      
        'reference_table',
        'reference_id',
        'amount',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    
}
