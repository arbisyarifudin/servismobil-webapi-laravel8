<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';
    protected $appends = ['photo_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'nin',
        'phone',
        'address',
        'photo',
        'level',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];


    public function getPhotoUrlAttribute()
    {
        return asset($this->attributes['photo'] ? 'img/admin/' . $this->attributes['photo'] : "/img/ava.jpg");
    }

    public function scopePerLevel($query)
    {
        $user = auth()->user();
        if ($user->level == 'Manager') {
            return $query->whereNotIn('level', ['Manager', 'Admin']);
        }
        return $query;
    }
}
