<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'number_seat'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
