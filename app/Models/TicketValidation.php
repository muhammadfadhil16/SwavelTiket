<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketValidation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticket_validation';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_ticketvalidation';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_order',
        'id_ticket',
        'id_order_detail',
        'is_valid',
        'validation_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_valid' => 'boolean',
        'validation_date' => 'datetime',
    ];

    /**
     * Define the relationship with the Order model.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    /**
     * Define the relationship with the Ticket model.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

    /**
     * Define the relationship with the OrderDetail model.
     */
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'id_order_detail', 'id_order_detail');
    }
}
