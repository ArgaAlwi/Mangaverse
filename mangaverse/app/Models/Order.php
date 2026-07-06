<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'invoice_number', 'recipient_name', 'phone_number', 
        'shipping_address', 'courier', 'shipping_cost', 'payment_method', 
        'payment_status', 'order_status', 'subtotal', 'total_amount', 'tracking_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}