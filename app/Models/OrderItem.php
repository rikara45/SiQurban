<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'animal_id',
        'seller_id',
        'price',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}