<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'category_id', 'name', 'age', 'weight', 'price', 'description', 'status'];

    public function user() // Penjual
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(AnimalPhoto::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // FUNGSI BARU UNTUK RATING
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function getAverageRatingAttribute()
    {
        return number_format($this->averageRating(), 1);
    }
}