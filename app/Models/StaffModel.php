<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table      = 'staff';
    protected $primaryKey = 'staff_id';

    protected $allowedFields = [
        'full_name',
        'email',
        'phone',
        'position',
        'status',
        'join_date',
    ];

    protected $returnType = 'array';
}
