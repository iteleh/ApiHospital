<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\appointment_booking;


class appointment_type extends Model
{
    use HasFactory;

    protected $fillable = [ 'name' ];

    public function booking()
    {
        return $this->belongsTo(appointment_booking::class);
    }
}
