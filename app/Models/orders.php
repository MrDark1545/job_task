<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    use HasFactory;
    protected $fillable = [
        'Email_address',
        'Order_Status',
        'Order_Date',
        'quantity',
    ];
}
