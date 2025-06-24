<?php
// app/Models/Negotiation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'buyer_id',
        'seller_id',
        'offer_price',
        'status',
        'counter_price', // PASTIKAN BARIS INI ADA
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}