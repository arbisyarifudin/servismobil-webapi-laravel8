<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'package_id', 'vehicle_id', 'package_detail', 'vehicle_complaint', 'reservation_date', 'reservation_time', 'reservation_origin'];

    // public function getPackagePriceAttribute()
    // {
    //     return $this->package->products->sum('price');
    // }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }
}
