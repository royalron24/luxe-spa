<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table      = 'bookings';
    protected $primaryKey = 'booking_id';

    protected $allowedFields = [
        'member_id',
        'service',
        'booking_date',
        'booking_time',
        'therapist',
        'duration',
        'notes',
        'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    protected $returnType = 'array';
}
