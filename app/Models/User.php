<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'avatar',
        'whatsapp_link',
        'phone_number'
    ];

    protected $hidden = [
        'password',
    ];

    // Artist -> banyak artworks
    public function artworks()
    {
        return $this->hasMany(Artwork::class, 'user_id');
    }

    // Artist -> banyak services
    public function services()
    {
        return $this->hasMany(Service::class, 'user_id');
    }

    // Client -> banyak orders
    public function clientOrders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    // Artist -> banyak orders masuk
    public function artistOrders()
    {
        return $this->hasMany(Order::class, 'artist_id');
    }

    // Chat sender
    public function chats()
    {
        return $this->hasMany(OrderChat::class, 'sender_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function invoicesAsArtist()
    {
        return $this->hasMany(Invoice::class, 'artist_id');
    }

    public function invoicesAsClient()
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }
}
