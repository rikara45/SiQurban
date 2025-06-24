<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_item_id', // Tambahkan ini
        'user_id',
        'animal_id',
        'rating',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    // Tambahkan relasi ini
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}