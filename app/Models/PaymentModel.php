<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';

    protected $allowedFields = [
        'member_id',
        'service',
        'amount',
        'payment_date',
        'payment_method',
        'payment_status'
    ];

    protected $returnType = 'array';
}