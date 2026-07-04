<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'member_id';

    protected $allowedFields = [
        'member_code',
        'full_name',
        'email',
        'password',
        'phone',
        'gender',
        'membership',
        'member_type',
        'status',
        'join_date',
        'profile_picture'
    ];

    protected $returnType = 'array';
}