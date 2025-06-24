<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'order_number',
        'total_amount',
        'status',
    ];

    /**
     * Relasi ke user (pembeli).
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Relasi ke order items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke review (jika satu order hanya punya satu review).
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}