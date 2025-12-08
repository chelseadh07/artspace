<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'name',
        'description',
    ];

    public function artworks()
    {
        return $this->hasMany(Artwork::class, 'category_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
