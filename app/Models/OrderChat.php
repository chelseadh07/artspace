<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderChat extends Model
{
    use HasFactory;

    protected $primaryKey = 'chat_id';

    protected $fillable = [
        'order_id',
        'sender_id',
        'message',
        'file_url',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
