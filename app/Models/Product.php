<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['picture_url'];

    protected $fillable = [
        'name',
        'price',
        'about',
        'picture',
        'category_id',
        'is_active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function getPictureUrlAttribute()
    {
        return asset($this->attributes['picture'] ? 'img/product/' . $this->attributes['picture'] : "/img/no-image.jpg");
    }

    public function getPriceFormattedAttribute()
    {
        return number_format($this->attributes['price'], 0, ",", ".");
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
