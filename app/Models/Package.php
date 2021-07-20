<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'about'];

    /**
     * The products that belong to the packacge.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'package_products', 'package_id', 'product_id');
    }
}
