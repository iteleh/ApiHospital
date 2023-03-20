<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\appointment_booking;
use App\Models\payment_type;
use App\Models\payment_plan;
use App\Models\User;

class payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'appointment_id', 'payment_date', 'payment_type_id', 'payment_plan_id', 'amount_paid','status'];

    public function booking()
    {
        return $this->belongsTo(appointment_booking::class);
    }

    public function payment_types()
    {
        return $this->hasMany(payment_type::class);
    }

    public function payment_plans()
    {
        return $this->hasMany(payment_plan::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
