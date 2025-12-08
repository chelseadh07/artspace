<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id';

    protected $fillable = [
        'order_id',
        'client_id',
        'artist_id',
        'rating',
        'comment',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }
}
