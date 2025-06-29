<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Animal;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi yang mendefinisikan bahwa User (sebagai Penjual) dapat memiliki banyak Animal.
     */
    public function animals()
    {
        return $this->hasMany(Animal::class, 'user_id');
    }

    /**
     * Relasi yang mendefinisikan bahwa User (sebagai Pembeli) dapat memiliki banyak Order.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    /**
     * Relasi yang mendefinisikan penjualan yang diterima oleh User (sebagai Penjual).
     * Relasi ini melalui tabel OrderItem.
     */
    public function sales()
    {
        return $this->hasMany(OrderItem::class, 'seller_id');
    }
}
