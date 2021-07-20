<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guard = 'customer';
    protected $appends = ['photo_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'gender',
        'phone',
        'address',
        'photo'
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
        return asset($this->attributes['photo'] ? 'img/customer/' . $this->attributes['photo'] : "/img/ava.jpg");
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'customer_id', 'id');
    }
}
