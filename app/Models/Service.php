<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'base_price',
        'expected_duration',
        'status',
    ];

    public function artist()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'service_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    // Relasi many-to-many untuk multiple categories dengan harga
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'service_categories', 'service_id', 'category_id')
                    ->withPivot('price')
                    ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'service_id');
    }
}
