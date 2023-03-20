<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\payment;

class payment_plan extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function payments()
    {
        return $this->hasMany(payment::class);
    }
}
