<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $guarded = ['id'];
    protected $fillable = ['id', 'patient_id', 'clinic_id', 'user_id', 'treatment_id', 'created_at', 'updated_at'];
}
