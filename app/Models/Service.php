<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['reservation_id', 'service_date', 'next_service_date', 'status', 'note', 'fee', 'mechanic_id'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function mechanic()
    {
        return $this->hasOne(Mechanic::class, 'id', 'mechanic_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
