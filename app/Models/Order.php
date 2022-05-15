<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'qr_code',
        'sum'
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function ticket()
    {
        return $this->hasToMany(Ticket::class);
    }
}
