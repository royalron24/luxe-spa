<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';

    protected $allowedFields = [
        'full_name',
        'email',
        'password',
        'phone'
    ];

    protected $returnType = 'array';
}