<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'type',
        'is_read'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'sender_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(Admin::class, 'recipient_id');
    }
}
