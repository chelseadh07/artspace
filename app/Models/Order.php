<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'client_id',
        'artist_id',
        'service_id',
        'description_request',
        'price',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function chats()
    {
        return $this->hasMany(OrderChat::class, 'order_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'order_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }
}
