<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banking extends Model
{
    use HasFactory;

    protected $table = 'banking';
    protected $fillable = [
        'transaction_code',
        'request_id',
        'user_id',
        'amount',
        'order_code',
        'total_item',
        'bank_id',
        'status'
    ];

}
