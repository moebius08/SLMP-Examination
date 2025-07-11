<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'website',
        'address',
        'company'
    ];

    protected $casts = [
        'address' => 'array',
        'company' => 'array'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
}
