<?php

namespace App\Models;

use CodeIgniter\Model;

class RevenueModel extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'payment_id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'member_id',

        'service',

        'amount',

        'payment_date',

        'payment_method',

        'payment_status'

    ];
}