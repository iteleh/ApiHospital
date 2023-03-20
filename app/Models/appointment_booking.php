<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\appointment_type;
use App\Models\payment;


class appointment_booking extends Model
{
    use HasFactory;

    protected $fillable = ['appointment_date', 'appointment_time', 'user_id', 'appointment_type_id', 'contact_address', 'complaint','status'];

    public function appointment_types()
    {
        return $this->hasMany(appointment_type::class);
    }
    public function payments()
    {
        return $this->hasMany(payment::class);
    }

}
