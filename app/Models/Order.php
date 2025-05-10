<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Menentukan primary key yang digunakan
    protected $primaryKey = 'id_order';

    // Kolom yang bisa diisi
    protected $fillable = [
        'id_user',
        'id_event',
        'id_ticket',
        'quantity',
        'total_price',
        'payment_proof',
        'status',
    ];

    // Relasi dengan Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket',);
    }

    // Relasi dengan Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi dengan OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
}
