<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'admin_id',
        'bill',
        'pay',
        'change',
        'method',
        'note',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
