<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_detail'; // Nama tabel yang sesuai dengan database

    protected $primaryKey = 'id_order_detail'; // Primary key tabel

    public $timestamps = false; // Jika tabel tidak memiliki kolom timestamps (created_at & updated_at)

    // Kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'id_order',
        'id_ticket',
        'qr_code',
    ];

    // Relasi ke tabel Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

    // Relasi ke tabel Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function ticketValidation()
    {
        return $this->hasOne(TicketValidation::class, 'id_order_detail', 'id_order_detail');
    }
}
