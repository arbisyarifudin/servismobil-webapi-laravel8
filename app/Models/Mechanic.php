<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    protected $appends = ['photo_url'];

    protected $fillable = ['name', 'nin', 'phone',  'address', 'photo', 'is_active'];

    /**
     * add custom attribute to photo_url.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getPhotoUrlAttribute()
    {
        return asset($this->attributes['photo'] ? 'img/mechanic/' . $this->attributes['photo'] : "/img/ava.jpg");
    }

    /**
     * Scope a query to only include active mechanic.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
