<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $guarded = ['id'];
    protected $fillable = ['id', 'patient_code', 'name', 'nric', 'clinic_id', 'psp_reg', 'status', 'created_at', 'updated_at'];
}
